@extends('layouts.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
@endsection
@section('content')
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="success-page">
                <div class="row">
                    <div class="col-md-7">
                        <div class="party-confirmed">
                            <div class="success-msg text-center">
                                <span><i class="las la-check"></i></span>
                                <h2>Your party is confirmed!</h2>
                                <p>We'll email you a receipt for each invoice</p>
                                <label>Note: Please wait for at least 24 hours for the vendor to confirm your booking.</label>
                            </div>
                            <div class="ord-details">
                                <p>Reference no.</p>
                                <p>{{ $booking_info['booking_info']->booking_number }}</p>
                            </div>
                            <div class="ord-details">
                                <p>Party Name</p>
                                <p>{{ $booking_info['event_info']->event_title }}</p>
                            </div>
                            <div class="ord-details">
                                <p>Card Details</p>
                                <p>Ending with {{ get_card_last_4($booking_info['booking_info']->id_payment_token) }}</p>
                            </div>
                            <div class="ord-details total">
                                <p>Total</p>
                                <p class="d-none">$ {{ $booking_info['booking_info']->total_amount }}</p>
                                <p>$ {{ get_total_amount_from_info($booking_info['booking_info']->booking_number) }}</p>
                            </div>
                            <?php 
                            $link = route('cart').'/'.my_encrypt($booking_info['event_info']->id);
                            ?>
                            <div class="ord-details buttons">
                                <button class="btn btn-secondary" onclick="document.location.href='{{route("discover")}}';">Go to Home</button>
                                <button class="btn book-pkg" onclick="document.location.href='{{$link}}';">Go to my Parties</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 confirmed-massage text-center">
                        <div class="confirmed">
                            <div class="massages">
                                <p>We thank you for your booking and for choosing us to make your event a memorable experience.</p>
                                <p class="text-white">If you have any questions or need further assistance, please contact our support team at <a href="mailto:support@partybookr.com" class="text-white">support@partybookr.com</a> </p>
                                <p>We are here to ensure everything goes smoothly for your event.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('pageScript')
<script src="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
@endsection
@section('pageScriptlinks')
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/js/cart.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/script.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/page/auth.js')}}"></script>
@endsection