<?php
namespace Modules\Hike;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Modules\Hike\Models\Hike;
use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

    public static function getBookableServices()
    {
        return [
            'hike' => Hike::class,
        ];
    }

    public static function getAdminMenu()
    {
        $res = [];
        if(!Hike::isEnable()){
            Log::info('Hike not enabled');
            return [];
        }
        return [
            'car'=>[
                "position"=> 62,
                'url'        => 'admin/module/hike',
                'title'      => __("Hike"),
                'icon'       => 'icon ion-md-umbrella',
                'permission' => 'hike_view',
                'children'   => [
                    'hike_view'=>[
                        'url'        => 'admin/module/hike',
                        'title'      => __('All Hikes'),
                        'permission' => 'hike_view',
                    ],
                    'hike_create'=>[
                        'url'        => 'admin/module/hike/create',
                        'title'      => __("Add Hike"),
                        'permission' => 'hike_create',
                    ],
                    'hike_category'=>[
                        'url'        => 'admin/module/hike/category',
                        'title'      => __('Categories'),
                        'permission' => 'hike_manage_others',
                    ],
                    'hike_attribute'=>[
                        'url'        => 'admin/module/hike/attribute',
                        'title'      => __('Attributes'),
                        'permission' => 'hike_manage_attributes',
                    ],
                    'hike_availability'=>[
                        'url'        => 'admin/module/hike/availability',
                        'title'      => __('Availability'),
                        'permission' => 'hike_create',
                    ],
                    'hike_booking'=>[
                        'url'        => 'admin/module/hike/booking',
                        'title'      => __('Booking Calendar'),
                        'permission' => 'hike_create',
                    ],
                ]
            ]
        ];
    }


    public static function getUserMenu()
    {
        $res = [];
        if(Hike::isEnable()){
            $res['hike'] = [
                'url'   => route('hike.vendor.index'),
                'title'      => __("Manage Hike"),
                'icon'       => Hike::getServiceIconFeatured(),
                'permission' => 'hike_view',
                'position'   => 31,
                'children'   => [
                    [
                        'url'   => route('hike.vendor.index'),
                        'title' => __("All Hikes"),
                    ],
                    [
                        'url'        => route('hike.vendor.create'),
                        'title'      => __("Add Hike"),
                        'permission' => 'hike_create',
                    ],
                    [
                        'url'        => route('hike.vendor.availability.index'),
                        'title'      => __("Availability"),
                        'permission' => 'hike_create',
                    ],
                    [
                        'url'        => route('hike.vendor.booking_report'),
                        'title'      => __("Booking Report"),
                        'permission' => 'hike_view',
                    ],
                ]
            ];
        }
        return $res;
    }

    public static function getMenuBuilderTypes()
    {
        if(!Hike::isEnable()) return [];

        return [
            [
                'class' => \Modules\Hike\Models\Hike::class,
                'name'  => __("Hike"),
                'items' => \Modules\Hike\Models\Hike::searchForMenu(),
                'position'=>20
            ],
            [
                'class' => \Modules\Hike\Models\HikeCategory::class,
                'name'  => __("Hike Category"),
                'items' => \Modules\Hike\Models\HikeCategory::searchForMenu(),
                'position'=>30
            ],
        ];
    }

    public static function getTemplateBlocks(){
        if(!Hike::isEnable()) return [];

        return [
            'list_hikes'=>"\\Modules\\Hike\\Blocks\\ListHikes",
            'form_search_hike'=>"\\Modules\\Hike\\Blocks\\FormSearchHike",
        ];
    }
}
