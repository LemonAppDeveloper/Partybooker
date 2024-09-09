<div class="widget mygallery-widget">
    <div class="mygallery-head mb-4">
        <h3>{{ $vendor_detail->name }}</h3>
        <a href="#" class="d-none" data-bs-toggle="modal" data-bs-target="#bookingopt"><i class="las la-times"></i></a>
    </div>
    <div class="mygallary">
        <div class="row">
            <?php
            $settings = array(
                'id' => $vendor_detail->id,
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
        </div>
        <a href="{{ url('/vendor/gallery/') }}/{{my_encrypt($vendor_detail->id)}}" class="view-all-review">View gallery</a>
    </div>
    <hr class="vendor-hr">
    <div class="review-widg">
        <p>
            <?php
            if (!empty($vendor_detail->address)) {
            ?>
                <span><i class="las la-map-marker"></i> <?php echo $vendor_detail->address; ?></span>
            <?php
            }
            ?>
            <span><i class="las la-heart"></i></span>
        </p>
        <?php
        if (!empty($vendor_detail->timing)) {
        ?>
            <p><span><i class="las la-stopwatch"></i> <?php echo $vendor_detail->timing; ?></span></p>
        <?php
        }
        ?>
        <div class="star-rating">
            <?php
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $vendor_detail->avg_rating) {
                    echo '<i class="las la-star"></i>';
                } else {
                    echo '<i class="las la-star empty"></i>';
                }
            }
            ?>
        </div>
        <?php
        $getVendorOverview = getVendorOverview($vendor_detail->id);
        if (!empty($getVendorOverview)) {
        ?>
            <div class="overviews">
                <p>Overview</p>
                <span><?php echo nl2br($getVendorOverview); ?></span>
            </div>
        <?php
        }
        $settings = array(
            'limit' => 10,
            'filter_by' => 'new_to_old',
            'id_vendor' => $vendor_detail->id
        );
        $getVendorReviews = getVendorReviews($settings);
        if (!empty($getVendorReviews)) {
        ?>
            <div class="review-head">
                <p>Reviews</p>
                <a href="javascript:void(0);">View all</a>
            </div>
            <div class="reviews-slid">
                <div class="review-carousel">
                    <?php
                    foreach ($getVendorReviews as $value) {
                    ?>

                        <div class="review-box">
                            <p><?php echo nl2br($value->review); ?></p>
                            <div class="rev-det">
                                <span>{{ $value->full_name }}</span>
                                <span>Rating: {{ $value->rating }}/5</span>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <hr class="vendor-hr">
    <div class="vendor-calender">
        <h4>Vendor Calendar</h4>
        <p>Please select the Time and Date for your Party.</p>
        <div class="time-selection">
            <select class="form-control">
                <option>From: 9:00AM</option>
                <option>From: 10:00AM</option>
                <option>From: 11:00AM</option>
            </select>
            <select class="form-control">
                <option>To: 9:00PM</option>
                <option>To: 10:00PM</option>
                <option>To: 11:00PM</option>
            </select>
        </div>
        <div id="calendar">
            <div id="calendar_header">
                <i class="icon-chevron-left las la-angle-left"></i>
                <h1></h1><i class="icon-chevron-right las la-angle-right"></i>
            </div>
            <div id="calendar_weekdays"></div>
            <div id="calendar_content"></div>
        </div>
        <span class="note d-none">Note: Orange is partially booked by other customer, while Red is fully booked.</span>
    </div>
    <?php
    $settings = array(
        'id_users' => $vendor_detail->id,
        'is_enable' => 1
    );
    $getVendorPlans = getVendorPlans($settings);
    if (!empty($getVendorPlans)) {
    ?>
        <hr class="vendor-hr">
        <div class="pricing-plan">
            <h4>Select a plan that suits you</h4>
            <?php
            foreach ($getVendorPlans as $value) {
            ?>
                <div class="plan-box">
                    <h4><?php echo $value->plan_name; ?></h4>
                    <?php
                    if (!empty($value->plan_image_url)) {
                    ?>
                        <img src="<?php echo $value->plan_image_url; ?>">
                    <?php
                    }
                    ?>
                    <h1><?php echo env('CURRENCY_SYMBOL'); ?><?php echo $value->plan_amount; ?></h1>
                    <p>
                        <?php
                        echo $value->plan_title;
                        if (!empty($value->plan_sub_title)) {
                        ?>
                            <br><span>(<?php echo $value->plan_sub_title; ?>)</span>
                        <?php
                        }
                        ?>
                    </p>
                    <b><?php echo nl2br($value->plan_description); ?></b>
                    <a href="javascript:void(0);">View Breakdown</a>
                </div>
            <?php
            }
            ?>
        </div>
    <?php
    }
    ?>
</div>