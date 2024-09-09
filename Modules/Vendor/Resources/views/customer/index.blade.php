@extends('layouts.vendor.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
@endsection
@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-4">
                @include('vendor::customer-breakdown')
            </div>
            <div class="col-md-8">
                @include('vendor::revenue-chart')
            </div>
            <div class="col-md-12">
                <div class="order-derails">
                    @include('vendor::order-list')
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 editProfileHide overflow">
        <div class="row">
            <div class="col-md-12">
                <div class="sec-booking-info">

                </div>
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
            <div class="col-md-12" style="display: none;">
                <div class="vendor-details pending-approvals-widget">
                    <div class="vdt-head">
                        <h3>Pending Approvals</h3>
                    </div>
                    <div class="vdt-overview">
                        <p class="date">Aug 25-Sept 25 <i class="las la-angle-down"></i></p>
                        <h4>John Doe</h4>
                        <p>My Wedding Party!</p>
                    </div>
                    <div class="vdt-featured-p">
                        <div class="pkg">
                            <span>856 E 23rd St Loveland, Colorado..</span>
                            <span>Aug 23 - Aug 24 | 9:00AM-6:00PM</span>
                            <p><i class="las la-credit-card"></i>$450</p>
                        </div>
                        <a href="javascript:void(0);" class="view-all-review">View Complete Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 editProfileShow d-none">
        <div class="row">
            <div class="col-md-12">
                <div class="widget profile-widget">
                    <div class="widget-heading">
                        <h3>Profile Information</h3>
                    </div>
                    <img src="{{asset('vendor-assets/images/profile.png')}}" alt="profile">
                    <form method="POST" action="{{ route('updateProfile') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}" />
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{$user->name}}">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{$user->email}}">
                        <label>Category</label>
                        <select class="form-control" name="vendor_category">
                            <option value="Florist">Florist</option>
                            <option value="Florist">Florist</option>
                            <option value="Florist">Florist</option>
                        </select>
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                        <label>Repeat Password</label>
                        <input type="password" name="repassword" class="form-control">
                        <hr>
                        <h3>Schedule Management</h3>
                        <p>Time Availability</p>
                        <select class="form-control" name="start_time">
                            <option>9:00 AM</option>
                            <option>9:30 AM</option>
                            <option>10:00 AM</option>
                            <option>10:30 AM</option>
                        </select>
                        <select class="form-control" name="end_time">
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
                        <a href="javascript:void(0);" class="view-all-review">View all schedule</a>
                        <hr>
                        <h3>Terms & Condition</h3>
                        <p>Vendor</p>
                        <span>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</span>
                        <p>Customer</p>
                        <span>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</span>
                        <<button type="submit" class="view-all-review">Save Changes</button>
                    </form>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/validation.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script type="text/javascript" src="{{asset('vendor-assets/js/booking.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor-assets/js/graph.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#editProfileA").on('click', function() {
        $(".editProfileHide").hide();
        $(".editProfileShow").show();
    });
</script>
@endsection