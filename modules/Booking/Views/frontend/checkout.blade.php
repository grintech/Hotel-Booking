@extends('layouts.app')
@section('head')
    <link href="{{ asset('module/booking/css/checkout.css?_ver='.config('app.version')) }}" rel="stylesheet">
@endsection
@section('content')
    <div class="bravo-booking-page padding-content" >
        <div class="container">
            <div id="bravo-checkout-page" >
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="form-title">{{__('Booking Submission')}}</h3>
                         <div class="booking-form">
                             @include ($service->checkout_form_file ?? 'Booking::frontend/booking/checkout-form')

                         </div>
                    </div>
                    <div class="col-md-4">
                        <div class="booking-detail">
                            @include ($service->checkout_booking_detail_file ?? '')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="terminal-form" style="opacity: 0"></div>
@endsection
@section('footer')
    <script>
        function addTerminalFormToDom(encodedTerminalForm, formId){
            $('#terminal-form').append(atob(encodedTerminalForm))
            $(`#${formId}`).submit();
        }
    </script>
    <script src="{{ asset('module/booking/js/checkout.js') }}"></script>
    <script type="text/javascript">
        jQuery(function () {
            $.ajax({
                'url': bookingCore.url + '/booking/{{$booking->code}}/check-status',
                'cache': false,
                'type': 'GET',
                success: function (data) {
                    if (data.redirect !== undefined && data.redirect) {
                        window.location.href = data.redirect
                    }
                }
            });
        })

        const KEY = 'CHECKOUT_INPUTS';
        let data = localStorage.getItem(KEY);
        data = data ? JSON.parse(data) : {};

        for (let prop in data) {
            if (data.hasOwnProperty(prop)) {
                $(`input[preserve="true"][name="${prop}"]`).val(data[prop]);
            }
        }

        $('input[preserve="true"]').on('change', function(e){
            data[e.target.name] = e.target.value;
            localStorage.setItem(KEY, JSON.stringify(data));
        })
    </script>
@endsection
