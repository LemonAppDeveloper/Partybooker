<div class="product-list">
    <?php
    if (isset($vendor_product) && !empty($vendor_product)) {
        foreach ($vendor_product as $product) {
    ?>
            <div class="product-box">
                <h4><?php echo $product->title; ?></h4>
                <div class="package-img">
                    <img src="<?php echo $product->image_url; ?>" alt="<?php echo $product->title; ?>">
                </div>
                <div class="price-rating">
                    <h3>$<?php echo $product->price; ?></h3>
                    <span class="d-none"><i class="las la-star"></i> 4.5</span>
                </div>
                <p><?php echo $product->description; ?></p>
                <div class="package-det">
                    <a href="javascript:void(0);" class="show-proddet edit-product" data-action="<?php echo route('getProductDetail'); ?>" data-id="<?php echo my_encrypt($product->id); ?>">View Breakdown</a>
                </div>
            </div>
    <?php
        }
    }
    ?>
    <div class="product-box add-new text-center">
        <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#singleproduct">
            <span><i class="las la-plus"></i></span>
            <p>Add new</p>
        </a>
    </div>
</div>