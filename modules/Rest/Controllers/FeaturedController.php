<?php
namespace Modules\Rest\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Guesthouse\Models\Guesthouse;
use Modules\Hike\Models\Hike;
use Modules\Review\Models\Review;
use Modules\Tour\Models\Tour;

class FeaturedController extends Controller{

    /*
     * Register the class to make it accessible as featured item
     * in mobile application. If class isn't registered api will send
     * 404
     * */
    private $guesthouse, $hike, $tour;

    public function __construct(){
        $this->guesthouse = Guesthouse::class;
        $this->hike = Hike::class;
        $this->tour = Tour::class;
    }

    public function index(Request $request, $service){

        $service = strtolower($service);
        if(!property_exists($this, $service)){
            return $this->sendError(__("Unknown module"));
        }

        $featured = $this->{$service}::orderby('is_featured', 'DESC')
            ->with(['translations'])
            ->where("status", "publish")
            ->take(10)->get();

        $featured = $featured->map(function($item){
            $item->thumbnail = get_file_url($item->image_id);
            $item->banner = get_file_url($item->banner_image_id);
            $item->gallery = $item->getGallery();
            return $item;
        });
        return response()->json($featured);
    }

    public function related(Request $request, $service, $location){
        $guesthouse_related = $this->guesthouse::where('location_id', $location)->where("status", "publish")->take(4)->get();
        $hike_related = Hike::where('location_id', $location)->where("status", "publish")->take(4)->get();
        $tour_related = Tour::where('location_id', $location)->where("status", "publish")->take(4)->get();

        $data = [
            'guesthouse' => $guesthouse_related,
            'hike' => $hike_related,
            'tour' => $tour_related,
        ];

        foreach($data as $service){
            $service = $service->map(function($item){
                $item->thumbnail = get_file_url($item->image_id);
                $item->banner = get_file_url($item->banner_image_id);
                $item->gallery = $item->getGallery();
                return $item;
            });
        }

        return response()->json($data);
    }

    public function detail(Request $request, $service, $slug){
        $row = $this->guesthouse::where('slug', $slug)->with(['location','translations','hasWishList'])->first();
        if ( empty($row) or !$row->hasPermissionDetailView()) {
            return $this->sendError(__("No Detailed view permiited"));
        }
        $translation = $row->translateOrOrigin(app()->getLocale());
        $guesthouse_related = [];
        $tour_related = false;
        $hike_related = false;
        $location_id = $row->location_id;
        if (!empty($location_id)) {
            $guesthouse_related = $this->guesthouse::where('location_id', $location_id)->where("status", "publish")->take(4)->whereNotIn('id', [$row->id])->with(['location','translations','hasWishList'])->get();
            $hike_related = Hike::where('location_id', $location_id)->where("status", "publish")->take(4)->with(['translations']);
            $tour_related = Tour::where('location_id', $location_id)->where("status", "publish")->take(4)->with(['translations']);
        }
        $review_list = Review::where('object_id', $row->id)->where('object_model', 'guesthouse')->where("status", "approved")->orderBy("id", "desc")->with('author')->paginate(setting_item('guesthouse_review_number_per_page', 5));
        $data = [
            'row'          => $row,
            'translation'  => $translation,
            'guesthouse_related' => $guesthouse_related,
            'tour_related' => $tour_related,
            'hike_related' => $hike_related,
            'booking_data' => $row->getBookingData(),
            'review_list'  => $review_list,
            'seo_meta'  => $row->getSeoMetaWithTranslation(app()->getLocale(),$translation),
            'body_class'=>'is_single'
        ];
        return response()->json($data);
    }
}
