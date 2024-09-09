<div class="widget profile-widget">
    <img src="{{ isset($booking_info['user_info']->path) ? $booking_info['user_info']->path : '' }}" alt="profile" class="mw-100">
    <p class="pname">{{ isset($booking_info['user_info']->name) ? $booking_info['user_info']->name : '' }}</p>
    <div class="party-dtl">
        <h4>Party Details</h4>
        <div class="dropdown" style="display: none;">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="las la-ellipsis-h"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
            </ul>
        </div>
        <p>{{ isset($booking_info['event_info']->name) ? $booking_info['event_info']->name : '' }}</p>
    </div>
    <div class="event-details evedtl">
        <p><img src="<?php echo URL::to('/') ?>/assets/images/location.png"> <span>{{ isset($booking_info['event_info']->event_location) ? $booking_info['event_info']->event_location : '' }}</span></p>
        <div class="date-times">
            <div class="dates">
                <p><img src="<?php echo URL::to('/') ?>/assets/images/calender.png">
                    <span>
                        <?php
                        $from_date = array();
                        if (!empty($booking_info['from_date'])) {
                            $from_date[] = $booking_info['from_date'];
                        }
                        if (!empty($booking_info['from_time'])) {
                            $from_date[] = $booking_info['from_time'];
                        }
                        $to_date = array();
                        if (!empty($booking_info['to_date'])) {
                            $to_date[] = $booking_info['to_date'];
                        }
                        if (!empty($booking_info['to_time'])) {
                            $to_date[] = $booking_info['to_time'];
                        }
                        $time = array();
                        if (!empty($from_date)) {
                            $time[] = format_datetime($from_date);
                        }
                        if (!empty($to_date)) {
                            $time[] = format_datetime($to_date);
                        }
                        echo implode(' to ', $time);
                        ?>
                    </span>
                </p>
            </div>
            <?php /* <div class="times">
                    <p><img src="<?php echo URL::to('/') ?>/assets/images/time.png"> <span>9:00AM - <br>9:00PM</span></p>
                </div> */ ?>
        </div>
        <p><img src="<?php echo URL::to('/') ?>/assets/images/fire.png"> <span>{{ isset($booking_info['event_info']->event_category) ? $booking_info['event_info']->event_category : '' }}</span></p>
    </div>
    <div class="cust-note" style="display: none;">
        <p><img src="<?php echo URL::to('/') ?>/assets/images/notes.png"> Customer Notes</p>
        <p>Please contact me if the date and time is not possible for you.</p>
    </div>
    <hr>
    <div class="stat-change">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo isset($booking_info['booking_info']->booking_status) ? getBookingStatus($booking_info['booking_info']->booking_status) : ''; ?> <i class="las la-angle-down"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                <?php
                if (isset($booking_info['booking_info']->booking_status) && $booking_info['booking_info']->booking_status != 2) {
                ?>
                    <li><a class="dropdown-item btn-booking-status" data-title="confirm" data-url="{{ route('change-booking-status') }}" data-status="2" data-id="{{ isset($booking_info['booking_info']->id) ? my_encrypt($booking_info['booking_info']->id) : '' }}" href="javascript:void(0);">Confirm Booking</a></li>
                <?php
                }
                ?>
                <li><a class="dropdown-item btn-booking-status" data-title="reject" data-url="{{ route('change-booking-status') }}" data-status="3" data-id="{{ isset($booking_info['booking_info']->id) ? my_encrypt($booking_info['booking_info']->id) : '' }}" href="javascript:void(0);">Reject booking</a></li>
            </ul>
        </div>
        <a href="mailto:{{ isset($booking_info['user_info']->email) ? $booking_info['user_info']->email : '' }}" class="contact-cust">Contact Customer</a>
    </div>
</div>