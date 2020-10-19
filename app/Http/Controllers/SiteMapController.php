<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Modules\Guesthouse\Models\Guesthouse;
use Modules\Hike\Models\Hike;
use Modules\Location\Models\Location;
use Modules\News\Models\News;
use Modules\Tour\Models\Tour;
use Carbon\Carbon;

class SiteMapController extends Controller
{
    public $columns;
    public $services;

    public function __construct(){
        $this->columns = ['id', 'updated_at', 'slug'];
        $this->services = ['guesthouse', 'hike', 'tour', 'news'];
    }

    public function sitemap(){
        $services = [];
        $services['guesthouse.detail'] = Guesthouse::where(['status' => 'publish'])->get($this->columns);
        $services['hike.detail'] = Hike::where(['status' => 'publish'])->get($this->columns);
        $services['tour.detail'] = Tour::where(['status' => 'publish'])->get($this->columns);
        $services['location.detail'] = Location::where(['status' => 'publish'])->get($this->columns);
        $services['news.detail'] = News::where(['status' => 'publish'])->get($this->columns);

        $last_update = Carbon::now()->toDateTimeString();

        //home page
        $data = [
            [
                'url' => route('home'),
                'modified' => Carbon::parse($last_update)->format('Y-m-d'),
                'priority' => 1,
                'frequency' => 'daily'
            ]
        ];

        //services page
        foreach($this->services as $service){
            switch ($service){
                case 'news':
                    $url = route($service . '.index');
                    break;
                default:
                    $url = route($service . '.search');
                    break;
            }
            array_push($data, $this->generate($url, $last_update, 1));
        }

        //services item detail pages
        foreach($services as $route => $service){
            foreach($service as $item){
                array_push($data, $this->generate(route($route , ['slug' => $item->slug]), $item->updated_at, 0.9));
            }
        }

        $sitemap = view('sitemap.sitemap', compact('data'))->render();

        return response($sitemap, 200, [
            'Content-Type' => 'application/xml'
        ]);

    }

    private function generate($url, $last_update, $priority, $frequency = 'daily'){
        return [
            'url' => $url,
            'modified' => Carbon::parse($last_update)->format('Y-m-d'),
            'priority' => $priority,
            'frequency' => $frequency
        ];
    }
}
