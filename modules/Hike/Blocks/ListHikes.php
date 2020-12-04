<?php
namespace Modules\Hike\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Hike\Models\Hike;
use Modules\Hike\Models\HikeCategory;
use Modules\Location\Models\Location;

class ListHikes extends BaseBlock
{
    function __construct()
    {
        $this->setOptions([
            'settings' => [
                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title')
                ],
                [
                    'id'        => 'desc',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Desc')
                ],
                [
                    'id'        => 'number',
                    'type'      => 'input',
                    'inputType' => 'number',
                    'label'     => __('Number Item')
                ],
                [
                    'id'            => 'style',
                    'type'          => 'radios',
                    'label'         => __('Style'),
                    'values'        => [
                        [
                            'value'   => 'normal',
                            'name' => __("Normal")
                        ],
                        [
                            'value'   => 'carousel',
                            'name' => __("Slider Carousel")
                        ],
                        [
                            'value'   => 'box_shadow',
                            'name' => __("Box Shadow")
                        ]
                    ]
                ],
                [
                    'id'      => 'category_id',
                    'type'    => 'select2',
                    'label'   => __('Filter by Category'),
                    'select2' => [
                        'ajax'  => [
                            'url'      => url('/admin/module/hike/category/getForSelect2'),
                            'dataType' => 'json'
                        ],
                        'width' => '100%',
                        'allowClear' => 'true',
                        'placeholder' => __('-- Select --')
                    ],
                    'pre_selected'=>url('/admin/module/hike/category/getForSelect2?pre_selected=1')
                ],
                [
                    'id'      => 'location_id',
                    'type'    => 'select2',
                    'label'   => __('Filter by Location'),
                    'select2' => [
                        'ajax'  => [
                            'url'      => url('/admin/module/location/getForSelect2'),
                            'dataType' => 'json'
                        ],
                        'width' => '100%',
                        'allowClear' => 'true',
                        'placeholder' => __('-- Select --')
                    ],
                    'pre_selected'=>url('/admin/module/location/getForSelect2?pre_selected=1')
                ],
                [
                    'id'            => 'order',
                    'type'          => 'radios',
                    'label'         => __('Order'),
                    'values'        => [
                        [
                            'value'   => 'id',
                            'name' => __("Date Create")
                        ],
                        [
                            'value'   => 'title',
                            'name' => __("Title")
                        ],
                    ]
                ],
                [
                    'id'            => 'order_by',
                    'type'          => 'radios',
                    'label'         => __('Order By'),
                    'values'        => [
                        [
                            'value'   => 'asc',
                            'name' => __("ASC")
                        ],
                        [
                            'value'   => 'desc',
                            'name' => __("DESC")
                        ],
                    ]
                ],
                [
                    'type'=> "checkbox",
                    'label'=>__("Only featured items?"),
                    'id'=> "is_featured",
                    'default'=>true
                ],
                [
                    'type'=> "checkbox",
                    'label'=>__("Show view more item?"),
                    'id'=> "show_more",
                    'default'=> true
                ],
                [
                    'id'    => 'background_image',
                    'type'  => 'uploader',
                    'label' => __('Background Image for view more card')
                ],
                [
                    'id'        => 'view_more_desc',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('View more desc')
                ]
            ]
        ]);
    }

    public function getName()
    {
        return __('Hike: List Items');
    }

    public function content($model = [])
    {
        $model_Hike = Hike::select("bravo_hikes.*")->with(['location','translations','hasWishList']);
        if(empty($model['order'])) $model['order'] = "id";
        if(empty($model['order_by'])) $model['order_by'] = "desc";
        if(empty($model['number'])) $model['number'] = 5;
        if (!empty($model['location_id'])) {
            $location = Location::where('id', $model['location_id'])->where("status","publish")->first();
            if(!empty($location)){
                $model_Hike->join('bravo_locations', function ($join) use ($location) {
                    $join->on('bravo_locations.id', '=', 'bravo_hikes.location_id')
                        ->where('bravo_locations._lft', '>=', $location->_lft)
                        ->where('bravo_locations._rgt', '<=', $location->_rgt);
                });
            }
        }
        if (!empty($model['category_id'])) {
            $category_ids = [$model['category_id']];
            $list_cat = HikeCategory::whereIn('id', $category_ids)->where("status","publish")->get();
            if(!empty($list_cat)){
                $where_left_right = [];
                foreach ($list_cat as $cat){
                    $where_left_right[] = " ( bravo_hike_category._lft >= {$cat->_lft} AND bravo_hike_category._rgt <= {$cat->_rgt} ) ";
                }
                $sql_where_join = " ( ".implode("OR" , $where_left_right)." )  ";
                $model_Hike
                    ->join('bravo_hike_category', function ($join) use($sql_where_join) {
                        $join->on('bravo_hike_category.id', '=', 'bravo_hikes.category_id')
                            ->WhereRaw($sql_where_join);
                    });
            }
        }
        if(!empty($model['is_featured']))
        {
            $model_Hike->where('is_featured',1);
        }
        $model_Hike->orderBy("bravo_hikes.".$model['order'], $model['order_by']);
        $model_Hike->where("bravo_hikes.status", "publish");
        $model_Hike->with('location');
        $model_Hike->groupBy("bravo_hikes.id");
        $list = $model_Hike->limit($model['number'])->get();
        $data = [
            'rows'       => $list,
            'style_list' => $model['style'],
            'title'      => $model['title'] ?? "",
            'desc'      => $model['desc'] ?? "",
            'show_more'  => $model['show_more'] ?? false,
            'background_image' => $model['background_image'] ?? false,
            'view_more_desc' => $model['view_more_desc'] ?? false,
        ];
        return view('Hike::frontend.blocks.list-hike.index', $data);
    }
}
