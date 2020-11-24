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

        $featured = $this->{$service}::orderby('is_featured', 'DESC')->take(10)->get();
        return response()->json($featured);
    }
}
