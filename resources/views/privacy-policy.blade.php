@extends('layouts.app')
@section('content')
<section id="contact-page">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="page-headings text-center">
                    <h1>Privacy Policy</h1>
                    <p>Thank you for using our PartyBookr. <br><br>This Privacy Policy outlines how we collect, use, disclose, and protect your personal information. By using the Application, you agree to the terms of this Privacy Policy.</p>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-10 offset-md-1">
                <div class="text-desc">
                    @foreach ($data as $item)
                    <div class="p-box">
                        <h3>{{$item->title}}</h3>
                        <h4>{!!$item->description!!}</h4>
                    </div>
                    @endforeach
               
                   
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('pageScript')
<script type="text/javascript" src="{{ asset('assets/js/script.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/page/auth.js')}}"></script>
@endsection