@extends('layouts.vendor.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor-assets/css/settings.css') }}" />
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="pheading">
                        <h2><a href="{{ url('/').'/vendor/dashboard' }}"><i class="las la-arrow-left"></i></a>Settings</h2>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-4 col-sm-6 col-xs-12 d-none">
                    <a href="{{ route('vender.configration.notification') }}" class="s-box">
                        <i class="las la-bell"></i>
                        <h3>Notification Management</h3>
                        <p>Manage notifications sent to you and your customers</p>
                    </a>
                </div> 

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{ route('vender.configration.cms') }}" class="s-box">
                        <i class="lab la-staylinked"></i>
                        <h3>CMS Management</h3>
                        <p>Manage your legal pages</p>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{ route('vender.configration.faq') }}" class="s-box">
                        <i class="lab la-staylinked"></i>
                        <h3>FAQ Management</h3>
                        <p>Manage your FAQ Detail</p>
                    </a>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{ route('vender.configration.bank') }}" class="s-box">
                        <i class="lab la-staylinked"></i>
                        <h3>Bank Details</h3>
                        <p>Manage your Bank Detail</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.vendor.modal-profile')
@include('layouts.vendor.modal-calendar')
@include('layouts.vendor.modal-settings')
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>