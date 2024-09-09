@extends('layouts.vendor.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
@endsection
@section('content')
<div class="container">
    <div class="row d-none">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-4 overflow">
                    <div class="plan-list">
                        <div class="plan-titles">
                            <h3>Your Plans</h3>
                            <a href="javascript:void(0);" class="open-modal-addUpdatePlan d-none">Add Plan</a>
                        </div>
                        <p class="d-none">Your Plans</p>
                        <div class="plan-short d-none">
                            <form action="{{ route('getPlan') }}" name="form-filter-plan" onsubmit="return false;" class="form-horizontal">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="form-control" name="is_enable">
                                            <option value="1">Active</option>
                                            <option value="2">InActive</option>
                                            <option value="">All</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" name="filter_by">
                                            <option value="new_to_old">Newest</option>
                                            <option value="old_to_new">Oldest</option>
                                            <option value="price_high_to_low">High Price</option>
                                            <option value="price_low_to_high">Low Price</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="sec-plan-list">
                            <?php

                            use Illuminate\Support\Facades\Auth;

                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 overflow">
                    <div class="vendor-description widget">
                        <div class="widget-heading">
                            <h3>Vendor Description</h3>
                            <a href="javascript:void(0);" class="update-description">Edit</a>
                        </div>
                        <div class="widget-body d-block">
                            <div class="row sec-update-description d-none">
                                <div class="col-md-12">
                                    <form action="{{ route('updateDescription') }}" onsubmit="return false;">
                                        @csrf
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" rows="5">{{ Auth::user()->getDescription() }}</textarea>
                                        </div>
                                        <button type="button" class="view-all-review btn-edit js-edit btn-update-description"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Update</button>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 sec-description">
                                    <p>{!! nl2br(Auth::user()->getDescription()) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="order-derails">
                        <div class="order-head">
                            <h3>Customer reviews</h3>
                            <a href="#" class="d-none">View All </a>
                        </div>
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($customer_reviews) && !empty($customer_reviews)) {
                                    foreach ($customer_reviews as $value) {
                                ?>
                                        <tr>
                                            <td><?php echo $value->full_name; ?></td>
                                            <td><?php echo nl2br($value->review); ?></td>
                                            <td><?php echo $value->rating; ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="3">Records not available.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>



                    <div class="average-revenue" style="display: none;">
                        <div class="average-head">
                            <h3>Average Activity</h3>
                            <div class="graph-info">
                                <p><span class="orange"></span> Peak</p>
                                <p><span class="blue"></span> Inactivity</p>
                            </div>
                        </div>
                        <div class='graph-wrapper'>
                            <div class='graph' id='pushups'></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-3 editProfileHide overflow">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget profile-widget">
                        <?php
                        $path = asset('vendor-assets/images/profile.png');
                        if (Auth::user()->profile_image != '') {
                            $path = asset('uploads/profile/' . Auth::user()->profile_image);
                        }
                        ?>
                        <img src="{{ $path }}" alt="profile" class="w-100">
                        <p class="pname">{{ Auth::user()->name }}</p>
                        <form>
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" readonly>
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                            <?php
                            $helper = new App\Helpers\Helper();
                            $category = $helper->getCategory();
                            ?>
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control ccat" name="id_category" disabled>
                                    <option value="">Select</option>
                                    <?php
                                    if (!empty($category)) {
                                        $selected = Auth::user()->getCategory();
                                        foreach ($category as $value) {
                                            $selected_text = $value->id == $selected ? 'selected="selected"' : '';
                                    ?>
                                            <option value="{{ $value->id }}" {{ $selected_text }}>{{ $value->category_name }}</option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <a href="javascript:void(0);" class="view-all-review" id="editProfileA" data-bs-toggle="modal" data-bs-target="#editpro">Edit Profile</a>
                        </form>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="vendor-details">
                        <div class="vdt-gallery">
                            <h4>Gallery</h4>
                            <div class="row">
                                <?php
                                $settings = array(
                                    'id' => Auth::user()->id,
                                    'limit' => 3
                                );
                                $images = getVendorGallery($settings);
                                if (isset($images) && $images['row_count'] > 0) {
                                    $class = array('col-md-12', 'col-md-7', 'col-md-5');
                                    foreach ($images['data'] as $key => $image) {
                                ?>
                                        <div class="{{ $class[$key] }}">
                                            <img src="{{ $image->image_url }}">
                                        </div>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <div class="col-md-12">
                                        <p class="text-center text-muted">No added gallery yet.</p>
                                    </div>
                                <?php
                                }
                                ?>
                                <div class="col-md-12">
                                    <a href="{{ url('vendor/gallery') }}" class="view-all-review">Edit Gallery</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="customer-review">
                        <h4>Customer Reviews</h4>
                        <?php
                        $settings = array(
                            'filter_by' => 'new_to_old',
                            'id_vendor' => Auth::user()->id
                        );
                        $getVendorReviews = getVendorReviews($settings);
                        if (!empty($getVendorReviews)) {
                            foreach ($getVendorReviews as $value) {
                        ?>
                                <div class="review-listing">
                                    <p>
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $value->rating) {
                                                echo '<i class="las la-star"></i>';
                                            } else {
                                                echo '<i class="las la-star empty"></i>';
                                            }
                                        }
                                        ?>
                                    </p>
                                    <span>{{ format_datetime($value->created_at) }}</span>
                                    <b>{{ nl2br($value->review) }}</b>
                                    <div class="review-name">
                                        <p>{{ $value->full_name }}</p>
                                        <a href="#" class="d-none">Reply</a>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <a href="<?php echo url('/'); ?>/vendor/gallery" class="view-all-review">View All Reviews</a>
                        <?php
                        } else {
                        ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-center text-muted">No reviews yet.</p>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 editProfileShow overflow">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget profile-widget">
                        <div class="widget-heading">
                            <h3>Profile Information</h3>
                        </div>
                        <img src="{{ asset('vendor-assets/images/profile.png') }}" alt="profile">
                        <form>
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" value="Premium Catering">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" value="Premium@cater.com">
                            <label>Category</label>
                            <select class="form-control">
                                <option>Florist</option>
                                <option>Florist</option>
                                <option>Florist</option>
                            </select>
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="Premium@cater">
                            <label>Repeat Password</label>
                            <input type="password" name="repassword" class="form-control" value="Premium@cater">
                            <hr>
                            <h3>Schedule Management</h3>
                            <p>Time Availability</p>
                            <select class="form-control">
                                <option>9:00 AM</option>
                                <option>9:30 AM</option>
                                <option>10:00 AM</option>
                                <option>10:30 AM</option>
                            </select>
                            <select class="form-control">
                                <option>7:00 PM</option>
                                <option>7:30 PM</option>
                                <option>8:00 PM</option>
                                <option>8:30 PM</option>
                            </select>
                            <p>Date Availability</p>
                            <div id="calendar">
                                <div id="calendar_header">
                                    <i class="icon-chevron-left las la-angle-left"></i>
                                    <h1></h1><i class="icon-chevron-right las la-angle-right"></i>
                                </div>
                                <div id="calendar_weekdays"></div>
                                <div id="calendar_content"></div>
                            </div>
                            <span class="note">Note: Orange is already booked by other customer</span>
                            <a href="#" class="view-all-review" data-bs-toggle="modal" data-bs-target="#schedules">View all schedule</a>
                            <hr>
                            <h3>Terms & Condition</h3>
                            <p>Vendor</p>
                            <span>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</span>
                            <p>Customer</p>
                            <span>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</span>
                            <a href="javascript:void(0);" class="view-all-review">Save Changes</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-addUpdatePlan" tabindex="-1" aria-labelledby="addUpdatePlanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUpdatePlanLabel">Add/Update Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="is-readonly" action="{{ route('addUpdatePlan') }}" onsubmit="return false;">
                    @csrf
                    <input type="hidden" name="id" value="" />
                    <div class="profiless">
                    </div>
                    <div class="form-group mt-3">
                        <label>Banner</label>
                        <input type="file" name="plan_image" class="form-control cname" value="" accept="image/*">
                        <span class="clearname"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label>Plan Name</label>
                        <input type="text" name="plan_name" class="form-control" value="" placeholder="Plan Name">
                        <span class="clearname"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label>Title</label>
                        <input type="text" name="plan_title" class="form-control" value="" placeholder="Title">
                        <span class="clearname"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label>Sub Title</label>
                        <input type="text" name="plan_sub_title" class="form-control" value="" placeholder="Sub Title">
                        <span class="clearname"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label>Description</label>
                        <textarea class="form-control" rows="5" name="plan_description" placeholder="Description"></textarea>
                        <span class="clearname"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label>Plan Amount</label>
                        <input type="text" name="plan_amount" class="form-control allow-numeric-with-decimal" value="" placeholder="0.00">
                        <span class="clearname"></span>
                    </div>
                    <div class="form-group mt-3">
                        <label>Status</label>
                        <select class="form-control ccat" name="is_enable">
                            <option value="">Select</option>
                            <?php
                            function getVendorPlanStatus()
                            {
                                $array = array(
                                    1 => 'Enable',
                                    2 => 'Disabled'
                                );
                                return $array;
                            }
                            foreach (getVendorPlanStatus() as $key => $value) {
                            ?>
                                <option value="{{ $key  }}">{{ $value }}</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <button type="button" class="view-all-review btn-edit js-edit btn-add-update-plan"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="schedules" tabindex="-1" aria-labelledby="schedulesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="schedulesModalLabel">My Schedule</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></a>
            </div>
            <div class="modal-body cal-list">
                <div class="list-details">
                    <div class="list-header">
                        <h3>February 17 <br><span>Thursday,</span></h3>
                        <div class="time-filter">
                            <span>Time Availability:</span>
                            <p>From: <span>9:00AM</span> <i class="las la-angle-down"></i></p>
                            <p>To: <span>9:00AM</span> <i class="las la-angle-down"></i></p>
                        </div>
                    </div>
                    <div class="list-search">
                        <div class="input-group">
                            <span class="input-group-append input-group-addon">
                                <span class="input-group-text"><i class="las la-search"></i></span>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Search">
                        </div>
                        <div class="input-group">
                            <span class="input-group-append input-group-addon">
                                <span class="input-group-text"><i class="las la-filter"></i></span>
                            </span>
                            <select class="form-control">
                                <option>All</option>
                            </select>
                        </div>
                    </div>
                    <div class="todo-list">
                        <div class="time-list">
                            <p>9:00AM</p>
                            <p>10:00AM</p>
                            <p>11:00AM</p>
                            <p>12:00PM</p>
                            <p>1:00PM</p>
                            <p>2:00PM</p>
                            <p>3:00PM</p>
                            <p>4:00PM</p>
                        </div>
                        <div class="todo-details">
                            <div class="todos wedding-bg">
                                <h1>
                                    < My Wedding Party!>
                                </h1>
                                <p>9:00AM-12:00PM</p>
                                <p>John Doe</p>
                                <span class="todo-note">
                                    Bangor, Maine(ME), 04401(718) 424-4519<br>
                                    9910 35th Ave<br>
                                    Corona, New York(NY), 11368
                                </span>
                                <b>Call: 000 000 0000 <i class="las la-headphones"></i></b>
                            </div>
                            <div class="todos shower-bg">
                                <h1>
                                    < My Shower Party!>
                                </h1>
                                <p>12:00PM-2:00PM</p>
                                <p>Dana Smith</p>
                                <span class="todo-note">
                                    Claypool Hl<br>
                                    Richlands, Virginia(VA), 24641
                                </span>
                                <b>Call: 000 000 0000 <i class="las la-headphones"></i></b>
                            </div>
                            <div class="todos birthday-bg">
                                <h1>
                                    < Brenda’s Birthday>
                                </h1>
                                <p>12:00PM-2:00PM</p>
                                <p>Dana Smith</p>
                                <span class="todo-note">
                                    Claypool Hl<br>
                                    Richlands, Virginia(VA), 24641
                                </span>
                                <b>Call: 000 000 0000 <i class="las la-headphones"></i></b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-calender">
                    <img src="{{ asset('vendor-assets/images/calendar.png') }}" style="max-width: 100%;">
                    <a href="#" class="view-all-review">Export Schedule</a>
                    <hr>
                    <h3>Your Time Schedule</h3>
                    <p><i class="las la-plus"></i> Add new schedule</p>
                    <div class="working-hours">
                        <div class="working-head">
                            <h4>Work Hours</h4>
                            <a href="#"><i class="las la-check"></i></a>
                        </div>
                        <span>Default</span>
                        <p>9:00AM - 6:00PM</p>
                        <span>(No set Date)</span>
                        <a href="#" class="view-all-review">Edit Schedule</a>
                    </div>
                    <div class="working-hours">
                        <div class="working-head">
                            <h4>Holidays</h4>
                            <a href="#"><i class="las la-check"></i></a>
                        </div>
                        <p>9:00AM - 12:00PM</p>
                        <span>(No set Date)</span>
                        <a href="#" class="view-all-review">Edit Holidays</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.vendor.modal-profile')
@include('layouts.vendor.modal-calendar')
@include('layouts.vendor.modal-settings')
@endsection
@section('pageScript')
<script src="{{ asset('vendor-assets/js/page/auth.js') }}"></script>
<script src="{{ asset('vendor-assets/js/page/plan.js') }}"></script>
<script src="{{ asset('assets/js/validation.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#cover-spin').hide();
    });
    new Morris.Line({
        element: 'pushups',
        data: [{
                day: 'Oct 2021',
                YourRating: 0,
                Competitors: 0
            },
            {
                day: 'Nov 2021',
                YourRating: 0,
                Competitors: 0
            },
            {
                day: 'Dec 2021',
                YourRating: 0,
                Competitors: 0
            },
            {
                day: 'Jan 2022',
                YourRating: 0,
                Competitors: 0
            },
            {
                day: 'Feb 2022',
                YourRating: 0,
                Competitors: 0
            },
            {
                day: 'Mar 2022',
                YourRating: 0,
                Competitors: 0
            }
        ],

        xkey: 'day',
        parseTime: false,

        ykeys: ['YourRating', 'Competitors'],
        labels: ['YourRating', 'Competitors'],
        lineColors: ['#FB8547', '#963CFF']
    });
</script>
@endsection