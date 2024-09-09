<style>
    .disabled {
    pointer-events: none;
    opacity: 0.5; 
}
</style>
<h2><?php echo $info->plan_name; ?></h2>
<h3><?php echo env('CURRENCY_SYMBOL'); ?><?php echo $info->plan_amount; ?></h3>
<p><?php echo nl2br($info->plan_description); ?></p>
<?php 
if (isset($info->plan_image) && !empty($info->plan_image)) {
?>
    <hr>
    <div class="product-img">
        <div class="row">
            <?php
            foreach ($info->plan_image as $value) {
            ?>
                <div class="col-xl-4">
                    <img src="{{ $value->image_url }}" alt="product">
                </div>
            <?php
            }
            ?>
        </div>
    </div>
<?php
}
?>
<hr>

<div class="time-selection mb-3">
    <select class="form-control event-select">
        <option value="" selected disabled>Select an event</option>
        @foreach($events as $event)
            <option value="{{ $event->id }}">{{ $event->event_title }}</option>
        @endforeach
    </select>
</div>

<div class="time-selection d-none">
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
<div id="calendar" class="d-none">
    <div id="calendar_header">
        <i class="icon-chevron-left las la-angle-left"></i>
        <h1></h1><i class="icon-chevron-right las la-angle-right"></i>
    </div>
    <div id="calendar_weekdays"></div>
    <div id="calendar_content"></div>
</div>
<span class="note d-none">Note: Orange is partially booked by other customer, while Red is fully booked.</span>

@if(Auth::check())
<a href="javascript:void(0);" class="book-pkg btn-add-to-cart disabled" data-url="{{ route('add-to-cart') }}" data-type="plan" data-id="{{ my_encrypt($info->id) }}"  data-event-id="">Book now</a>
@else 
<a href="{{route('login')}}" class="book-pkg btn-add-to-cart">Login</a>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.event-select').change(function() {
            const selectedEventId = $(this).val();
            if (selectedEventId !== '') {
                $('.btn-add-to-cart').removeClass('disabled');
                $('.btn-add-to-cart').attr('data-event-id', selectedEventId);
            } else {
                $('.btn-add-to-cart').addClass('disabled');
                $('.btn-add-to-cart').attr('data-event-id', '');
            }
             const eventId = $('.btn-add-to-cart').attr('data-event-id');
            console.log("Event ID:", eventId);
        });
    });
</script>