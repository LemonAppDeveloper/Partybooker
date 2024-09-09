@extends('layouts.vendor.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
@endsection
@section('content')
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
    <div class="col-md-9 overflow">
        <div class="row">
            <div class="col-lg-4">
                @include('vendor::customer-breakdown')
            </div>
            <div class="col-lg-8">
                @include('vendor::revenue-chart')
            </div>
            <div class="col-md-12">
                <div class="order-derails">
                    @include('vendor::order-list')
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 overflow">
        <div class="row">
            <div class="col-md-12">
                <div class="sec-booking-info">

                </div>
                <div class="vendor-details">
                    <div class="vdt-head">
                        <h3>Vendor Details</h3>
                        <a href="{{ url('vendor/gallery') }}">Edit</a>
                    </div>
                    <div class="vdt-gallery">
                        <h4>Gallery</h4>
                        <div class="row">
                            <?php
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
                        </div>
                    </div>
                    <div class="vdt-overview">
                        <h4>Overview</h4>
                        <?php
                        $overview = getVendorOverview(Auth::user()->id);
                        if (!empty($overview)) {
                        ?>
                            <p>{!! nl2br($overview) !!}</p>
                        <?php
                        } else {
                        ?>
                            <p class="text-center text-muted">No Overview yet.</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="vdt-featured-p">
                        <h4>Featured Plan</h4>
                        <?php
                        $settings = array(
                            'id_users' => Auth::user()->id,
                            'limit' => 1,
                            'is_enable' => 1,
                            'filter_by' => 'new_to_old'
                        );
                        $plan_info = getVendorPlans($settings);
                        if (!empty($plan_info)) {
                        ?>
                            <div class="pkg">
                                <h4>{{ $plan_info->plan_name }}</h4>
                                <span>{{ nl2br($plan_info->plan_description) }}</span>
                                <p><i class="las la-credit-card"></i>{{env('CURRENCY_SYMBOL')}}{{ $plan_info->plan_amount }}</p>
                            </div>
                        <?php
                        } else {
                        ?>
                            <p class="text-center text-muted">No plans yet.</p>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="customer-review">
                    <h4>Customer Reviews</h4>
                    <?php
                    $settings = array(
                        'limit' => 1,
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
                        <a href="{{ url('/') }}/vendor/review" class="view-all-review">View All Reviews</a>
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
</div>
@include('layouts.vendor.modal-profile')
@include('layouts.vendor.modal-calendar')
@include('layouts.vendor.modal-settings')
@endsection
@section('pageScript')
<script src="{{ asset('vendor-assets/js/page/auth.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('vendor-assets/js/booking.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor-assets/js/graph.js')}}"></script>
<script>
 
    $(document).ready(function() {
     
    $('#search').on('keypress', function(e) {
        if (e.which == 13) { // 13 is the key code for Enter
            e.preventDefault(); // Prevent the default form submission behavior
            $('.btn-search').trigger('click');
        }
    });
});
</script>
@endsection