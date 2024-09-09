
@extends('layouts.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
@endsection
@section('content')
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="party-heading">
                <h3 class="mb-4"><a href="{{ route('setting') }}"><i class="las la-arrow-left"></i></a> Planned Parties</h3>
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
                                    <p>{{isset($info->event_title) ? $info->event_title : ''}}</p>
                                    <span class="{{ isset($info->booking_status) && $info->booking_status == 2 ? 'conform' : 'pending' }}">{{ $info->booking_status_title }}</span>
                                </div>
                               @if(isset($info->booking_number) && !empty($info->booking_number))
                                <div class="sett-body">
                                    <p><img src="{{asset('assets/images/ref.svg')}}"> Ref. {{$info->booking_number}}</p>                                
                                    <p><img src="{{asset('assets/images/loc.svg')}}"> {{ isset($info->vendor_name) ? $info->vendor_name : '' }}</p>
                                    <p><img src="{{asset('assets/images/cal.svg')}}"> {{ isset($info->date_time) ? $info->date_time : '' }}</p>                                
                                    <p class="d-none"><img src="{{asset('assets/images/fir.svg')}}"> {{ isset($info->category_name) ? $info->category_name : ''}}</p>                                
                                    <p><span><img src="{{asset('assets/images/mon.svg')}}">  {{ $info->amount }} </span> {{ isset($info->payment_status) && $info->payment_status == 2 ? 'Paid' : $info->payment_status_title }}</p>
                                </div>
                                @endif
                                <div class="sett-footer text-end">
                                    <?php
                                
                                        if (isset($info->booking_number) && !empty($info->booking_number)) {
                                    ?>
                                        <button class="btn btn-outline-dark btn-cancel-booking" data-href="{{route('cancel-booking')}}" data-id="{{my_encrypt($info->id)}}">Cancel Party</button>
                                    <?php
                                    }
                                    ?>
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
<script src="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script>
    $(document).on('click', '.btn-cancel-booking', function() {
        var current = $(this)

        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure want to cancel booking?',
            buttons: {
                confirm: {
                    btnClass: 'btn-success',
                    action: function() {
                        $('#cover-spin').show();
                        var id = [];
                        id.push(current.attr('data-id'));

                        $.ajax({
                            url: current.attr('data-href'),
                            method: 'POST',
                            data: {
                                '_token': $('meta[name="csrf-token"]').attr('content'),
                                'id': id,
                                'action': 'remove'
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status) {
                                    toastr.success(response.message);
                                    setTimeout(function() {
                                        window.location = window.location.href;
                                    }, 500);
                                } else {
                                    $('#cover-spin').hide();
                                    toastr.error(response.message);
                                }
                            }
                        });
                    }
                },
                cancel: function() {}
            }
        });

    });
</script>
@endsection
@section('pageScriptlinks')
<script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/page/auth.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/discover.js') }}"></script>
@endsection