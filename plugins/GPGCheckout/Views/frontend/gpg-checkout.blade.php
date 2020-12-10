<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GPGCheckout | {{ __('Do not Refresh the page') }}</title>
</head>
<body>
@php
    $is_sandbox_mode = true;
    $gateway = '';
    $site_number = 'XXXXXX';
    $password = 'XXXXXXX';
    $amount = '1250';
    $currency = 'TND';
    $vad = '';
    $orderId = date ('ymdHis');
    $order_signature = sha1 ($site_number. $password . $orderId. $amount. $currency);
@endphp
    <form name="paiment"
          method="POST"
          action="{{ $gateway_options->url }}">

        <input type="hidden" name="SiteNum" value="{{ $gateway_options->site_number }}">
        <input type="hidden" name="Password" value="{{ md5($gateway_options->password) }}">
        <input type="hidden" name="orderID" value="{{ $booking->code }}">
        <input type="hidden" name="Amount" value="{{ (float)$booking->pay_now }}">
        <input type="hidden" name="Currency" value= "{{ $gateway_options->currency }}">
        <input type="hidden" name="Language" value="{{ $gateway_options->lang }}">
        <input type="hidden" name="EMAIL" value="{{ $data['email'] }}">
        <input type="hidden" name="CustLastName" value="{{ $data['last_name'] }}">
        <input type="hidden" name="CustFirstName" value="{{ $data['first_name'] }}">
        <input type="hidden" name="CustAddress" value="{{ $data['address_line_1'] }}">
        <input type="hidden" name="CustZIP" value="{{ $data['zip'] }}">
        <input type="hidden" name="CustCity" value="{{ $data['city'] }}">
        <input type="hidden" name="CustCountry" value="{{ $data['country'] }}">
        <input type="hidden" name="CustTel" value="{{ $data['phone'] }}">
        <input type="hidden" name="PayementType" value="1">
        <input type="hidden" name="MerchandSession" value="">
        <input type="hidden" name="orderProducts" value="Wildyness Booking Charges">
        <input type="hidden" name="signature" value="{{ $gateway_options->signature }}">
        <input type="hidden" name="AmountSecond" value="">
        <input type="hidden" name="vad" value="{{ $gateway_options->vad }}">
        <input type="hidden" name="Terminal" value="{{ $terminals[$gateway_options->currency]['terminal'] }}">
        <input type="hidden" name="ConversionRate" value="">
        <input type="hidden" name="BatchNumber" value="">
        <input type = "hidden" name = "MerchantReference" value="">
        <input type="hidden" name="Reccu_Num" value="">
        <input type = "hidden" name="Reccu_ExpiryDate" value="">
        <input type = "hidden" name="Reccu_Frecuency" value="">
        BP 59 Technology Center
        El Ghazela 2088
        Phone. : +216 71 857 285 contact@gpgateway.com
        <input type="submit" name="Validate" value="Validate">
    </form>
</body>
</html>
