@extends('layouts.app')
@section('content')
<div class="row ms-0 me-0">
    <div class="col-md-12">
        <div class="login">
            <div class="forgotpwd success-msg d-none">
                <img src="{{ asset('assets/images/mail.png') }}" alt="mail">
                <h1>Password reset email sent!</h1>
                <p>Please check your e-mail address for your new temporary password</p>
                <form action="{{ URL::to('/') }}">
                    <button type="submit" class="btn btn-blue">Back to Sign In</button>
                </form>
            </div>
            <div class="forgotpwd">
                <h1>Forgot your password?</h1>
                <p>Please enter your email address below to receive password reset link.</p>
                <img src="{{ asset('assets/images/mail.png') }}" alt="mail">
                <form method="POST" action="{{ route('forgot-password') }}" id="forgot-password-form" onsubmit="return false;">
                    @csrf
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    
                    <button type="submit" class="btn btn-blue"> Reset <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span></button>
                    <p>Know your password? <a href="{{ route('login') }}">Login</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('pageScript')
<script type="text/javascript" src="{{ asset('assets/js/script.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/page/auth.js')}}"></script>
@endsection