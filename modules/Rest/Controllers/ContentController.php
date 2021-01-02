<?php
namespace Modules\Rest\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Guesthouse\Models\Guesthouse;
use Modules\Hike\Models\Hike;
use Modules\Hike\Models\HikeCategory;
use Modules\News\Models\News;
use Modules\News\Models\NewsCategory;
use Modules\News\Models\Tag;
use Modules\Review\Models\Review;
use Modules\Tour\Models\Tour;
use Modules\Tour\Models\TourCategory;

class ContentController extends Controller{

    /*
     * Register the class to make it accessible as featured item
     * in mobile application. If class isn't registered api will send
     * 404
     * */
    private $guesthouse, $hike, $tour, $news;
    private $hikeCategory, $tourCategory, $newsCategory;

    public function __construct(){
        $this->guesthouse = Guesthouse::class;
        $this->hike = Hike::class;
        $this->tour = Tour::class;
        $this->news = News::class;

        $this->hikeCategory = HikeCategory::class;
        $this->tourCategory = TourCategory::class;
        $this->newsCategory = NewsCategory::class;
    }

    public function featured(Request $request, $service){

        $service = strtolower($service);
        if(!property_exists($this, $service)){
            return $this->sendError(__("Unknown module"));
        }

        if(method_exists($this, $service. 'Featured')){
            $featured = $this->{$service . 'Featured'}();
        }else{
            $featured = $this->{$service}::where(['status' => 'publish'])
                ->orderBy('is_featured', 'DESC')
                ->with(['translations'])
                ->take(10)->get();

            $featured = $featured->map(function($item){
                $item->thumbnail = get_file_url($item->image_id, 'medium');
                $item->banner = get_file_url($item->banner_image_id, 'medium');
                $item->gallery = $item->getGallery();
                return $item;
            });
        }
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
                $item->thumbnail = get_file_url($item->image_id, 'medium');
                $item->banner = get_file_url($item->banner_image_id, 'medium');
                $item->gallery = $item->getGallery();
                return $item;
            });
        }

        return response()->json($data);
    }

    public function detail(Request $request, $service, $id){
        $service = strtolower($service);
        if(!property_exists($this, $service)){
            return $this->sendError(__("Unknown module"));
        }

        return $this->{$service}($id);
    }

    public function guesthouse($id){
        $row = $this->guesthouse::where('id', $id)->with(['rooms', 'location','translations','hasWishList'])->first();

        $row->thumbnail = get_file_url($row->image_id, 'medium');
        $row->banner = get_file_url($row->banner_image_id, 'medium');
        $row->gallery = $row->getGallery();

        foreach($row->rooms as $room){
            $room->thumbnail = get_file_url($room->image_id, 'medium');
            $room->banner = get_file_url($room->banner_image_id, 'medium');
            $room->gallery = $room->getGallery();
        }

        if ( empty($row) or !$row->hasPermissionDetailView()) {
            return $this->sendError(__("No Detailed view permiited"));
        }
        $translation = $row->translateOrOrigin(app()->getLocale());
        $location_id = $row->location_id;

        $related = [];
        if (!empty($location_id)) {
            $related['guesthouse_related'] = $this->guesthouse::where('location_id', $location_id)->where("status", "publish")->take(4)->whereNotIn('id', [$row->id])->with(['location','translations','hasWishList'])->get();
            $related['hike_related'] = Hike::where('location_id', $location_id)->where("status", "publish")->take(4)->with(['translations'])->get();
            $related['tour_related'] = Tour::where('location_id', $location_id)->where("status", "publish")->take(4)->with(['translations'])->get();

            foreach($related as $serviceName => $relatedItems){
                $relatedItems = $relatedItems->map(function($i){
                    $i->thumbnail = get_file_url($i->image_id, 'medium');
                    $i->banner = get_file_url($i->banner_image_id, 'medium');
                    $i->gallery = $i->getGallery();
                    return $i;
                });
            }
        }
        $review_list = Review::where('object_id', $row->id)->where('object_model', 'guesthouse')->where("status", "approved")->orderBy("id", "desc")->with('author')->paginate(setting_item('guesthouse_review_number_per_page', 5));
        $data = [
            'row'          => $row,
            'translation'  => $translation,
            'booking_data' => $row->getBookingData(),
            'review_list'  => $review_list,
        ];

        $data = array_merge($data, $related);
        return response()->json($data);
    }

    public function hike($id){
        $row = Hike::where('id', $id)->with(['location','translations','hasWishList', 'author'])->first();

        if (empty($row) or !$row->hasPermissionDetailView()) {
            return $this->sendError(__("No Detailed view permiited"));
        }

        $row->thumbnail = get_file_url($row->image_id, 'medium');
        $row->banner = get_file_url($row->banner_image_id, 'medium');
        $row->gallery = $row->getGallery();

        $translation = $row->translateOrOrigin(app()->getLocale());
        $location_id = $row->location_id;

        $related = [];
        if (!empty($location_id)) {
            $related['guesthouse_related'] = Guesthouse::where('location_id', $location_id)->where("status", "publish")->take(4)->with(['location','translations','hasWishList'])->get();
            $related['hike_related'] = Hike::where('location_id', $location_id)->where("status", "publish")->whereNotIn('id', [$row->id])->take(4)->with(['translations'])->get();
            $related['tour_related'] = Tour::where('location_id', $location_id)->where("status", "publish")->take(4)->with(['translations'])->get();

            foreach($related as $serviceName => $relatedItems){
                $relatedItems = $relatedItems->map(function($i){
                    $i->thumbnail = get_file_url($i->image_id, 'medium');
                    $i->banner = get_file_url($i->banner_image_id, 'medium');
                    $i->gallery = $i->getGallery();
                    return $i;
                });
            }
        }
        $review_list = Review::where('object_id', $row->id)->where('object_model', 'hike')->where("status", "approved")->orderBy("id", "desc")->with('author')->paginate(setting_item('guesthouse_review_number_per_page', 5));
        $data = [
            'row'          => $row,
            'translation'  => $translation,
            'booking_data' => $row->getBookingData(),
            'review_list'  => $review_list,
        ];

        $data = array_merge($data, $related);
        return response()->json($data);
    }

    public function tour($id){
        $row = $this->tour::where('id', $id)->with(['location','translations','hasWishList'])->first();

        $row->thumbnail = get_file_url($row->image_id, 'medium');
        $row->banner = get_file_url($row->banner_image_id, 'medium');
        $row->gallery = $row->getGallery();

        $row->itinerary = $row->itinerary ? array_map(function ($i){
            $i['thumbnail'] = get_file_url($i['image_id'], 'medium');
            return $i;
        }, $row->itinerary): null;

        $translation = $row->translateOrOrigin(app()->getLocale());
        $location_id = $row->location_id;

        $related = [];
        if (!empty($location_id)) {
            $related['guesthouse_related'] = Guesthouse::where('location_id', $location_id)->where("status", "publish")->take(4)->with(['location','translations','hasWishList'])->get();
            $related['hike_related'] = Hike::where('location_id', $location_id)->where("status", "publish")->whereNotIn('id', [$row->id])->take(4)->with(['translations'])->get();
            $related['tour_related'] = $this->tour::where('location_id', $location_id)->where("status","publish")->take(4)->whereNotIn('id', [$row->id])->with(['location','translations','hasWishList'])->get();

            foreach($related as $serviceName => $relatedItems){
                $relatedItems = $relatedItems->map(function($i){
                    $i->thumbnail = get_file_url($i->image_id, 'medium');
                    $i->banner = get_file_url($i->banner_image_id, 'medium');
                    $i->gallery = $i->getGallery();
                    return $i;
                });
            }
        }

        $review_list = Review::where('object_id', $row->id)
            ->where('object_model', 'tour')
            ->where("status", "approved")
            ->orderBy("id", "desc")
            ->with('author')
            ->paginate(setting_item('tour_review_number_per_page', 5));

        $data = [
            'row' => $row,
            'translation' => $translation,
            'booking_data' => $row->getBookingData(),
            'review_list' => $review_list,
        ];
        $data = array_merge($data, $related);
        return response()->json($data);
    }

    public function news($id)
    {
        $row = $this->news::with(['cat'])->where('id', $id)->where('status','publish')->first();
        $row->thumbnail = get_file_url($row->image_id, 'medium');
        $row->banner = get_file_url($row->banner_image_id, 'medium');

        if (empty($row)) {
            return $this->sendError(__("Not found"));
        }
        $translation = $row->translateOrOrigin(app()->getLocale());

        $related = [];
        if (!empty($row->location_id)) {
            $related['guesthouse_related'] = Guesthouse::where('location_id', $row->location_id)->where("status", "publish")->take(4)->with(['location','translations','hasWishList'])->get();
            $related['hike_related'] = Hike::where('location_id', $row->location_id)->where("status", "publish")->whereNotIn('id', [$row->id])->take(4)->with(['translations'])->get();
            $related['tour_related'] = Tour::where('location_id', $row->location_id)->where("status", "publish")->take(4)->with(['translations'])->get();

            foreach($related as $serviceName => $relatedItems){
                $relatedItems = $relatedItems->map(function($i){
                    $i->thumbnail = get_file_url($i->image_id, 'medium');
                    $i->banner = get_file_url($i->banner_image_id, 'medium');
                    $i->gallery = $i->getGallery();
                    return $i;
                });
            }
        }
        $review_list = Review::where('object_id', $row->id)->where('object_model', 'hike')->where("status", "approved")->orderBy("id", "desc")->with('author')->paginate(setting_item('guesthouse_review_number_per_page', 5));
        $data = [
            'row'          => $row,
            'translation'  => $translation,
            'review_list'  => $review_list,
        ];

        $data = [
            'row'               => $row,
            'translation'       => $translation,
            'model_category'    => NewsCategory::where("status", "publish"),
            'model_tag'         => Tag::query(),
            'model_news'        => $this->news::where("status", "publish")->take(4)->get(),
        ];

        $data = array_merge($data, $related);
        return response()->json($data);
    }

    public function newsFeatured(){
        $data = $this->news::with(['cat'])->where(['status' => 'publish'])->orderBy('id', 'desc')
            ->take(10)->get();

        return $data->map(function($item){
            $item->thumbnail = get_file_url($item->image_id, 'medium');
            $item->banner = get_file_url($item->banner_image_id, 'medium');
            return $item;
        });
    }

    public function category($service){
        $service = strtolower($service);
        if(!property_exists($this, $service . 'Category')){
            return $this->sendError(__("Unknown module"));
        }

        $data = $this->{ $service . 'Category' }::where(['status' => 'publish'])->get();
        return response()->json($data);
    }
}
