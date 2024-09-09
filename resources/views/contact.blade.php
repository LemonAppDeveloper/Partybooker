@extends('layouts.app')
@section('content')
    <section id="contact-page">
        <div class="container">
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="col-md-6 offset-md-3">
                    <div class="page-headings text-center">
                        <h1>Contact Us</h1>
                        <p>Having any issue? Or need some urgent assistance? <br><br>For booking issues, you may want to
                            refer to our <a href="{{url('faq')}}">FAQ page</a> for more information. If it doesn’t help, don’t
                            hesitate to submit a request below.</p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6 offset-md-3">
                    <form action="{{ route('contact-form') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label>Full name</label>
                                <input type="text" name="fname" class="form-control"   placeholder="First & Last Name">
                                @error('fname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Email Address</label>
                                <input type="text" name="email" class="form-control"   placeholder="eg. john@gmail.com">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="row">
                             <div class="col-md-12">
                                <label>Party Reference Number</label>
                                <input type="text" name="refno" class="form-control" placeholder="Optional">
                                @error('refno')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                             </div>
                        </div>
                    
                        <div class="row">
                             <div class="col-md-12">
                                <label>Type of Enquiry</label>
                                <select class="form-control" name="enquiry"  >
                                    <option value="general-question1">General Question</option>
                                    <option value="general-question2">General Question 1</option>
                                </select>
                                @error('enquiry')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                         </div>
                        </div>
                        
                         <div class="row">
                             <div class="col-md-12">
                                <label>Message</label>
                                <textarea class="form-control" name="message"   placeholder="Type your message here" rows="8"></textarea>
                                @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        
                          </div>
                        </div>
                        <input type="submit" class="subbtn">
                    </form>
                    
                </div>
            </div>
        </div>
    </section>
@endsection
@section('pageScript')
<script type="text/javascript" src="{{ asset('assets/js/script.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/page/auth.js')}}"></script>
@endsection
