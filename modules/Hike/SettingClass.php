<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/2/2019
 * Time: 10:26 AM
 */
namespace  Modules\Hike;

use Modules\Core\Abstracts\BaseSettingsClass;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        return [
            [
                'id'   => 'hike',
                'title' => __("Hike Settings"),
                'position'=>20,
                'view'=>"Hike::admin.settings.hike",
                "keys"=>[
                    'hike_disable',
                    'hike_page_search_title',
                    'hike_page_search_banner',
                    'hike_layout_search',
                    'hike_location_search_style',
                    'tour_page_limit_item',

                    'hike_enable_review',
                    'hike_review_approved',
                    'hike_enable_review_after_booking',
                    'hike_review_number_per_page',
                    'hike_review_stats',
                    'hike_page_list_seo_title',
                    'hike_page_list_seo_desc',
                    'hike_page_list_seo_image',
                    'hike_page_list_seo_share',
                    'hike_booking_buyer_fees',
                    'hike_vendor_create_service_must_approved_by_admin',
                    'hike_allow_vendor_can_change_their_booking_status',
                    'hike_search_fields',
                    'tour_allow_vendor_can_change_paid_amount',
                    'hike_map_search_fields',
                    'hike_allow_review_after_making_completed_booking',
                    'hike_deposit_enable',
                    'hike_deposit_type',
                    'hike_deposit_amount',
                    'hike_deposit_fomular',
                    'hike_sidebar',
                    'tour_layout_map_option',
                ],
                'html_keys'=>[

                ]
            ]
        ];
    }
}
