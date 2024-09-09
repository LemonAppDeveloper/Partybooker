<?php
if (isset($vendor_plans) && !empty($vendor_plans)) {
    foreach ($vendor_plans as $value) {
?>
        <div class="plan-box">
            <div class="box-title">
                <h4>{{ $value->plan_name }}</h4>
            </div>
            @if($value->plan_image_url != '')
            <img src="{{ $value->plan_image_url }}">
            @endif
            <h2>${{ $value->plan_amount }}</h2>
            <b>
                {{ $value->plan_title }}
                <?php
                if (isset($value->plan_sub_title) && !empty($value->plan_sub_title)) {
                ?>
                    <span>({{ $value->plan_sub_title }})</span>
                <?php
                }
                ?>
            </b>
            <p>{{ $value->plan_description }}</p>
        </div>
<?php
    }
}
?>