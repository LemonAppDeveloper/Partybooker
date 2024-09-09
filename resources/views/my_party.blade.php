@extends('layouts.app')

@section('content')
    <div class="container mt-4 mb-4">
        <div class="row">
            @include('left')
            <div class="col-md-3">
				<div class="widget mywedding-widget">
					<div class="mywedding-head mb-4">
                    	<h3>My Wedding Party!</h3>
                    	<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#bookingopt"><i class="las la-ellipsis-h"></i></a>						
					</div>
					<p>Party Details</p>
					<div class="my-details">
						<p><i class="las la-map-marker"></i> 856 E 23rd St Loveland, Colora...</p>
						<div class="date-time">
							<div class="left-side">
								<i class="las la-calendar"></i>
								<p>Feb 23 -<br>Feb 24</p>								
							</div>
							<div class="right-side">
								<i class="las la-stopwatch"></i>
								<p>9:00AM -<br>9:00PM</p>
							</div>
						</div>
						<p><i class="las la-fire"></i> Weddings, Engagement & Sh...</p>						
					</div>

					<div class="mywedding-head mt-4 mb-4">
                    	<h3>My Vendors</h3>
                    	<a href="#">Select all</a>
					</div>
                    <nav>
						<div class="nav nav-tabs justify-content-center nav-fill" id="nav-tab" role="tablist">
							<a class="nav-link active" href="javascript:void(0)" id="shortlist-tab" data-bs-toggle="tab" data-bs-target="#shortlist" type="button" role="tab" aria-controls="shortlist" aria-selected="true">Shortlist</a>
							<a class="nav-link" href="javascript:void(0)" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="false">Pending</a>
							<a class="nav-link" href="javascript:void(0)" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirmed" type="button" role="tab" aria-controls="confirmed" aria-selected="false">Confirmed</a>
						</div>
					</nav>
					<div class="tab-content pt-3 bg-white" id="nav-tabContent">
						<div class="tab-pane fade active show" id="shortlist" role="tabpanel" aria-labelledby="shortlist-tab">
							<ul class="notilist">
								<li class="notifi">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<img src="{{asset('assets/images/vendor-1.png')}}">
									<div class="noti-desc">
										<h4>Imagine Dragons</h4>
										<span>Any day | From 9:00AM to 9:00AM</span>
									</div>
								</li>
								<li class="notifi">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<img src="{{asset('assets/images/vendor-2.png')}}">
									<div class="noti-desc">
										<h4>Mcdonald’s</h4>
										<span>Any day | From 9:00AM to 9:00AM</span>
									</div>
								</li>
								<li class="notifi">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<img src="{{asset('assets/images/vendor-3.png')}}">
									<div class="noti-desc">
										<h4>Winery club</h4>
										<span>Any day | From 9:00AM to 9:00AM</span>
									</div>
								</li>
								<li class="notifi">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<img src="{{asset('assets/images/vendor-3.png')}}">
									<div class="noti-desc">
										<h4>Winery club</h4>
										<span>Any day | From 9:00AM to 9:00AM</span>
									</div>
								</li>
							</ul>
						</div>
						<div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
							<ul class="notilist">
								<li class="notifi">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<img src="{{asset('assets/images/vendor-1.png')}}">
									<div class="noti-desc">
										<h4>My Wedding Party!</h4>
										<span class="pending">Pending</span>
										<span>Any day | From 9:00AM to 9:00AM</span>
									</div>
								</li>
								<li class="notifi">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<img src="{{asset('assets/images/vendor-2.png')}}">
									<div class="noti-desc">
										<h4>My Wedding Party!</h4>
										<span class="pending">Pending</span>
										<span>Any day | From 9:00AM to 9:00AM</span>
									</div>
								</li>
								<li class="notifi">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<img src="{{asset('assets/images/vendor-3.png')}}">
									<div class="noti-desc">
										<h4>My Wedding Party!</h4>
										<span class="pending">Pending</span>
										<span>Any day | From 9:00AM to 9:00AM</span>
									</div>
								</li>
								<li class="notifi">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									<img src="{{asset('assets/images/vendor-3.png')}}">
									<div class="noti-desc">
										<h4>My Wedding Party!</h4>
										<span class="pending">Pending</span>
										<span>Any day | From 9:00AM to 9:00AM</span>
									</div>
								</li>
								
							</ul>
						</div>
						<div class="tab-pane fade" id="confirmed" role="tabpanel" aria-labelledby="confirmed-tab">
							<ul class="notilist">
								<li class="notifi">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
									<img src="{{asset('assets/images/vendor-1.png')}}">
									<div class="noti-desc">
										<h4>My Wedding Party!</h4>
										<span class="confirmed">Confirmed</span>
										<span>Any day | From 9:00AM to 9:00AM</span>
									</div>
								</li>
								<li class="notifi">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
									<img src="{{asset('assets/images/vendor-2.png')}}">
									<div class="noti-desc">
										<h4>My Wedding Party!</h4>
										<span class="confirmed">Confirmed</span>
										<span>Any day | From 9:00AM to 9:00AM</span>
									</div>
								</li>
							</ul>
						</div>
					</div>
                    <a href="javascript:void(0);" class="view-all-review checkout-btn">Proceed to checkout</a>
                </div>
			</div>
        </div>
    </div>
	@include('model.bookingopt')
@endsection