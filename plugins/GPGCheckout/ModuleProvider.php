<?php
namespace Plugins\GPGCheckout;

use Modules\ModuleServiceProvider;
use Plugins\GPGCheckout\Gateway\GPGCheckoutGateway;

class ModuleProvider extends ModuleServiceProvider
{
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

    public static function getPaymentGateway()
    {
        return [
            'gpg_checkout_gateway' => GPGCheckoutGateway::class
        ];
    }

    public static function getPluginInfo()
    {
        return [
            'title'   => __('GPG Payment Gateway'),
            'desc'    => __('GPG Payment Gateway is tunisian local payment gateway'),
            'author'  => "Trinity InfoSystem | Kiran Maniya",
            'version' => "1.0.0",
        ];
    }
}
