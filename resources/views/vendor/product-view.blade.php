<style>
    .disabled {
    pointer-events: none;
    opacity: 0.5; 
}
</style>
<h2><?php echo $info->title; ?></h2>
<h3><?php echo env('CURRENCY_SYMBOL'); ?><?php echo $info->price; ?></h3>
<span class="d-none">4 months to pay with 0% Interest via credit card
    <span>(Only available in Australia region)</span>
</span>
<p><?php echo nl2br($info->description); ?></p>
<?php
if (isset($info->product_image) && !empty($info->product_image)) {
?>
    <hr>
    <div class="product-img">
        <div class="row">
            <?php
            foreach ($info->product_image as $value) {
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

<div class="time-selection mb-3">
    <select class="form-control event-select">
        <option value="" selected disabled>Select an event</option>
        @foreach($events as $event)
            <option value="{{ $event->id }}">{{ $event->event_title }}</option>
        @endforeach
    </select>
</div>

<div class="addcart">
    <div class="number">
        <span class="minus btn-decrease-quantity" role="button">-</span>
        <input type="text" name="quantity" class="product-quantity" value="1" readonly />
        <span class="plus btn-increase-quantity" role="button">+</span>
    </div>
    @if(Auth::check())
    <a href="javascript:void(0);" class="book-pkg btn-add-to-cart disabled" data-url="<?php echo route('add-to-cart'); ?>" data-id="<?php echo my_encrypt($info->id); ?>" data-event-id="" data-type="product">Book now</a>
    @else
    <a href="{{route('login')}}" class="book-pkg btn-add-to-cart">Login</a>
    @endif
</div>


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