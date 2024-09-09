@extends('layouts.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
@endsection
@section('content')


<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="party-heading">
                <h3 class="mb-4">My Party</h3>
            </div>
        </div>
        <div class="col-md-12 overflow overflow-h">
            <!-- <div class="party-heading">
					<h3 class="mb-4">My Party</h3>
				</div> -->
            <div id="featureContainer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="party-banner" style="background-image:url({{ asset('assets/images/party-banner.png') }})">
                            <div class="row">
                                <div class="col-lg-4 offset-lg-8">
                                    <span>Welcome to <span>Partybookr</span></span>
                                    <h3>Start organizing your party!</h3>
                                    <p>We’ll help you set up your best party!</p>
                                    <!-- <a href="javascript:void(0);"></a> -->

                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#organizeparty">
                                        Organize Party
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="clearfix mt-4"></div>
            <div class="categories-widget">
                <div class="cat-head">
                    <form id="search-forms">
                        <div class="input-group">
                            <span class="input-group-append input-group-addon btn-filter">
                                <span class="input-group-text"><i class="las la-search"></i></span>
                            </span>
                            <input id="search" type="text" name="search" class="form-control" placeholder="Search">
                            <span class="input-group-append input-group-addon adv-search">
                                <?php /*<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#advancedsearch"><span class="input-group-text"><i class="las la-filter"></i></span></a> */ ?>
                                <a href="javascript:void(0);" class="btn-filter"><span class="input-group-text"><i class="las la-filter"></i></span></a>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-append input-group-addon">
                                <span class="input-group-text"><i class="las la-filter"></i></span>
                            </span>
                            <select class="select-control form-control" name="rating">
                                <option value="">Rating ds</option>
                                <option value="5">Rating 5</option>
                                <option value="4">Rating 4</option>
                                <option value="3">Rating 3</option>
                                <option value="2">Rating 2</option>
                                <option value="1">Rating 1</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <span class="input-group-append input-group-addon">
                                <span class="input-group-text"><img src="{{ asset('assets/images/p-icon-dark.png') }}"></span>
                            </span>
                            <select class="select-control form-control" name="sort_by">
                                <option value="">Sort By</option>
                                <option value="latest">Latest - Oldest</option>
                                <option value="oldest">Oldest - Latest</option>
                                <option value="most_booked">Most Booked</option>
                                <option value="A-Z">A-Z</option>
                                <option value="Z-A">Z-A</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="cat-name">
                    <?php
                    if (isset($category) && !empty($category)) {
                    ?>
                        <div class="cat-name">
                            <?php
                            foreach ($category as $key => $value) {
                            ?>
                                <div class="cat-name-box filter-category" data-id="<?php echo $value->id; ?>" <?php //other class active; 
                                                            ?>>
                                    <a href="javascript:void(0);"><img src="{{ $value->category_icon_url }}"></a>
                                    <p>{{ $value->category_name }}</p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                
                
                  <div class="cat-name">
                        <?php
                        use App\Helpers\Helper;
                        $helper = new Helper();
                        $subCategory = $helper->getSubCategory();
                        // echo "<pre>";Print_r($subCategory);exit;
                        ?>
                            <div class="cat-name">
                                <?php
                                foreach ($subCategory as $category){
                                ?>
                                    <div class="cat-name-box filter-category" data-id="{{ $category['id'] }}" >
                                        <a href="javascript:void(0);"><img src="{{asset('uploads/category/1704892894_-party.png')}}"></a>
                                        <p>{{ $category['category_name'] }}</p>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        
                    </div>
                <div class="cat-list">
                    <div class="slick-carousels">
                        <div class="sec-vendor-list">
                            @include('discover-vendor-list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4 mb-4 d-none">
    <div class="row">
        <div class="col-md-12">
            <div class="party-heading">
                <h3 class="mb-4">My Party</h3>
            </div>
        </div>
        <div class="col-lg-9 overflow overflow-h">
            <div id="featureContainer">
                <?php
                if (isset($myParty) && count($myParty) > 0) {
                ?>
                    <div class="cat-list">
                        <div class="slick-home">
                            <?php
                            foreach ($myParty  as $key => $value) {
                            ?>
                                <div class="col-md-4">
                                    <div class="my-party updated" <?php //echo 'Other class updated'; 
                                                                    ?>>
                                        <div class="myparty-head">
                                            <h4><?php echo $value->event_title; ?></h4>
                                            <a href="javascript:void(0);"><i class="las la-briefcase"></i></a>
                                        </div>
                                        <p class="details">Details</p>
                                        <p><i class="las la-map-marker"></i> <?php echo $value->event_location; ?></p>
                                        <p><i class="las la-calendar"></i> <?php echo $value->event_date; ?></p>
                                        <p><i class="las la-fire-alt"></i> <?php echo $value->event_category; ?></p>
                                        <p>Booking list</p>
                                        <ul>
                                            <li>
                                                <a href="javascript:void(0);" class="add-image"><i class="las la-plus"></i></a>
                                                <p>Vendors</p>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="add-image"><i class="las la-plus"></i></a>
                                                <p>Vendors</p>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="add-image"><i class="las la-plus"></i></a>
                                                <p>Vendors</p>
                                            </li>
                                            <?php /*
                                            <li>
                                                <img src="{{ asset('assets/images/party-1.png') }}">
                                                <p>Sydney ..</p>
                                            </li>
                                            */ ?>
                                            <li>
                                                <a href="javascript:void(0);" class="more">+4</a>
                                                <a href="javascript:void(0);">
                                                    <p>View All</p>
                                                </a>
                                            </li>
                                        </ul>
                                        <a href="javascript:void(0);" class="btn-trans btn-view-event-detail" data-url="{{ route('event.detail') }}" data-id="{{ $value->id }}"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> View My Party</a>
                                    </div>
                                </div>
                            <?php
                            }
                            /*
                    ?>
                        <div class="col-md-4">
                            <div class="my-party notupdated">
                                <div class="myparty-head">
                                    <h4>My Wedding Party!</h4>
                                    <a href="javascript:void(0);"><i class="las la-briefcase"></i></a>
                                </div>
                                <p class="details">Details</p>
                                <p><i class="las la-map-marker"></i> 856 E 23rd St Loveland, Colorado..</p>
                                <p><i class="las la-calendar"></i> Aug 23-Aug 24 | 9:00AM-6:00PM</p>
                                <p><i class="las la-fire-alt"></i> Weddings, Engagements & Showers</p>
                                <p>Booking list</p>
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" class="add-image"><i class="las la-plus"></i></a>
                                        <p>Vendors</p>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="add-image"><i class="las la-plus"></i></a>
                                        <p>Vendors</p>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="add-image"><i class="las la-plus"></i></a>
                                        <p>Vendors</p>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="add-image"><i class="las la-plus"></i></a>
                                        <p>Vendors</p>
                                    </li>
                                </ul>
                                <a href="javascript:void(0);" class="btn-trans">View my party</a>
                            </div>
                        </div>
                        */ ?>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="party-banner" style="background-image:url({{ asset('assets/images/party-banner.png') }})">
                                <div class="row">
                                    <div class="col-md-4 offset-md-8">
                                        <span>Welcome to <span>Partybookr</span></span>
                                        <h3>Start organizing your party!</h3>
                                        <p>We’ll help you set up your best party!</p>
                                        <!-- <a href="javascript:void(0);"></a> -->

                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#organizeparty">
                                            Organize Party
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="clearfix mt-4"></div>
            <div class="categories-widget">
                <div class="cat-head">
                    <h3>Categories</h3>
                    <a href="javascript:void(0);">View All </a>
                </div>
                <?php
                if (isset($category) && !empty($category)) {
                ?>
                    <div class="cat-name">
                        <?php
                        foreach ($category as $value) {
                        ?>
                            <div class="cat-name-box filter-category" data-id="<?php echo $value->id; ?>" <?php //other class active; 
                                                        ?>>
                                <a href="javascript:void(0);"><img src="{{ $value->category_icon_url }}"></a>
                                <p>{{ $value->category_name }}</p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
                <div class="cat-list">
                    <div class="slick-carousel">
                        <?php
                        if (isset($vendor_info) && !empty($vendor_info)) {
                            foreach ($vendor_info as $value) {
                        ?>
                                <div class="cat-list-box">
                                    <div class="cat-heads" style="background-image: url(<?php echo $value->banner_url; ?>);">
                                        <h4><?php echo $value->name; ?></h4>
                                        <a href="javascript:void(0);"><i class="las la-heart"></i></a>
                                    </div>
                                    <div class="cat-body">
                                        <p><img src="{{ asset('assets/images/map-gray.png') }}"> <?php echo !empty($value->address) ? $value->address : '-'; ?></p>
                                        <p><img src="{{ asset('assets/images/watch.png') }}"> <?php echo !empty($value->timing) ? $value->timing : '-'; ?></p>
                                        <div class="star-rating">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $value->avg_rating) {
                                                    echo '<i class="las la-star"></i>';
                                                } else {
                                                    echo '<i class="las la-star empty"></i>';
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="desc">
                                            <p><?php echo nl2br($value->description); ?></p>
                                        </div>
                                        <a href="javascript:void(0);" class="view-all-review btn-view-vendor-detail" data-url="{{ route('vendor.detail') }}" data-id="{{ $value->id }}"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> View details</a>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        /*
                        <div class="cat-list-box">
                            <div class="cat-heads" style="background-image: url(images/cat-banner.png);">
                                <h4>Sydney Opera House</h4>
                                <a href="javascript:void(0);"><i class="las la-heart"></i></a>
                            </div>
                            <div class="cat-body">
                                <p><img src="{{ asset('assets/images/map-gray.png') }}"> Venues</p>
                                <p><img src="{{ asset('assets/images/watch.png') }}"> Mon-Thur | 11:00AM-9:00PM</p>
                                <div class="star-rating">
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star-half"></i>
                                </div>
                                <div class="desc">
                                    <p>Imagine Dragons (formed 2008) emerged from the Las Vegas,</p>
                                </div>
                                <a href="javascript:void(0);" class="view-all-review">View details</a>
                            </div>
                        </div>

                        <div class="cat-list-box">
                            <div class="cat-heads" style="background-image: url(images/cat-banner.png);">
                                <h4>Sydney Opera House</h4>
                                <a href="javascript:void(0);"><i class="las la-heart"></i></a>
                            </div>
                            <div class="cat-body">
                                <p><img src="{{ asset('assets/images/map-gray.png') }}"> Venues</p>
                                <p><img src="{{ asset('assets/images/watch.png') }}"> Mon-Thur | 11:00AM-9:00PM</p>
                                <div class="star-rating">
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star-half"></i>
                                </div>
                                <div class="desc">
                                    <p>Imagine Dragons (formed 2008) emerged from the Las Vegas,</p>
                                </div>
                                <a href="javascript:void(0);" class="view-all-review">View details</a>
                            </div>
                        </div>

                        <div class="cat-list-box">
                            <div class="cat-heads" style="background-image: url(images/cat-banner.png);">
                                <h4>Sydney Opera House</h4>
                                <a href="javascript:void(0);"><i class="las la-heart"></i></a>
                            </div>
                            <div class="cat-body">
                                <p><img src="{{ asset('assets/images/map-gray.png') }}"> Venues</p>
                                <p><img src="{{ asset('assets/images/watch.png') }}"> Mon-Thur | 11:00AM-9:00PM</p>
                                <div class="star-rating">
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star-half"></i>
                                </div>
                                <div class="desc">
                                    <p>Imagine Dragons (formed 2008) emerged from the Las Vegas,</p>
                                </div>
                                <a href="javascript:void(0);" class="view-all-review">View details</a>
                            </div>
                        </div>

                        <div class="cat-list-box">
                            <div class="cat-heads" style="background-image: url(images/cat-banner.png);">
                                <h4>Sydney Opera House</h4>
                                <a href="javascript:void(0);"><i class="las la-heart"></i></a>
                            </div>
                            <div class="cat-body">
                                <p><img src="{{ asset('assets/images/map-gray.png') }}"> Venues</p>
                                <p><img src="{{ asset('assets/images/watch.png') }}"> Mon-Thur | 11:00AM-9:00PM</p>
                                <div class="star-rating">
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star-half"></i>
                                </div>
                                <div class="desc">
                                    <p>Imagine Dragons (formed 2008) emerged from the Las Vegas,</p>
                                </div>
                                <a href="javascript:void(0);" class="view-all-review">View details</a>
                            </div>
                        </div>

                        <div class="cat-list-box">
                            <div class="cat-heads" style="background-image: url(images/cat-banner.png);">
                                <h4>Sydney Opera House</h4>
                                <a href="javascript:void(0);"><i class="las la-heart"></i></a>
                            </div>
                            <div class="cat-body">
                                <p><img src="{{ asset('assets/images/map-gray.png') }}"> Venues</p>
                                <p><img src="{{ asset('assets/images/watch.png') }}"> Mon-Thur | 11:00AM-9:00PM</p>
                                <div class="star-rating">
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star-half"></i>
                                </div>
                                <div class="desc">
                                    <p>Imagine Dragons (formed 2008) emerged from the Las Vegas,</p>
                                </div>
                                <a href="javascript:void(0);" class="view-all-review">View details</a>
                            </div>
                        </div>

                        <div class="cat-list-box">
                            <div class="cat-heads" style="background-image: url(images/cat-banner.png);">
                                <h4>Sydney Opera House</h4>
                                <a href="javascript:void(0);"><i class="las la-heart"></i></a>
                            </div>
                            <div class="cat-body">
                                <p><img src="{{ asset('assets/images/map-gray.png') }}"> Venues</p>
                                <p><img src="{{ asset('assets/images/watch.png') }}"> Mon-Thur | 11:00AM-9:00PM</p>
                                <div class="star-rating">
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star"></i>
                                    <i class="las la-star-half"></i>
                                </div>
                                <div class="desc">
                                    <p>Imagine Dragons (formed 2008) emerged from the Las Vegas,</p>
                                </div>
                                <a href="javascript:void(0);" class="view-all-review">View details</a>
                            </div>
                        </div> */
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 overflow overflow-h">
            <!-- <div class="widget profile-widget">
                    <img src="{{ asset('assets/images/profile.png') }}" alt="profile">
                    <p class="pname">John doe</p>
                    <form>
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control is-disabled" value="John doe" readonly="">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control is-disabled" value="john@partybookr.com" readonly="">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control is-disabled" value="Premium@cater" readonly="">

                        
                        <a href="javascript:void(0);" class="view-all-review" id="editProfileA">Edit Profile</a>
                    </form>
                </div> -->
            <div class="sec-event-deail">
            </div>
            <div class="widget vendor-widget">
                <h4>My Vendors</h4>
                <span>Pending</span>
                <ul class="notilist">
                    <li class="notifi">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <img src="{{ asset('assets/images/vendor-1.png') }}">
                        <div class="noti-desc">
                            <h4>Imagine Dragons</h4>
                            <span>Any day | From 9:00AM to 9:00AM</span>
                        </div>
                    </li>
                    <li class="notifi">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <img src="{{ asset('assets/images/vendor-2.png') }}">
                        <div class="noti-desc">
                            <h4>Mcdonald’s</h4>
                            <span>Any day | From 9:00AM to 9:00AM</span>
                        </div>
                    </li>
                    <li class="notifi">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <img src="{{ asset('assets/images/vendor-3.png') }}">
                        <div class="noti-desc">
                            <h4>Winery club</h4>
                            <span>Any day | From 9:00AM to 9:00AM</span>
                        </div>
                    </li>
                </ul>
                <a href="{{ route('view.vendor') }}" class="view-all-review" id="editProfileA">View All Vendors</a>
            </div>
            <div class="widget profile-widget">
                <img src="{{ asset('assets/images/profile.png') }}" alt="profile">
                <p class="pname">{{ Auth::user()->name }}</p>
                <form method="POST" action="{{ route('update-profile') }}" onsubmit="return false;">
                    @csrf
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="full name" value="{{ Auth::user()->name }}" autocomplete="off" />
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="email addresss" value="{{ Auth::user()->email }}" autocomplete="off" />
                    <a href="javascript:void(0);" class="view-all-review btn-update-profile" id="editProfileA">Edit Profile</a>
                </form>
            </div>
            @if(empty(Auth::user()->provider))
            <div class="widget profile-widget">
                <p class="pname">Change Password</p>
                <form method="POST" action="{{ route('change-password') }}" onsubmit="return false;">
                    @csrf
                    <label class="current-password">Current Password </label>
                    <input type="password" name="current_password" class="form-control" value="" placeholder="******">
                    <label class="password">New Password </label>
                    <input type="password" name="password" class="form-control" value="" placeholder="******">
                    <label class="password_confirmation">Confirm Password </label>
                    <input type="password" name="password_confirmation" class="form-control" value="" placeholder="******">
                    <a href="javascript:void(0);" class="view-all-review btn-change-password" id="editProfileA">Change Password</a>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
@section('pageScript')
<script src="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.slick/1.4.1/slick.min.js"></script>
<script>
    $('#partydropdowns').on('click', function(event) {
        event.stopPropagation();
    });
    let items = document.querySelectorAll('#featureContainer .carousel .carousel-item');
    items.forEach((el) => {
        const minPerSlide = 3
        let next = el.nextElementSibling
        for (var i = 1; i < minPerSlide; i++) {
            if (!next) {
                next = items[0]
            }
            let cloneChild = next.cloneNode(true)
            el.appendChild(cloneChild.children[0])
            next = next.nextElementSibling
        }
    })
    $(document).ready(function() {
        $('#featureCarousel').carousel({
            interval: 1000 * 10
        });
        $('#featureCarousel').carousel('pause');

        // if desktop device, use DateTimePicker
        if ($("#datepicker").length > 0) {
            $("#datepicker").datetimepicker({
                useCurrent: false,
                format: "DD-MMM-YYYY",
                showTodayButton: true,
                icons: {
                    next: "las la-angle-right",
                    previous: "las la-angle-left",
                    today: 'todayText',
                }
            });
        }
        if ($("#timepicker").length > 0) {
            $("#timepicker").datetimepicker({
                format: "LT",
                icons: {
                    up: "las la-angle-up",
                    down: "las la-angle-down"
                }
            });
        }

        if ($('[name="create-event"]').length > 0) {
            $('[name="create-event"]').validate({
                errorClass: 'text-danger',
                errorPlacement: function(error, element) {
                    if (element.attr('name') != 'title') {
                        error.insertAfter($(element).closest('.input-group'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    title: {
                        required: true
                    },
                    location: {
                        required: true
                    },
                    event_date: {
                        required: true
                    },
                    category: {
                        required: true
                    },
                },
                messages: {
                    title: {
                        required: "Please enter title."
                    },
                    location: {
                        required: "Please enter location."
                    },
                    event_date: {
                        required: "Please enter date."
                    },
                    category: {
                        required: "Please enter category."
                    },
                }
            });

            $('[name="create-event"]').submit(function() {
                $('.validation-message,.success-message').remove();
                if ($('[name="create-event"]').valid()) {
                    $('[type="submit"]').attr('disabled', 'disabled');
                    $('[type="submit"]').find('.spinner-border').removeClass('d-none');
                    var current = $('[name="create-event"]');
                    $.ajax({
                        url: current.attr('action'),
                        method: 'POST',
                        data: current.serialize(),
                        dataType: 'json',
                        success: function(response) {
                            $('[type="submit"]').removeAttr('disabled');
                            $('[type="submit"]').find('.spinner-border').addClass('d-none');
                            if (response.status) {
                                $('.success-msg').removeClass('d-none');
                                $('<p class="text-success success-message">' + response.message + '</p>').insertBefore($('[name="title"]'));
                                setTimeout(function() {
                                    window.location = window.location.href;
                                }, 1000);
                            } else {
                                $.each(response.message, function(input, error) {
                                    $('<small class="text-danger validation-message small">' + error + '</small>').insertAfter($('[name="' + input + '"]'));
                                });
                            }
                        },
                        error: function(response) {
                            $('[type="submit"]').removeAttr('disabled');
                            $('[type="submit"]').find('.spinner-border').addClass('d-none');
                            if (typeof response.responseJSON.errors != undefined) {
                                $.each(response.responseJSON.errors, function(input, error) {
                                    $('<p class="text-danger validation-message small">' + error + '</p>').insertAfter($('[name="' + input + '"]'));
                                });
                            }
                        }
                    });
                }
            });
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.btn-view-event-detail', function() {
            var current = $(this);
            current.attr('disabled', 'disabled');
            current.find('.spinner-border').removeClass('d-none');
            $.ajax({
                url: current.attr('data-url'),
                method: 'POST',
                data: {
                    'id': current.attr('data-id')
                },
                dataType: 'json',
                success: function(response) {
                    current.removeAttr('disabled');
                    current.find('.spinner-border').addClass('d-none');
                    if (response.status) {
                        $('.sec-event-deail').html(response.data.html);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(response) {
                    current.removeAttr('disabled');
                    current.find('.spinner-border').addClass('d-none');
                    if (typeof response.responseJSON.errors != undefined) {
                        $.each(response.responseJSON.errors, function(input, error) {
                            alert(error);
                        });
                    }
                }
            });
        });


        $(document).on('click', '.btn-view-vendor-detail', function() {
            var current = $(this);
            current.attr('disabled', 'disabled');
            current.find('.spinner-border').removeClass('d-none');
            $.ajax({
                url: current.attr('data-url'),
                method: 'POST',
                data: {
                    'id': current.attr('data-id')
                },
                dataType: 'json',
                success: function(response) {
                    current.removeAttr('disabled');
                    current.find('.spinner-border').addClass('d-none');
                    if (response.status) {
                        $('.sec-event-deail').html(response.data.html);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(response) {
                    current.removeAttr('disabled');
                    current.find('.spinner-border').addClass('d-none');
                    if (typeof response.responseJSON.errors != undefined) {
                        $.each(response.responseJSON.errors, function(input, error) {
                            alert(error);
                        });
                    }
                }
            });
        });

        $('.slick-home').slick({
            arrows: false,
            centerPadding: "0px",
            dots: true,
            infinite: true,
            slidesToShow: 3,
            autoplay: 1000,
            interval: 1000,
            centerMode: true,
            responsive: [{
                    breakpoint: 1440,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 1367,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 540,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });

        $(document).on('click', '.btn-open-event-action', function() {
            var current = $(this);
            $('.event-action-modal').find('[data-id]').attr('data-id', current.attr('data-id'));
            $('.event-action-modal').modal('show');
        });

        $(document).on('click', '.btn-delete-event', function() {
            var current = $(this);
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure want to delete party?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-success',
                        action: function() {
                            $('#cover-spin').show();
                            $.ajax({
                                url: current.attr('data-href'),
                                type: 'POST',
                                data: {
                                    'id': current.attr('data-id'),
                                },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status) {
                                        toastr.success(response.message);
                                        setTimeout(function() {
                                            window.location = window.location.href;
                                        }, 500);
                                    } else {
                                        toastr.error(response.message);
                                    }
                                    $('#cover-spin').hide();
                                }
                            });
                        }
                    },
                    cancel: function() {}
                }
            });
        });

        $(document).on('click', '.btn-edit-event', function() {
            var current = $(this);
            $('#cover-spin').show();
            $.ajax({
                url: current.attr('data-href'),
                type: 'POST',
                data: {
                    'id': current.attr('data-id'),
                    'action': 'detail'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        $('#bookingopt').modal('hide');
                        $('#organizeparty').find('[name="id"]').val(response.data.event_detail.id);
                        $('#organizeparty').find('[name="title"]').val(response.data.event_detail.event_title);
                        $('#organizeparty').find('[name="location"]').val(response.data.event_detail.event_location);
                        $('#organizeparty').find('[name="event_date"]').val(response.data.event_detail.event_date);                        
                        $('#organizeparty').find('[name="category"]').val(response.data.event_detail.event_category);
                        $('#organizeparty').modal('show');
                    } else {
                        toastr.error(response.message);
                    }
                    $('#cover-spin').hide();
                }
            });
        });
    });
</script>
@endsection
@section('pageScriptlinks')
<script type="text/javascript" src="{{ asset('assets/js/script.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/page/auth.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/discover.js')}}"></script>
@endsection