@extends('layouts.app')
@section('content')
<section id="contact-page">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="page-headings text-center">
                    <h1>Terms of Use</h1>
                    <div class="search-tems" style="display: none;">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="terms"><i class="las la-search"></i></span>
                            <input type="text" class="form-control" placeholder="Search" aria-label="search" aria-describedby="terms">
                        </div>
                    </div>
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