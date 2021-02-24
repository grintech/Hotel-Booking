<?php

    namespace Modules\Tour\Controllers;
    use App\Http\Controllers\Controller;
    use Modules\Guesthouse\Models\Guesthouse;
    use Modules\Hike\Models\Hike;
    use Modules\Tour\Models\Tour;
    use Illuminate\Http\Request;
    use Modules\Tour\Models\TourCategory;
    use Modules\Location\Models\Location;
    use Modules\Review\Models\Review;
    use Modules\Core\Models\Attributes;
    use DB;

    class TourController extends Controller
    {
        protected $tourClass;
        protected $locationClass;
        protected $tourCategoryClass;
        protected $attributesClass;

        public function __construct()
        {
            $this->tourClass = Tour::class;
            $this->locationClass = Location::class;
            $this->tourCategoryClass = TourCategory::class;
            $this->attributesClass = Attributes::class;
        }
        public function callAction($method, $parameters)
        {
            if(setting_item('tour_disable'))
            {
                return redirect('/');
            }
            return parent::callAction($method, $parameters); // TODO: Change the autogenerated stub
        }

        public function index(Request $request)
        {
            $is_ajax = $request->query('_ajax');
            $list = call_user_func([$this->tourClass,'search'],$request);
            $markers = [];
            if (!empty($list)) {
                foreach ($list as $row) {
                    $markers[] = [
                        "id" => $row->id,
                        "title" => $row->title,
                        "lat" => (float)$row->map_lat,
                        "lng" => (float)$row->map_lng,
                        "gallery" => $row->getGallery(true),
                        "infobox" => view('Tour::frontend.layouts.search.loop-gird', ['row' => $row, 'disable_lazyload' => 1, 'wrap_class' => 'infobox-item'])->render(),
                        'marker' => url('images/icons/png/pin.png'),
                    ];
                }
            }
            $limit_location = 15;
            if( empty(setting_item("space_location_search_style")) or setting_item("space_location_search_style") == "normal" ){
                $limit_location = 1000;
            }
            $data = [
                'rows' => $list,
                'tour_category' => $this->tourCategoryClass::where('status', 'publish')->with(['translations'])->get()->toTree(),
                'tour_location' => $this->locationClass::where('status', 'publish')->with(['translations'])->limit($limit_location)->get()->toTree(),
                'tour_min_max_price' => $this->tourClass::getMinMaxPrice(),
                'markers' => $markers,
                "blank" => 1,
                "seo_meta" => $this->tourClass::getSeoMetaForPageList()
            ];
            $layout = setting_item("tour_layout_search", 'normal');
            if ($request->query('_layout')) {
                $layout = $request->query('_layout');
            }
            if ($is_ajax) {
                return $this->sendSuccess([
                    'html' => view('Tour::frontend.layouts.search-map.list-item', $data)->render(),
                    "markers" => $data['markers']
                ]);
            }
            $data['attributes'] = $this->attributesClass::where('service', 'tour')->with(['terms','translations'])->get();
            if ($layout == "map") {
                $data['body_class'] = 'has-search-map';
                $data['html_class'] = 'full-page';
                return view('Tour::frontend.search-map', $data);
            }
            return view('Tour::frontend.search', $data);
        }

        public function detail(Request $request, $slug)
        {
            $row = $this->tourClass::where('slug', $slug)->with(['location','translations','hasWishList'])->first();
            if ( empty($row) or !$row->hasPermissionDetailView()) {
                return redirect('/');
            }
            $translation = $row->translateOrOrigin(app()->getLocale());
            $tour_related = false;
            $guesthouse_related = false;
            $hike_related = false;
            $location_id = $row->location_id;
            if (!empty($location_id)) {
                $tour_related = $this->tourClass::where('location_id', $location_id)->where("status","publish")->take(4)->whereNotIn('id', [$row->id])->with(['location','translations','hasWishList'])->get();
                $guesthouse_related = Guesthouse::where('location_id', $location_id)->where("status","publish")->take(4)->with(['translations']);
                $hike_related = Hike::where('location_id', $location_id)->where("status","publish")->take(4)->with(['translations']);
            }
            $review_list = $row->getReviewList();
            $data = [
                'row' => $row,
                'translation' => $translation,
                'tour_related' => $tour_related,
                'guesthouse_related' => $guesthouse_related,
                'hike_related' => $hike_related,
                'booking_data' => $row->getBookingData(),
                'review_list' => $review_list,
                'seo_meta' => $row->getSeoMetaWithTranslation(app()->getLocale(), $translation),
                'body_class'=>'is_single'
            ];
            $this->setActiveMenu($row);
            return view('Tour::frontend.detail', $data);
        }
    }
