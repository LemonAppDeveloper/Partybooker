@extends('layouts.app')
@section('content')
<section id="aboutpage">
    <div class="images-1">
        <img src="{{ asset('assets/images/about-banner-1.png') }}" alt="about">
    </div>
    <div class="images-2">
        <img src="{{ asset('assets/images/about-banner-2.png') }}" alt="about">
    </div>
    <div class="images-3">
        <img src="{{ asset('assets/images/about-banner-3.png') }}" alt="about">
    </div>
    <div class="images-4">
        <img src="{{ asset('assets/images/about-banner-4.png') }}" alt="about">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="page-heading">
                    <p>All you need to know</p>
                    <h1>About Us</h1>
                    <a href="/">Start Exploring</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="whoweare">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="whowe-box">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="title">
                                <h1>Who we are?</h1>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="who-lists">
                                <img src="{{ asset('assets/images/who-icon-1.png') }}">
                                <div class="who-desc">
                                    <h3>Reprehenderit minim</h3>
                                    <p>Ex cupidatat tempor labore eiusmod exercitation aute est nulla id ea. Ut nisi sit mollit voluptate qui sunt adipisicing laboris nostrud</p>
                                </div>
                            </div>
                            <hr>
                            <div class="who-lists">
                                <img src="{{ asset('assets/images/who-icon-2.png') }}">
                                <div class="who-desc">
                                    <h3>Ea aliqua</h3>
                                    <p>Ex cupidatat tempor labore eiusmod exercitation aut nulla id ea.</p>
                                </div>
                            </div>
                            <hr>
                            <div class="who-lists">
                                <img src="{{ asset('assets/images/who-icon-3.png') }}">
                                <div class="who-desc">
                                    <h3>Id veniam in sunt</h3>
                                    <p>Consectetur laboris cupidatat dolore duis enim dolor laborum mollit cillum minim deserunt. Enim nulla ex ipsum eiusmod qui nulla incididunt enim qui mollit sint reprehenderit ullamco</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="trustedby">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h4>Trusted by</h4>
                </div>
            </div>
            <div class="logos">
                <div class="logos-slider">
                    <div class="slide"><img src="{{ asset('assets/images/logo-1.png') }}"></div>
                    <div class="slide"><img src="{{ asset('assets/images/logo-2.png') }}"></div>
                    <div class="slide"><img src="{{ asset('assets/images/logo-3.png') }}"></div>
                    <div class="slide"><img src="{{ asset('assets/images/logo-4.png') }}"></div>
                    <div class="slide"><img src="{{ asset('assets/images/logo-5.png') }}"></div>
                    <div class="slide"><img src="{{ asset('assets/images/logo-6.png') }}"></div>
                    <div class="slide"><img src="{{ asset('assets/images/logo-1.png') }}"></div>
                    <div class="slide"><img src="{{ asset('assets/images/logo-2.png') }}"></div>
                    <div class="slide"><img src="{{ asset('assets/images/logo-3.png') }}"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="ourbenefits">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="heading">
                    <h1>Our benefits</h1>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="benefits-box">
                    <img src="{{ asset('assets/images/benefits-icon-1.png') }}">
                    <p>Sample Text here Only</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="benefits-box bg-1">
                    <img src="{{ asset('assets/images/benefits-icon-2.png') }}">
                    <p>Sample Text here Only</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="benefits-box bg-2">
                    <img src="{{ asset('assets/images/benefits-icon-3.png') }}">
                    <p>Sample Text here Only</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="benefits-box bg-3">
                    <img src="{{ asset('assets/images/benefits-icon-4.png') }}">
                    <p>Sample Text here Only</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="benefits-box bg-4">
                    <img src="{{ asset('assets/images/benefits-icon-5.png') }}">
                    <p>Sample Text here Only</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="benefits-box bg-5">
                    <img src="{{ asset('assets/images/benefits-icon-6.png') }}">
                    <p>Sample Text here Only</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="moreaboutus">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h1>More About Us</h1>
                    <p>In minim mollit exercitation deserunt proident <br>officia sint excepteur aute eiusmod. Aute ullamc</p>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="about-slider">
        <div class="moreaboslider">
            <div class="abs-slider">
                <img src="{{ asset('assets/images/about-slider.png') }}" alt="about-slider">
                <h3>About Us Title</h3>
                <p>Magna magna dolor ad ullamco sit veniam. Mollit nulla exercitation incididunt consectetur labore nisi consectetur dolore ex aute adipisicing.Dolore adipisicing non.</p>
            </div>
            <div class="abs-slider">
                <img src="{{ asset('assets/images/about-slider-1.png') }}" alt="about-slider">
                <h3>About Us Title</h3>
                <p>Magna magna dolor ad ullamco sit veniam. Mollit nulla exercitation incididunt consectetur labore nisi consectetur dolore ex aute adipisicing.Dolore adipisicing non.</p>
            </div>
            <div class="abs-slider">
                <img src="{{ asset('assets/images/about-slider.png') }}" alt="about-slider">
                <h3>About Us Title</h3>
                <p>Magna magna dolor ad ullamco sit veniam. Mollit nulla exercitation incididunt consectetur labore nisi consectetur dolore ex aute adipisicing.Dolore adipisicing non.</p>
            </div>
            <div class="abs-slider">
                <img src="{{ asset('assets/images/about-slider-1.png') }}" alt="about-slider">
                <h3>About Us Title</h3>
                <p>Magna magna dolor ad ullamco sit veniam. Mollit nulla exercitation incididunt consectetur labore nisi consectetur dolore ex aute adipisicing.Dolore adipisicing non.</p>
            </div>
        </div>
    </div>
