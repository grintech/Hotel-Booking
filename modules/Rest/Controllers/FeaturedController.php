<?php
namespace Modules\Rest\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Guesthouse\Models\Guesthouse;
use Modules\Hike\Models\Hike;
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
}
