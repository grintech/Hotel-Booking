<?php

namespace  Modules\Guesthouse;

use Modules\Core\Abstracts\BaseSettingsClass;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        return [
            [
                'id'   => 'guesthouse',
                'title' => __("Guesthouse Settings"),
                'position'=>20,
                'view'=>"Guesthouse::admin.settings.guesthouse",
                "keys"=>[
                    'guesthouse_disable',
                    'guesthouse_page_search_title',
                    'guesthouse_page_search_banner',
                    'guesthouse_layout_search',
                    'guesthouse_layout_item_search',
                    'guesthouse_attribute_show_in_listing_page',
                    'guesthouse_location_search_style',

                    'guesthouse_enable_review',
                    'guesthouse_review_approved',
                    'guesthouse_enable_review_after_booking',
                    'guesthouse_review_number_per_page',
                    'guesthouse_review_stats',

                    'guesthouse_page_list_seo_title',
                    'guesthouse_page_list_seo_desc',
                    'guesthouse_page_list_seo_image',
                    'guesthouse_page_list_seo_share',

                    'guesthouse_booking_buyer_fees',
                    'guesthouse_vendor_create_service_must_approved_by_admin',
                    'guesthouse_allow_vendor_can_change_their_booking_status',
                    'guesthouse_search_fields',
                    'guesthouse_map_search_fields',

                    'guesthouse_allow_review_after_making_completed_booking',
                    'guesthouse_deposit_enable',
                    'guesthouse_deposit_type',
                    'guesthouse_deposit_amount',
                    'guesthouse_deposit_fomular',
                ],
                'html_keys'=>[

                ]
            ]
        ];
    }
}
