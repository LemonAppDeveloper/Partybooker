<div class="product-list">
    <?php
    if (isset($vendor_plan) && !empty($vendor_plan)) {
        foreach ($vendor_plan as $product) {
    ?>
            <div class="product-box" <?php /*inactives*/ ?>>
                <h4><?php echo $product->plan_name; ?></h4>
                <div class="package-img">
                    <img src="<?php echo $product->plan_image_url; ?>" alt="<?php echo $product->plan_name; ?>">
                </div>
                <div class="price-rating">
                    <h3>$<?php echo $product->plan_amount; ?></h3>
                    <span class="d-none"><i class="las la-star"></i> 4.5</span>
                </div>
                <p><?php echo $product->plan_description; ?></p>
                <div class="package-det">
                    <a href="javascript:void(0);" class="show-proddet edit-plan" data-action="<?php echo route('getPlanDetail'); ?>" data-id="<?php echo my_encrypt($product->id); ?>">View Breakdown</a>
                </div>
            </div>
    <?php
        }
    }
    ?>
    <div class="product-box add-new text-center">
        <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#packageadd">
            <span><i class="las la-plus"></i></span>
            <p>Add new</p>
        </a>
    </div>
</div>