<tr>
    <td><input type="checkbox" class="d-none" name="id_cart[]" value="<?php echo my_encrypt($value->id); ?>"></td>
    <td>
        <div class="partynm">
            <?php
            $amount = 0;
            if (isset($value->plan_info) && !empty($value->plan_info)) {
                $amount =  $value->plan_info[0]->plan_amount;
            ?>
                <img src="<?php echo $value->plan_info[0]->image_url; ?>" alt="party">
                <span><?php echo $value->plan_info[0]->plan_name; ?> <a href="javascript:void(0)" class="moreptydtl"><i class="las la-angle-down"></i></a>
                    <span class="more-det">
                        <?php echo $value->plan_info[0]->plan_description; ?>
                    </span>
                </span>
                <?php
            } else if (isset($value->product_info) && !empty($value->product_info)) {
                $amount =  $value->product_info[0]->price * $value->quantity;
                if (isset($value->product_info[0]->image_url)) {
                ?>
                    <img src="<?php echo $value->product_info[0]->image_url; ?>" alt="party">
            <?php
                }
                echo isset($value->product_info[0]->title) ? $value->product_info[0]->title : '';
            }
            ?>
        </div>
    </td>
    <td><?php echo isset($value->vendor_info[0]->name) ? $value->vendor_info[0]->name : '';  ?></td>
    <td><?php echo !empty($value->id_vendor_plans) ? 'Package' : 'Product'; ?></td>
    <td data-amount="<?php echo $amount; ?>"><?php echo env('CURRENCY_SYMBOL'); ?><?php echo $amount; ?></td>
</tr>