</section>
<section id="testimonials">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="test-image">
                    <img src="{{ asset('assets/images/testimonials.png') }}" alt="testimonials">
                </div>
            </div>
            <div class="col-md-6 offset-md-1">
                <div class="testimonials-caption">
                    <h1>Testimonials</h1>
                    <p>"The user interface is intuitive, and the features are powerful yet easy to use. It has definitely helped me become more organized and productive"</p>
                    <span>Client name -  Company</span>
                    <a href="#" class="btn btn-testimonials">Next</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="getstarted">
    <img src="{{ asset('assets/images/get-2.png') }}" alt="vector" class="vector-1">
    <img src="{{ asset('assets/images/get-1.png') }}" alt="vector" class="vector-2">
    <img src="{{ asset('assets/images/get-3.png') }}" alt="vector" class="vector-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="get-caption">
                    <h1>Get started!</h1>
                    <p>Qui ut exercitation officia proident enim non tempor tempor ipsum ex nulla ea adipisicing sit consequat</p>
                    <a href="/" class="exploring-btn">Start Exploring</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="started-det">
                    <div class="cat-list1">
                        <div class="cat-list-box">
                            <div class="cat-heads" style="background-image: url(images/cat-banner.png);">
                                <a href="#"><i class="las la-heart"></i></a>
                            </div>
                            <div class="cat-body">
                                <h4>Sydney Opera House</h4>
                                <p><img src="{{ asset('assets/images/marker.png') }}"> Venues</p>
                                <p><img src="{{ asset('assets/images/clock.png') }}"> Mon-Thur | 11:00AM-9:00PM</p>
                            </div>
                        </div>
                    </div>
                    <div class="user-det">
                        <div class="users">
                            <img src="{{ asset('assets/images/user-icon.png') }}" alt="users">
                        </div>
                        <div class="users-name">
                            <b>Unknow Birds</b>
                            <p>Floor</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="f-about">
                    <img src="{{ asset('assets/images/favicon.png') }}" alt="icon">
                    <p>Sed ut perspiciatis unde om is nerror sit voluptatem accustium dolorem tium totam rem aperam quae.</p>
                    <ul class="fsocial-links">
                        <li><a href="#"><img src="{{ asset('assets/images/instagram.svg') }}" alt="instagram"></a></li>
                        <li><a href="#"><img src="{{ asset('assets/images/facebook.svg') }}" alt="facebook"></a></li>
                        <li><a href="#"><img src="{{ asset('assets/images/twitter.svg') }}" alt="twitter"></a></li>
                        <li><a href="#"><img src="{{ asset('assets/images/google.svg') }}" alt="google"></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="flinks">
                    <h3>Useful Links</h3>
                    <span class="lines"></span>
                    <span class="lines"></span>
                    <span class="lines"></span>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="{{url('about')}}">About Us</a></li>
                        <li><a href="#">Feature</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="{{url('contact')}}">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-2 offset-lg-1">
                <div class="flinks">
                    <h3>Company News</h3>
                    <span class="lines"></span>
                    <span class="lines"></span>
                    <span class="lines"></span>
                    <ul>
                        <li><a href="#">Our Team</a></li>
                        <li><a href="#">Vendor link</a></li>
                        <li><a href="#">End User Link</a></li>
                        <li><a href="{{url('privacy-policy')}}">Privacy Policy</a></li>
                        <li><a href="{{url('terms-of-use')}}">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-2 offset-lg-1">
                <div class="flinks">
                    <h3>Contact us</h3>
                    <span class="lines"></span>
                    <span class="lines"></span>
                    <span class="lines"></span>
                    <div class="con-box">
                        <div class="icon-box">
                            <img src="{{ asset('assets/images/icon-1.png') }}">
                        </div>
                        <p><b>Call Us</b><br>+123 456 7890</p>
                    </div>
                    <div class="con-box">
                        <div class="icon-box">
                            <img src="{{ asset('assets/images/icon-2.png') }}">
                        </div>
                        <p><b>Email</b><br>info@example.com</p>
                    </div>
                    <div class="con-box">
                        <div class="icon-box">
                            <img src="{{ asset('assets/images/icon-3.png') }}">
                        </div>
                        <p><b>Email</b><br>info@example.com</p>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <p class="footer-copy">
                &copy; {{ \Carbon\Carbon::now()->year }} @ partybookr.com
            </p>
        </div>
    </div>
</footer>


<div class="modal fade" id="checkout" tabindex="-1" aria-labelledby="checkoutLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-7 col-md-6">
						<form action="party-confirmed.html">
							<div class="checkout">
								<h3>Checkout</h3>
								<div class="party-details">
									<p>Party Details</p>
									<a href="javascript:void()" id="addnewcard">+ Add new card</a>
								</div>
								<div class="select-card">
									<span>Credit/Debit Card</span>
									<i class="las la-angle-down"></i>
								</div>
								<div class="card-name">
									<div class="cards"><img src="images/visa.png" alt="visa"></div>
									<div class="cards"><img src="images/DinersClub.png" alt="DinersClub"></div>
									<div class="cards"><img src="images/AMEX.png" alt="AMEX"></div>
									<div class="cards"><img src="images/Mastercard.png" alt="Mastercard"></div>
									<div class="cards"><img src="images/JCB.png" alt="JCB"></div>
								</div>
								<div class="selectcards show">
									<div class="card-lists">
										<div class="cname">
											<input type="radio" name="card">
											<img src="images/visa.png" alt="visa"/>
											<span>Credit Card</span>
										</div>
										<p>Ending with *****2831</p>
									</div>
									<div class="card-lists">
										<div class="cname">
											<input type="radio" name="card">
											<img src="images/Mastercard.png" alt="Mastercard" />
											<span>Credit Card</span>
										</div>
										<p>Ending with *****4331</p>
									</div>
								</div>
								<div class="addcards">
									<span>Card Holder Name</span>
									<input type="text" name="name" class="form-control">
									<span>Card Number</span>
									<input type="text" name="cardnumber" class="form-control">
									<span>Expiration Date</span>
									<input type="text" name="expirydate" class="form-control">
									<span>CVC</span>
									<input type="text" name="CVC" class="form-control">									
								</div>
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="remember">
									<label class="form-check-label text-start" for="remember">
										Terms & Conditions <br><br>
										I have read and agree to the <b><a href=""</b>, <b>Privacy Policy</b>, and <b>Internet Security Information Policy</b>.
									</label>
								</div>
								<div class="modal-footer">
									<button class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
									<button class="btn book-pkg">Pay Now</button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-5 col-md-6">
						<div class="party-summary">
							<div class="modal-header">
								<h3>Party Summary</h3>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<span>Please double check before proceeding.</span>
							<hr>
							<h4>Party Details</h4>
							<div class="details-list">
								<label>Party Name</label>
								<p>My Wedding Party!</p>
							</div>
							<div class="details-list">
								<label>Party Address</label>
								<p>856 E 23rd St Loveland, Colorado..</p>
							</div>
							<div class="details-list">
								<label>Party Date</label>
								<p>Aug 23, 2022</p>
							</div>
							<div class="details-list">
								<label>Category</label>
								<p>Weddings, Engagements & Showers</p>
							</div>
							<h4>Booking Lists</h4>
							<div class="details-list">
								<label>Venus</label>
								<p>Sydney Opera House</p>
							</div>
							<div class="details-list">
								<label>DJ & Entertainers</label>
								<p>John Mayer</p>
							</div>
							<div class="details-list">
								<label>Furniture</label>
								<p>Allsetrentals</p>
							</div>
							<hr>
							<div class="details-list">
								<label>Subtotal</label>
								<p>$2200.00</p>
							</div>
							<div class="details-list vat">
								<label>VAT</label>
								<p>$50.00</p>
							</div>
							<div class="details-list total">
								<label>Total</label>
								<p>$2250.00</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="deleteparty" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deletepartyLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deletepartyLabel">Delete Party</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<p>Are you sure you want to delete Party?</p>
        <button type="button"  data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-dark btn-block">Cancel</button>
        <button type="button" class="btn btn-danger btn-block">Delete Party</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="dateselection" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dateselectionLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dateselectionLabel">Party Date Range</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<div class="time-selection modl">
      		<div class="fromdate">
      			<p>From: <span>Feb 23</span></p>
      		</div>
      		<div class="todate">
      			<p>To: <span>Feb 23</span></p>      			
      		</div>
		</div>
		<div id="calendar">
            <div id="calendar_header">
                <i class="icon-chevron-left las la-angle-left"></i>
                <h1></h1><i class="icon-chevron-right las la-angle-right"></i>
            </div>
            <div id="calendar_weekdays"></div>
            <div id="calendar_content"></div>
        </div>

        <a href="#" class="view-all-review checkout-btn" data-bs-dismiss="modal" aria-label="Close">Choose this date</a>
        <button type="button"  data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-dark btn-block">Cancel</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('pageScript')
