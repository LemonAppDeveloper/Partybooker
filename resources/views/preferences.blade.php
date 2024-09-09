@extends('layouts.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
@endsection
@section('content')
    <div class="container">
		<div class="row">
            <div class="col-md-5">
                <div class="setting-up-left">
                    <h1>Lets get this party started.</h1>
					<p>We will help you find what you’re looking for by setting up your party</p>
                </div>
            </div>
            <div class="col-md-5 offset-md-2">
                <div class="party-reg">
                    <h2>Let’s organize your party</h2>
					<p>Let us serve you better (fill up all the details needed).</p>
                    <form method="POST" action="{{ route('createEvent') }}" id="createEventForm">
                        @csrf
                        <input type="text" name="title" id="title" class="form-control" placeholder="Add a title of the event">
                        <div class="frm-grp">
                            <div class="input-group">
                                <span class="input-group-append input-group-addon">
                                    <span class="input-group-text"><i class="las la-map-marker"></i></span>
                                </span>
                                <input type="text" id="locationAdd"  name="location" class="form-control" placeholder="Add location of the party">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group date" id="datepicker">
                                        <span class="input-group-append input-group-addon">
                                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                                        </span>
                                        <input class="form-control" placeholder="MM/DD/YYYY" name="event_date" id="event_date"/>
                                    </div>
                                </div>
                            </div>						
                            <div class="input-group category">
                                <span class="input-group-append input-group-addon">
                                    <span class="input-group-text"><i class="las la-fire-alt"></i></span>
                                </span>
                                <input type="text" name="category" class="form-control" placeholder="Add category">
                            </div>
                            <button class="btn btn-gradient">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="skip">
			<a href="{{URL::to('/discover')}}">Skip &nbsp;<i class="las la-arrow-right"></i></a>
		</div>
    </div>
@endsection
@section('pageScript')
    <script type="text/javascript" src="{{asset('assets/js/page/preferences.js')}}"></script>
@endsection