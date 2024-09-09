@extends('layouts.admin.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="pheading">
                        <h2><a href="{{ url('/').'/admin/dashboard' }}"><i class="las la-arrow-left"></i></a> Settings</h2>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{ route('admin.settings.general') }}" class="s-box">
                        <i class="las la-cog"></i>
                        <h3>General</h3>
                        <p>View and update your details</p>
                    </a>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{ route('admin.settings.notification') }}" class="s-box">
                        <i class="las la-bell"></i>
                        <h3>Notification Management</h3>
                        <p>Manage notifications sent to you and your customers</p>
                    </a>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{ route('admin.settings.cms') }}" class="s-box">
                        <i class="lab la-staylinked"></i>
                        <h3>CMS Management</h3>
                        <p>Manage your legal pages</p>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('admin.settings.faq') }}" class="s-box">
                        <i class="lab la-staylinked"></i>
                        <h3>FAQ Management</h3>
                        <p>Manage your FAQ Detail</p>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <a href="{{URL::to('admin/category')}}" class="s-box">
                        <img class="mb-4" src="{{ asset('admin-assets/images/party.png') }}">
                        <h3>Category Management</h3>
                        <p>Manage your Category</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection