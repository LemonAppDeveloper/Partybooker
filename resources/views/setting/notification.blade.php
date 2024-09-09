@extends('layouts.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
@endsection
@section('content')
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="party-heading">
                <h3 class="mb-4"><a href="{{ route('setting') }}"><i class="las la-arrow-left"></i></a> Notification Settings</h3>
            </div>
        </div>
        <div class="col-md-12 overflow overflow-h">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="option-box">
                        <div class="option-heading">
                            <h3>Email</h3>
                            <div class="form-check form-switch d-none">
                                <input class="form-check-input" type="checkbox" role="switch" id="email">
                            </div>
                        </div>
                        <div class="opt-list">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="push">Push Notification</label>
                                <input class="form-check-input change-notification-status email-noti" data-href="{{ route('notification-update') }}" type="checkbox" name="notification_push_status" role="switch" id="push" {{ $user->notification_push_status == 1 ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="opt-list">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="emails">Email</label>
                                <input class="form-check-input change-notification-status email-noti" data-href="{{ route('notification-update') }}" type="checkbox" name="notification_email_status" role="switch" id="emails" {{ $user->notification_email_status == 1 ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="opt-list d-none">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="sms">SMS</label>
                                <input class="form-check-input email-noti" type="checkbox" role="switch" id="sms">
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
<script>
    $(document).on('change', '.change-notification-status', function() {
        var current = $(this);
        $('#cover-spin').show();
        $.ajax({
            url: current.attr('data-href'),
            method: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'name': current.attr('name'),
                'value': current.is(':checked') ? 1 : 0,
            },
            dataType: 'json',
            success: function(response) {
                $('#cover-spin').hide();
                if (response.status) {
                    toastr.success(response.message);
                } else {                    
                    toastr.error(response.message);
                }
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