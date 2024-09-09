@extends('layouts.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
@endsection
@section('content')
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="party-heading">
                <h3 class="mb-4"><a href="{{ route('setting') }}"><i class="las la-arrow-left"></i></a> Previous Parties</h3>
            </div>
        </div>
        <div class="col-md-12 overflow overflow-h">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <?php
                    if (isset($booking_list['row_count']) && !empty($booking_list['row_count'])) {
                        foreach ($booking_list['data'] as $info) {
                    ?>
                            <div class="set-my-wedparty">
                                <div class="sett-header">
                                    <p>{{isset($info->event_info->event_title) ? $info->event_info->event_title : ''}}</p>
                                    <span class="{{ isset($info->booking_status) && $info->booking_status == 2 ? 'conform' : 'pending' }}">{{ getBookingStatus($info->booking_status) }}</span>
                                </div>
                                <div class="sett-body">
                                    <p><img src="{{asset('assets/images/ref.svg')}}"> Ref. {{$info->booking_number}}</p>
                                    <p><img src="{{asset('assets/images/loc.svg')}}"> {{ isset($info->booking_info->details[0]->vendor_info[0]->name) ? $info->booking_info->details[0]->vendor_info[0]->name : '' }}</p>
                                    <p><img src="{{asset('assets/images/cal.svg')}}"> {{ isset($info->booking_info->from_date) ? $info->booking_info->from_date : '' }} - {{ isset($info->booking_info->to_date) ? $info->booking_info->to_date : '' }}</p>
                                    <p><img src="{{asset('assets/images/fir.svg')}}"> {{isset($info->event_info->event_category) ? $info->event_info->event_category : ''}}</p>
                                    <p><span><img src="{{asset('assets/images/mon.svg')}}"> <?php echo env('CURRENCY_SYMBOL') ?>{{ $info->total_amount }}</span>{{ isset($info->payment_status) && $info->payment_status == 2 ? 'Paid' : getBookingStatus($info->payment_status) }}</p>
                                </div>
                                <div class="sett-footer text-end">
                                    <button class="btn btn-outline-dark d-none">Cancel Party</button>
                                    <button class="btn btn-outline-dark d-none">Book Again</button>
                                    <button class="btn btn-outline-dark d-none">View my Party</button>
                                </div>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="alert alert-info">
                            Party not available.
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('pageScript')
@endsection
@section('pageScriptlinks')
<script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/page/auth.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/discover.js') }}"></script>
@endsection