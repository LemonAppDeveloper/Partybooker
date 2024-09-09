@extends('layouts.app')
@section('content')

<div class="row ms-0 me-0">
    <div class="col-md-12">
        <div class="login">
            <h1>Register or Login</h1>
            <ul class="p-0">
                <li><a href="{{route('social.oauth','facebook')}}"><i class="lab la-facebook-f"></i></a></li>                
                <li class="d-none"><a href="{{route('social.oauth','twitter')}}"><i class="lab la-twitter"></i></a></li>
                <li><a href="{{route('social.oauth','google')}}"><i class="las la-envelope"></i></a></li>
            </ul>
            <span class="ors">OR</span>
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                @error('email')
                <label class="invalid-feedback error" role="alert">
                    <strong>{{ $message }}</strong>
                </label>
                @enderror   
                        
                <div class="passicons">
                    <input id="showPassword" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                    <span><i id="toggler" class="las la-eye"></i></span>
                </div>
                @error('password')
                <label class="invalid-feedback error" role="alert">
                    <strong>{{ $message }}</strong>
                </label>
                @enderror
                <div class="row">
                    
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input"  name="remember" type="checkbox" id="remember">
                            <label class="form-check-label text-start" for="remember">
                                Remember me
                            </label>
                        </div>
                    </div> 
                    
                    <div class="col-6">
                        <p class="fpas"><a href="{{ route('forgot-password') }}">Forgot Password?</a></p>		
                    </div>
                 
                </div>
                <!-- <input type="email" name="email" class="form-control" placeholder="Email Address"> -->
                <!-- <input type="passowrd" name="passowrd" class="form-control" placeholder="Password"> -->
                <button type="submit" class="btn btn-blue">Sign In</button>
                <!--<p>Forgot Password? <a href="{{ route('forgot-password') }}">Click Here</a></p>-->
                <p>Not yet registered? <a href="{{ route('register') }}">Sign up here</a></p>
                
                  
            </form>
        </div>
    </div>
     
</div>
 
@endsection

@section('pageScript')
<script type="text/javascript" src="{{ asset('assets/js/script.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/page/auth.js')}}"></script>
@endsection