<?php

namespace App\Providers;

use App\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {

        if(env('APP_HTTPS')) {
            \URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);

        if(strpos($request->path(),'install') === false  && file_exists(storage_path().'/installed')){

            $locale = $request->segment(1);
            if($locale == null){
                $country = geoip($request->ip())->getAttribute('country');

                $supportedLanguages = [
                    'United States' => 'en',
                    'Canada' => 'en',
                    'India' => 'en',
                    'France' => 'fr'
                ];
                if(array_key_exists($country, $supportedLanguages)){
                    $locale = $supportedLanguages[$country];
                }
            }

            $languages = \Modules\Language\Models\Language::getActive();
            $localeCodes = Arr::pluck($languages,'locale');
            if(in_array($locale,$localeCodes)){
                app()->setLocale($locale);
            }else{
                app()->setLocale(setting_item('site_locale'));
            }

            $currency = strtolower(geoip($request->ip())->getAttribute('currency'));
            $all = Currency::getActiveCurrency();
            if(!empty($all)){
                foreach ($all as $item){
                    if($item['currency_main'] == $currency){
                        Session::put('bc_current_currency',$currency);
                    }
                }
            }

            if(!empty($locale) and $locale == setting_item('site_locale'))
            {
                $segments = $request->segments();
                if(!empty($segments) and count($segments) > 1) {
                    array_shift($segments);
                    return redirect()->to(implode('/', $segments))->send();
                }
            }
        }
    }
}
