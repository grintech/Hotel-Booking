<?php
namespace Modules\Guesthouse\Controllers;

use App\Http\Controllers\Controller;
use Modules\Guesthouse\Models\Guesthouse;
use Illuminate\Http\Request;
use Modules\Location\Models\Location;
use Modules\Review\Models\Review;
use Modules\Core\Models\Attributes;
use DB;

class GuesthouseController extends Controller
{
    protected $guesthouseClass;
    protected $locationClass;
    public function __construct()
    {
        $this->guesthouseClass = Guesthouse::class;
        $this->locationClass = Location::class;
    }
    public function callAction($method, $parameters)
    {
        if(!Guesthouse::isEnable())
        {
            return redirect('/');
        }
        return parent::callAction($method, $parameters); // TODO: Change the autogenerated stub
    }

    public function index(Request $request)
    {
        $is_ajax = $request->query('_ajax');
        $list = call_user_func([$this->guesthouseClass,'search'],$request);
        $markers = [];
            if (!empty($list)) {
                foreach ($list as $row) {
                    $markers[] = [
                        "id"      => $row->id,
                        "title"   => $row->title,
                        "lat"     => (float)$row->map_lat,
                        "lng"     => (float)$row->map_lng,
                        "gallery" => $row->getGallery(true),
                        "infobox" => view('Guesthouse::frontend.layouts.search.loop-grid', ['row' => $row,'disable_lazyload'=>1,'wrap_class'=>'infobox-item'])->render(),
                        'marker'  => url('images/icons/png/pin.png'),
                    ];
                }
            }
        $limit_location = 15;
        if( empty(setting_item("guesthouse_location_search_style")) or setting_item("guesthouse_location_search_style") == "normal" ){
            $limit_location = 1000;
        }
        $data = [
            'rows'               => $list,
            'list_location'      => $this->locationClass::where('status', 'publish')->limit($limit_location)->with(['translations'])->get()->toTree(),
            'guesthouse_min_max_price' => $this->guesthouseClass::getMinMaxPrice(),
            'markers'            => $markers,
            "blank"              => 1,
            "seo_meta"           => $this->guesthouseClass::getSeoMetaForPageList()
        ];
        $layout = setting_item("guesthouse_layout_search", 'normal');
        if ($request->query('_layout')) {
            $layout = $request->query('_layout');
        }
        if ($is_ajax) {
            return $this->sendSuccess([
                'html'    => view('Guesthouse::frontend.layouts.search-map.list-item', $data)->render(),
                "markers" => $data['markers']
            ]);
        }
        $data['attributes'] = Attributes::where('service', 'guesthouse')->with(['terms','translations'])->get();

        if ($layout == "map") {
            $data['body_class'] = 'has-search-map';
            $data['html_class'] = 'full-page';
            return view('Guesthouse::frontend.search-map', $data);
        }
        return view('Guesthouse::frontend.search', $data);
    }

    public function detail(Request $request, $slug)
    {
        $row = $this->guesthouseClass::where('slug', $slug)->with(['location','translations','hasWishList'])->first();;
        if ( empty($row) or !$row->hasPermissionDetailView()) {
            return redirect('/');
        }
        $translation = $row->translateOrOrigin(app()->getLocale());
        $guesthouse_related = [];
        $location_id = $row->location_id;
        if (!empty($location_id)) {
            $guesthouse_related = $this->guesthouseClass::where('location_id', $location_id)->where("status", "publish")->take(4)->whereNotIn('id', [$row->id])->with(['location','translations','hasWishList'])->get();
        }
        $review_list = Review::where('object_id', $row->id)->where('object_model', 'guesthouse')->where("status", "approved")->orderBy("id", "desc")->with('author')->paginate(setting_item('guesthouse_review_number_per_page', 5));
        $data = [
            'row'          => $row,
            'translation'       => $translation,
            'hotel_related' => $guesthouse_related,
            'booking_data' => $row->getBookingData(),
            'review_list'  => $review_list,
            'seo_meta'  => $row->getSeoMetaWithTranslation(app()->getLocale(),$translation),
            'body_class'=>'is_single'
        ];
        $this->setActiveMenu($row);
        return view('Guesthouse::frontend.detail', $data);
    }

    public function checkAvailability(){
        $guesthouse_id = \request('guesthouse_id');

        if(!\request()->input('firstLoad')) {
            request()->validate([
                'guesthouse_id'   => 'required',
                'start_date' => 'required:date_format:Y-m-d',
                'end_date'   => 'required:date_format:Y-m-d',
                'adults'     => 'required',
            ]);

            if(strtotime(\request('end_date')) - strtotime(\request('start_date')) < DAY_IN_SECONDS){
                return $this->sendError(__("Dates are not valid"));
            }
            if(strtotime(\request('end_date')) - strtotime(\request('start_date')) > 30*DAY_IN_SECONDS){
                return $this->sendError(__("Maximum day for booking is 30"));
            }
        }

        $guesthouse = $this->guesthouseClass::find($guesthouse_id);
        if(empty($guesthouse_id) or empty($guesthouse)){
            return $this->sendError(__("Guesthouse not found"));
        }

        $rooms = $guesthouse->getRoomsAvailability(request()->input());

        return $this->sendSuccess([
            'rooms'=>$rooms
        ]);
    }
}
