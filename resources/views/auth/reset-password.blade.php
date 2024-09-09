@extends('layouts.app')
@section('content')
<div class="row ms-0 me-0">
    <div class="col-md-12">
        <div class="login forgotpwd successmsg d-none">
            <span class="text-center"><i class="las la-check"></i></span>
            <h1>Password change successfully</h1>
            <button type="submit" class="btn btn-blue">Continue</button>
        </div>
        <div class="login reset-password-sec">
            <h1>Reset Password</h1>
            <form method="POST" action="{{ route('reset-password',$token) }}" id="reset-password-form" onsubmit="return false;">
                @csrf
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" placeholder="Password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input id="password_confirmation" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" autocomplete="current-password" placeholder="Confirm password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <button type="submit" class="btn btn-blue"> Reset Password <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span></button>
                <p>Know your password? <a href="{{ route('login') }}">Login</a></p>
            </form>
        </div>
    </div>
</div>
@endsection
@section('pageScript')
<script type="text/javascript" src="{{ asset('assets/js/script.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/page/auth.js')}}"></script>
@endsection