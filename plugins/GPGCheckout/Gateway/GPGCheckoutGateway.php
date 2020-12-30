<?php
namespace Plugins\GPGCheckout\Gateway;

use App\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use Modules\Booking\Models\Payment;
use Validator;

class GPGCheckoutGateway extends \Modules\Booking\Gateways\BaseGateway
{
    protected $id   = 'gpg_checkout_gateway';
    public    $name = 'GPG Checkout';
    public    $primary_currency = 'tnd';
    protected $gateway;

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable GPG Checkout?')
            ],
            [
                'type'  => 'input',
                'id'    => 'name',
                'label' => __('Custom Name'),
                'std'   => __("GPG Checkout"),
                'multi_lang' => "1"
            ],
            [
                'type'  => 'upload',
                'id'    => 'logo_id',
                'label' => __('GPG Logo'),
            ],
            [
                'type'  => 'editor',
                'id'    => 'html',
                'label' => __('Custom HTML Description'),
                'multi_lang' => "1"
            ],
            [
                'type'  => 'input',
                'id'    => 'sandbox_url',
                'label' => __('SandBox URL Endpoint'),
            ],
            [
                'type'  => 'input',
                'id'    => 'production_url',
                'label' => __('Production URL Endpoint'),
            ],
            [
                'type'  => 'input',
                'id'    => 'sandbox_site_number',
                'label' => __('SandBox Site Number'),
            ],
            [
                'type'  => 'input',
                'id'    => 'production_site_number',
                'label' => __('Production Site Number'),
            ],
            [
                'type'  => 'input',
                'id'    => 'sandbox_password',
                'label' => __('SandBox Password'),
            ],
            [
                'type'  => 'input',
                'id'    => 'production_password',
                'label' => __('Production Password'),
            ],
            [
                'type'  => 'input',
                'id'    => 'sandbox_vad',
                'label' => __('SandBox Code VAD'),
            ],
            [
                'type'  => 'input',
                'id'    => 'production_vad',
                'label' => __('Production Code VAD'),
            ],
            [
                'type'  => 'checkbox',
                'id'    => 'enable_sandbox',
                'label' => __('Enable Sandbox Mode'),
            ]
        ];
    }

    public function process(Request $request, $booking, $service)
    {

        if (in_array($booking->status, [
            $booking::PAID,
            $booking::COMPLETED,
            $booking::CANCELLED
        ])) {

            throw new Exception(__("Booking status does need to be paid"));
        }
        if (!$booking->total) {
            throw new Exception(__("Booking total is zero. Can not process payment gateway!"));
        }
        $payment = new Payment();
        $payment->booking_id = $booking->id;
        $payment->payment_gateway = $this->id;
        $payment->status = 'draft';
        $payment->save();

        $booking->status = $booking::UNPAID;
        $booking->payment_id = $payment->id;
        $booking->save();

        $gateway_options = new \stdClass();
        $data = $request->all();

        $conversion = $this->getInPrimaryCurrency($booking->currency, (float)$booking->pay_now);

        Log::info(json_encode([
            'booking currency' => $booking->currency,
            'booking amount' => $booking->pay_now
        ]));

        $gateway_options->currency = strtoupper($booking->currency);
        $gateway_options->amount = $conversion['amount'];
        $gateway_options->amountInWord = $conversion['word'];
        $gateway_options->conversion_rate = $conversion['rate'];
        $gateway_options->terminal = $this->getSupportedTerminals();
        $gateway_options->terminal = $gateway_options->terminal[$gateway_options->currency]['terminal'];
        $gateway_options->lang = app()->getLocale();

        if ($this->getOption('enable_sandbox')) {
            $gateway_options->url = $this->getOption('sandbox_url');
            $gateway_options->site_number = $this->getOption('sandbox_site_number');
            $gateway_options->password = md5($this->getOption('sandbox_password'));
            $gateway_options->vad = $this->getOption('sandbox_vad');
            $gateway_options->signature = sha1($gateway_options->site_number. $this->getOption('sandbox_password') . $booking->code . $gateway_options->amount. $gateway_options->currency);
        } else {
            $gateway_options->url = $this->getOption('production_url');
            $gateway_options->site_number = $this->getOption('production_site_number');
            $gateway_options->password = md5($this->getOption('production_password'));
            $gateway_options->vad = $this->getOption('production_vad');
            $gateway_options->signature = sha1 ($gateway_options->site_number. $this->getOption('production_password') . $booking->code . $gateway_options->amount. $gateway_options->currency);
        }

        $terminal_form_id = $this->getTerminalFormID();
        $view = \View::make('GPGCheckout::frontend.gpg-checkout', compact('data', 'booking', 'gateway_options', 'terminal_form_id'));

        $response = new \stdClass();
        $response->terminal = $this->isTerminal();
        $response->form_id = $terminal_form_id;
        $response->form = base64_encode($view->render());

        return json_encode($response);
    }

    public function getDisplayHtml()
    {
        return $this->getOption('html', '');
    }

    public function getSupportedTerminals(){
        /*
         * The terminal code needs to be kept in string format,
         * numeric format removes the prefix zeroes, not supported
         * by the GPGCheckout
         *
         * */
        return [
            'TND' => [
                'terminal'  => '001',
                'code'      => 788
            ],
            'EUR' => [
                'terminal'  => '003',
                'code'      => 978
            ],
            'USD' => [
                'terminal'  => '004',
                'code'      => 840
            ]
        ];
    }

    public function getInPrimaryCurrency($transactionCurrency, $amount){
        $currencies = Currency::getActiveCurrency();

        $transaction_currency_setting = $app_primary_currency_setting = $gateway_primary_currency_setting = null;

        $app_primary_currency = setting_item('currency_main');

        foreach($currencies as $c) {
            if ($c['currency_main'] == $transactionCurrency) {
                $transaction_currency_setting = $c;
            }

            if($c['currency_main'] == $this->primary_currency){
                $gateway_primary_currency_setting = $c;
            }

            if($c['currency_main'] == $app_primary_currency){
                $app_primary_currency_setting = $c;
            }
        }

        if($transaction_currency_setting['currency_main'] == $this->primary_currency){
            //the transaction currency is same as gateway primary currency
            $gatewayAmount = $amount * $transaction_currency_setting['multiplier'];
            $gatewayAmountParse = $gatewayAmount;
            $gatewayConversionRate = 1;
        }else{
            $amountInPrimaryCurrency = $amount * $transaction_currency_setting['rate'];
            $amountInTND = $amountInPrimaryCurrency * $gateway_primary_currency_setting['rate'];
            $gatewayAmount = $amountInTND * $gateway_primary_currency_setting['multiplier'];
            $gatewayAmountParse = ($amount * $transaction_currency_setting['multiplier']);
            $gatewayConversionRate = $transaction_currency_setting['rate'];
        }

        Log::info(json_encode([
            'amount' => $gatewayAmount,
            'word' => $gatewayAmountParse,
            'rate' => $gatewayConversionRate
        ]));

        return [
            'amount' => $gatewayAmount,
            'word' => $gatewayAmountParse,
            'rate' => $gatewayConversionRate
        ];
    }

    public function isTerminal(){
        return true;
    }

    public function getTerminalFormID(){
        $stamp = time();
        return "gpg-checkout-form-{$stamp}";
    }
}
