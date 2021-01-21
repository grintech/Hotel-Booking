<?php
namespace Plugins\GPGCheckout\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Booking\Models\Booking;

class GPGCheckoutController extends Controller
{
    protected $PAYMENT_SUCCESS = '00';
    public function handleCheckout(Request $request)
    {
        if (!empty($request->input('key')) and !empty($request->input('x_receipt_link_url'))) {
            $twoco_args = http_build_query($request->input(), '', '&');
            return redirect($request->input('x_receipt_link_url') . "&" . $twoco_args);
        }
        return redirect("/");
    }

    public function handleCallback(Request $request){
        Log::info(json_encode([
            'message' => 'All Inputs received from GPGGateway',
            'dump' => $request->all()
        ]));

        $code = $request->merchandSession;

        $booking = Booking::where(['code' => $request->PAYID])->first();
        if(!$booking){
            Log::error(json_encode([
                "message" => "GPGCheckout booking callback invoked with invalid booking id.",
                "dump" => $request->all()
            ]));
            return view('GPGCheckout::frontend.rejected', [
                'message' => __('We can\'t confirm the booking, it\'s not found in booking register. Here is your booking code :code', ['code' => $code]),
                'code' => $code,
            ]);
        }

        $is_signature_valid = $this->verifyResponseSignature($request->TransStatus, $booking->code, $request->Signature);

        if(!$is_signature_valid){
            Log::error(json_encode([
                "message" => "GPGCheckout booking callback invoked with invalid signature",
                "dump" => $request->all()
            ]));
            return view('GPGCheckout::frontend.rejected', [
                'message' => __('We can\'t confirm the booking, it\'s being tempered in somewhere. Here is your booking code :code', ['code' => $code]),
                'code' => $code,
            ]);
        }

        if($request->TransStatus == $this->PAYMENT_SUCCESS){
            $booking->markAsPaid();
        }
    }

    protected function verifyResponseSignature($statusCode, $bookingCode, $signature){
        $is_sandbox_mode = setting_item('g_gpg_checkout_gateway_enable_sandbox');
        $password = '';
        if($is_sandbox_mode){
            $password = setting_item('g_gpg_checkout_gateway_sandbox_password');
        }else{
            $password = setting_item('g_gpg_checkout_gateway_production_password');
        }
        $checksum = sha1($statusCode . $bookingCode . $password);

        return $checksum == $signature;
    }

    public function handleSuccess(){
        $code = session()->get('gpg_checkout_booking_code');
        session()->forget('gpg_checkout_booking_code');
        if(session()->has('gpg_checkout_booking_code')){
            Log::info(json_encode([
                'message' => 'URL OK got a hit',
                'code' => $code
            ]));
            return response()->redirectToRoute('booking.detail', ['code' => $code]);
        }else{
            Log::info(json_encode([
                'message' => 'URL OK got a hit, without a value in session',
                'code' => $code
            ]));
            abort(500);
        }
    }

    public function handleFailure(){
        Log::info(json_encode([
            'message' => 'URL KO got a hit, without a value in session',
            'dump' => session()->all(),
        ]));

        $code = session()->get('gpg_checkout_booking_code');
        session()->forget('gpg_checkout_booking_code');
        return view('GPGCheckout::frontend.rejected', [
            'message' => __('The transaction has been failed processing, Please try again or contact site admin. For the reference, here is your booking code :code', ['code' => $code]),
            'code' => $code,
        ]);

    }
}
