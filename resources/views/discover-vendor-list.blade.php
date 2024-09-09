<?php
if (isset($vendor_info) && !empty($vendor_info)) {
    foreach ($vendor_info as $value) {
?>
        {{-- <div class="cat-list-box go-to-detail" role="button" data-url="{{ url('/') }}/vendor/gallery/{{ my_encrypt($value->id) }}"> --}}
            <div class="cat-list-box go-to-detail" role="button" data-url="{{ url('/') }}/vendor/gallery/{{ my_encrypt($value->id) }}">
            <div class="cat-heads" style="background-image: url(<?php echo $value->profile_image_url; ?>);">
                <a href="javascript:void(0);" class="d-none"><i class="las la-heart update-favorite <?php echo $value->is_favorite == true ? 'active' : ''; ?>" data-href="{{ route('updateFavorite') }}" data-id="{{ $value->id }}"></i></a>
            </div>
            <div class="cat-body">
                <h4><?php echo $value->name;   ?></h4>
                <p><img src="{{ asset('assets/images/location.svg') }}"> <?php echo !empty($value->category) ? $value->category : '-'; ?></p>
                <p><img src="{{ asset('assets/images/watch.svg') }}"> <?php echo !empty($value->timing) ? $value->timing : '-'; ?></p>
                <div class="star-rating d-none">
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
                <div class="desc d-none">
                    <p><?php echo nl2br($value->description); ?></p>
                </div>
                <a href="javascript:void(0);" class=" d-none view-all-review btn-view-vendor-detail" data-url="{{ route('vendor.detail') }}" data-id="{{ $value->id }}"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> View details</a>
            </div>
        </div>
<?php
    } 
} else {
    ?>
    
    <div class="row">
        <div class="col text-center">
            <h3>Vendor not found for selected date and location.</h3>
        </div>
    </div>
    <?php 
}

?>