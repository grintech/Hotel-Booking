<?php
namespace Modules\Guesthouse;
use Modules\ModuleServiceProvider;
use Modules\Guesthouse\Models\Guesthouse;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){

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

    public static function getAdminMenu()
    {
        if(!Guesthouse::isEnable()) return [];
        return [
            'guesthouse'=>[
                "position"=>32,
                'url'        => 'admin/module/guesthouse',
                'title'      => __('Guesthouse'),
                'icon'       => 'fa fa-building-o',
                'permission' => 'guesthouse_view',
                'children'   => [
                    'add'=>[
                        'url'        => 'admin/module/guesthouse',
                        'title'      => __('All Guesthouses'),
                        'permission' => 'guesthouse_view',
                    ],
                    'create'=>[
                        'url'        => 'admin/module/guesthouse/create',
                        'title'      => __('Add new Guesthouse'),
                        'permission' => 'guesthouse_create',
                    ],
                    'attribute'=>[
                        'url'        => 'admin/module/guesthouse/attribute',
                        'title'      => __('Attributes'),
                        'permission' => 'guesthouse_manage_attributes',
                    ],
                    'room_attribute'=>[
                        'url'        => 'admin/module/guesthouse/room/attribute',
                        'title'      => __('Room Attributes'),
                        'permission' => 'guesthouse_manage_attributes',
                    ],
                ]
            ]
        ];
    }

    public static function getBookableServices()
    {
        if(!Guesthouse::isEnable()) return [];
        return [
            'guesthouse'=>Guesthouse::class
        ];
    }

    public static function getMenuBuilderTypes()
    {
        if(!Guesthouse::isEnable()) return [];
        return [
            'guesthouse'=>[
                'class' => Guesthouse::class,
                'name'  => __("Guesthouse"),
                'items' => Guesthouse::searchForMenu(),
                'position'=>41
            ]
        ];
    }


    public static function getUserMenu()
    {
        $res = [];
        if(Guesthouse::isEnable()){
            $res['guesthouse'] = [
                'url'   => route('guesthouse.vendor.index'),
                'title'      => __("Manage Guesthouse"),
                'icon'       => Guesthouse::getServiceIconFeatured(),
                'position'   => 30,
                'permission' => 'guesthouse_view',
                'children' => [
                    [
                        'url'   => route('guesthouse.vendor.index'),
                        'title'  => __("All Guesthouses"),
                    ],
                    [
                        'url'   => route('guesthouse.vendor.create'),
                        'title'      => __("Add Guesthouse"),
                        'permission' => 'guesthouse_create',
                    ],
                    [
                        'url'   => route('guesthouse.vendor.booking_report'),
                        'title'      => __("Booking Report"),
                        'permission' => 'guesthouse_view',
                    ],
                ]
            ];

            $res['guesthouse_new'] = [
                'url'   => route('guesthouse.vendor.index'),
                'title'      => __("My Guesthouse"),
                'icon'       => Guesthouse::getServiceIconFeatured(),
                'position'   => 31,
                'permission' => 'guesthouse_view',
            ];
        }
        return $res;
    }

    public static function getTemplateBlocks(){
        if(!Guesthouse::isEnable()) return [];
        return [
            'form_search_guesthouse'=>"\\Modules\\Guesthouse\\Blocks\\FormSearchGuesthouse",
            'list_guesthouse'=>"\\Modules\\Guesthouse\\Blocks\\ListGuesthouse",
        ];
    }
}
