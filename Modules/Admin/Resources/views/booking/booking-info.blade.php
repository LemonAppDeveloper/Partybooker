<div class="widget profile-widget">
    <img src="{{ isset($booking_info['user_info']->path) ? $booking_info['user_info']->path : '' }}" alt="profile"
        class="mw-100 bookingprofile">
    <p class="pname">{{ isset($booking_info['user_info']->name) ? $booking_info['user_info']->name : '' }}</p>
    <div class="party-dtl">
        <h4>Party Details</h4>
        <hr>
        <div class="dropdown" style="display: none;">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="las la-ellipsis-h"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
            </ul>
        </div>

    </div>
    <div class="event-details evedtl">
        <p><img src="<?php echo URL::to('/'); ?>/assets/images/party.png">
            <span>{{ isset($booking_info['event_info']->event_title) ? $booking_info['event_info']->event_title : '' }}</span>
        </p>
        <p><img src="<?php echo URL::to('/'); ?>/assets/images/location.png">
            <span>{{ isset($booking_info['event_info']->event_location) ? $booking_info['event_info']->event_location : '' }}</span>
        </p>
        <div class="date-times">
            <div class="dates">
                <p><img src="<?php echo URL::to('/'); ?>/assets/images/calender.png">
                    <span>
                        <?php
                        $from_date = $booking_info['booking_info']->from_date ?? '';
                        $from_time = $booking_info['booking_info']->from_time ?? '';
                        $to_date = $booking_info['booking_info']->to_date ?? '';
                        $to_time = $booking_info['booking_info']->to_time ?? '';
                        // Check if all variables are not empty before calling format_datetime()
                        if (!empty($from_date) && !empty($to_date)) {
                            echo date('d/m/Y', strtotime($from_date)) . ' to ' . date('d/m/Y', strtotime($to_date));
                        } else {
                            echo 'Date/time not available';
                        }
                        ?>
                    </span>
                </p>
            </div>
        </div>
        <p><img src="<?php echo URL::to('/'); ?>/assets/images/fire.png">
            <?php
            $helper = new \App\Helpers\Helper();
            ?>
            <span><?php echo htmlspecialchars($helper->getSubCategory($booking_info['event_info']->category)); ?></span>
        </p>
        <h4>User Details</h4>
        <hr>
        <p><b>Name :</b><span>{{ isset($booking_info['user_info']->name) ? $booking_info['user_info']->name : '' }}</span></p>
        <p><b>Email : </b><span>{{ isset($booking_info['user_info']->email) ? $booking_info['user_info']->email : '' }}</span></p>

        <?php
        $vedors = get_booking_vendor($booking_info['booking_info']->id);
        foreach ($vedors as $vendor) {
        ?>
            <h4>Vendor Details</h4>
            <hr>
            <p><b>Name :</b><span>{{ isset($vendor[0]->name) ? $vendor[0]->name : '' }}</span></p>
            <p><b>Email : </b><span>{{ isset($vendor[0]->email) ? $vendor[0]->email : '' }}</span></p>
            <p><b>Category : </b><span>{{ isset($vendor[0]->category) ? $vendor[0]->category : '' }}</span></p>
            <h4>Vendor Bank Details</h4>
            <hr>
            <p><b>Amount: </b><span>{{ get_vendor_specific_booking_amount($booking_info['booking_info']->id,$vendor[0]->id) }}</span></p>
            <p><b>Bank: </b><span>{{ isset($vendor[0]->bank_info->bank_name) ? $vendor[0]->bank_info->bank_name : '--' }}</span></p>
            <p><b>Account No: </b><span>{{ isset($vendor[0]->bank_info->account_no) ? $vendor[0]->bank_info->account_no : '--' }}</span></p>
            <p><b>code: </b><span>{{ isset($vendor[0]->bank_info->code) ? $vendor[0]->bank_info->code : '--' }}</span></p>
        <?php
        } /*
        ?>
         <hr>
        <p><b>Name :</b><span>{{ isset($booking_info['booking_info']->details[0]->vendor_info[0]->name) ? $booking_info['booking_info']->details[0]->vendor_info[0]->name : '' }}</span></p>
        <p><b>Email : </b><span>{{ isset($booking_info['booking_info']->details[0]->vendor_info[0]->email) ? $booking_info['booking_info']->details[0]->vendor_info[0]->email : '' }}</span></p>
        <p><b>Category : </b><span>{{ isset($booking_info['booking_info']->details[0]->vendor_info[0]->category) ? $booking_info['booking_info']->details[0]->vendor_info[0]->category : '' }}</span></p>
        <h4>Vendor Bank Details</h4>
         <hr>
         <p><b>Bank :</b><span>{{ isset($booking_info['booking_info']->details[0]->bank_info[0]->bank_name) ? $booking_info['booking_info']->details[0]->bank_info[0]->bank_name : '--' }}</span></p>
        <p><b>Account No :</b><span>{{ isset($booking_info['booking_info']->details[0]->bank_info[0]->account_no) ? $booking_info['booking_info']->details[0]->bank_info[0]->account_no : '--' }}</span></p>
        <p><b>code :</b><span>{{ isset($booking_info['booking_info']->details[0]->bank_info[0]->code) ? $booking_info['booking_info']->details[0]->bank_info[0]->code : '--' }}</span></p>
        */ ?>
    </div>
    <div class="cust-note" style="display: none;">
        <p><img src="<?php echo URL::to('/'); ?>/assets/images/notes.png"> Customer Notes</p>
        <p>Please contact me if the date and time is not possible for you.</p>
    </div>
    <hr>
    <div class="stat-change">
        <?php
        $booking_status = isset($booking_info['booking_info']->booking_status) ? getBookingStatus($booking_info['booking_info']->booking_status) : '';
        if ($booking_info['booking_info']->booking_status == 5 && isset($booking_info['booking_info']->mark_as_paid) && $booking_info['booking_info']->mark_as_paid == 1) {
            $booking_status = "Paid";
        }
        ?>
        <p>Status : <?php echo $booking_status; ?></p>
 
                <div class="dropdown">

                  
                @if (isset($booking_info['booking_info']->booking_status) && $booking_info['booking_info']->booking_status == 1) 
                    <a class="btn btn-booking-status confirmbtn" data-title="confirm"
                        data-url="{{ route('change-booking-status') }}" data-status="2"
                        data-id="{{ isset($booking_info['booking_info']->id) ? my_encrypt($booking_info['booking_info']->id) : '' }}"
                        href="javascript:void(0);">Confirm Booking</a>
                    <a class="btn btn-booking-status rejectbtn" data-title="reject"
                        data-url="{{ route('change-booking-status') }}" data-status="3"
                        data-id="{{ isset($booking_info['booking_info']->id) ? my_encrypt($booking_info['booking_info']->id) : '' }}"
                        href="javascript:void(0);">Reject booking</a>
             
                @elseif(isset($booking_info['booking_info']->booking_status) && $booking_info['booking_info']->booking_status == 2)
                   <a class="btn btn-booking-status rejectbtn" data-title="reject"
                        data-url="{{ route('change-booking-status') }}" data-status="3"
                        data-id="{{ isset($booking_info['booking_info']->id) ? my_encrypt($booking_info['booking_info']->id) : '' }}"
                        href="javascript:void(0);">Reject booking</a>
                    <a class="btn btn-booking-status completebtn" data-title="complete"
                                data-url="{{ route('change-booking-status') }}" data-status="5"
                                data-id="{{ isset($booking_info['booking_info']->id) ? my_encrypt($booking_info['booking_info']->id) : '' }}"
                                href="javascript:void(0);">Complete booking</a>
                @elseif($booking_info['booking_info']->booking_status == 5 && isset($booking_info['booking_info']->mark_as_paid) && $booking_info['booking_info']->mark_as_paid != 1)
                        <a class="btn mark-as-paid rejectbtn" data-title="mark as paid"
                            data-url="{{ route('mark-as-paid') }}" data-status="3"
                            data-id="{{ isset($booking_info['booking_info']->id) ? my_encrypt($booking_info['booking_info']->id) : '' }}"
                            href="javascript:void(0);">Mark as Paid</a>
                @endif
                </div>
     
        <div class="dropdown d-none">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo isset($booking_info['booking_info']->booking_status) ? getBookingStatus($booking_info['booking_info']->booking_status) : ''; ?> <i class="las la-angle-down"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                <?php
                if (isset($booking_info['booking_info']->booking_status) && $booking_info['booking_info']->booking_status != 2) {
                ?>
                    <li><a class="dropdown-item btn-booking-status" data-title="confirm"
                            data-url="{{ route('change-booking-status') }}" data-status="2"
                            data-id="{{ isset($booking_info['booking_info']->id) ? my_encrypt($booking_info['booking_info']->id) : '' }}"
                            href="javascript:void(0);">Confirm Booking</a></li>
                <?php
                }
                ?>
                <li><a class="dropdown-item btn-booking-status" data-title="reject"
                        data-url="{{ route('change-booking-status') }}" data-status="3"
                        data-id="{{ isset($booking_info['booking_info']->id) ? my_encrypt($booking_info['booking_info']->id) : '' }}"
                        href="javascript:void(0);">Reject booking</a></li>
            </ul>
        </div>

        <a href="mailto:{{ isset($booking_info['user_info']->email) ? $booking_info['user_info']->email : '' }}"
            class="contact-cust d-none">Contact Customer</a>
 
    </div>
</div>