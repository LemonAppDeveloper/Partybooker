@extends('layouts.app')
@section('content')
<div class="row ms-0 me-0">
    <div class="col-md-12">
        <div class="login">
        
            <h1>Register</h1>
             
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                @if(isset($vendor_register) && !empty($vendor_register))
                <input type="hidden" name="vendor_register" value="{{$vendor_register}}">
                @endif
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input id="fname" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Full Name">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <div class="passicons">
                    <input id="showPassword" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                    <span><i id="toggler" class="las la-eye"></i></span>
                </div>

                <div class="passicons">
                    <input id="showPassword1" type="password" class="form-control" name="password_confirmation"   autocomplete="new-password" placeholder="Repeat Password">
                    <span><i id="toggler1" class="las la-eye"></i></span>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <br>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="term_condition" required>
                    <label class="form-check-label text-start" for="flexCheckDefault-stop">
                        <b>Terms & Conditions</b><br>
                        I have read and agree to the <b><a target="_blank" class="text-white" href="{{url('terms-of-use')}}">Terms of Use</a></b>, <b><a target="_blank" class="text-white" href="{{url('privacy-policy')}}">Privacy Policy</a></b>, and <b><a target="_blank" class="text-white" href="{{url('internet-security')}}">Internet Security Information Policy</a></b>.
                    </label>
                </div>
                <!--<button type="submit" class="btn btn-blue" id="submitBtn" disabled>Sign up</button>-->
                <button type="submit" class="btn btn-blue" id="submitBtn">Sign up</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('pageScript')
<script type="text/javascript" src="{{ asset('assets/js/script.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/page/auth.js')}}"></script>
// <script>
//     // Get references to the form fields and the submit button
//     const emailField = document.getElementById('email');
//     const nameField = document.getElementById('fname');
//     const passwordField = document.getElementById('password');
//     const confirmPasswordField = document.getElementById('password-confirm');
//     const termsCheckbox = document.getElementById('flexCheckDefault');
//     const submitBtn = document.getElementById('submitBtn');

//     // Function to check if all fields are filled
//     function allFieldsFilled() {
//         return emailField.value !== '' &&
//             nameField.value !== '' &&
//             passwordField.value !== '' &&
//             confirmPasswordField.value !== '' &&
//             termsCheckbox.checked;
//     }

//     // Add event listeners to the form fields
//     emailField.addEventListener('input', toggleSubmitButton);
//     nameField.addEventListener('input', toggleSubmitButton);
//     passwordField.addEventListener('input', toggleSubmitButton);
//     confirmPasswordField.addEventListener('input', toggleSubmitButton);
//     termsCheckbox.addEventListener('change', toggleSubmitButton);

//     // Function to enable/disable the submit button
//     function toggleSubmitButton() {
//         if (allFieldsFilled()) {
//             submitBtn.disabled = false;
//         } else {
//             submitBtn.disabled = true;
//         }
//     }

//     // Initially disable the submit button
//     toggleSubmitButton();
// </script>
@endsection