<script type="text/javascript" src="{{ asset('assets/js/script.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/page/auth.js')}}"></script>
<script src="{{ asset('assets/js/slick.js') }}"></script>
<script>
	$('#selectAll').click(function (e) {
	    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
	});

	$(function() {

	  function setCheck(o, c) {
	    o.prop("checked", c);
	    if (c) {
	      o.closest("tr").addClass("checked");
	    } else {
	      o.closest("tr").removeClass("checked");
	    }
	  }

	  function setCheckAll(o, c) {
	    o.each(function() {
	      setCheck($(this), c);
	    });
	    if (c) {
	      $("#selectAll").prop("title", "Check All");
	    } else {
	      $("#selectAll").prop("title", "Uncheck All");
	    }
	  }

	  $("#selectAll").on('change', function() {
	    setCheckAll($("tbody input[type='checkbox']"), $(this).prop("checked"));
	  });
	  $("tbody tr").on("click", function(e) {
	    var chk = $("[type='checkbox']", this);
	    setCheck(chk, !$(this).hasClass("checked"));
	  });
	});
</script>
<script>
	$(".pdt").click(function(){
		$(".menus").parent().toggleClass("showopt");
	});

	$(".mypt").click(function(){
		$(".mypt").parent().toggleClass("showlist");
	});

	$(".moreptydtl").click(function(){
		$(".more-det").toggleClass("show");
		$(".moreptydtl").toggleClass("show");
	});
</script>
<script>
    //logo slider
    
    $('.logos-slider').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        arrows: false,
        dots: false,
        pauseOnHover: false,
        responsive: [{
        breakpoint: 768,
        settings: {
            slidesToShow: 4
        }
        }, {
            breakpoint: 520,
            settings: {
                slidesToShow: 2
            }
        }]
    });
    </script>
    
    <script>
    //more about slider
    
    $('.moreaboslider').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 15000000,
        arrows: true,
        dots: false,
        pauseOnHover: false,
        responsive: [{
        breakpoint: 1024,
        settings: {
            slidesToShow: 1
        }
        }, {
            breakpoint: 520,
            settings: {
                slidesToShow: 1
            }
        }]
    });
    </script>
    <script src="{{ asset('assets/js/calendar.js') }}"></script>
@endsection