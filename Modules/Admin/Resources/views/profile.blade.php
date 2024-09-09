@extends('layouts.admin.app')
@section('content')
<div class="row">
    <div class="col-md-12" id="usermanage">
        <div class="row">
            <div class="col-md-6">
                <div class="widget profile-widget">
                    <img src="{{ !empty(Auth::user()->profile_image) ? url('/').'/uploads/profile/'.Auth::user()->profile_image : asset('assets/images/profile.png')}}" alt="profile">
                    <p class="pname">{{ Auth::user()->name }}</p>
                    <form method="POST" action="{{ route('admin.update-profile') }}" onsubmit="return false;">
                        @csrf
                        <div class="form-group">
                            <label>Profile Image</label>
                            <input type="file" name="profile_image" class="form-control cname" value="" accept="image/*">
                            <span class="clearname"></span>
                        </div>
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="full name" value="{{ Auth::user()->name }}" autocomplete="off" />
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="email addresss" value="{{ Auth::user()->email }}" autocomplete="off" />
                        <button href="javascript:void(0);" class="view-all-review btn-update-profile" id="editProfileA"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Edit Profile</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="widget profile-widget">
                    <p class="pname">Change Password</p>
                    <form method="POST" action="{{ route('admin.change-password') }}" onsubmit="return false;">
                        @csrf
                        <label class="current-password">Current Password </label>
                        <input type="password" name="current_password" class="form-control" value="" placeholder="******">
                        <label class="password">New Password </label>
                        <input type="password" name="password" class="form-control" value="" placeholder="******">
                        <label class="password_confirmation">Confirm Password </label>
                        <input type="password" name="password_confirmation" class="form-control" value="" placeholder="******">
                        <button href="javascript:void(0);" class="view-all-review btn-change-password" id="editProfileA"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection