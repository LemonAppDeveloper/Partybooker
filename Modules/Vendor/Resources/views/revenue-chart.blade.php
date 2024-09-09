<div class="average-revenue sec-revenue-graph" data-url="<?php echo route('get-earning-graph'); ?>">
    <div class="average-head">
        <h3><small class="total_earning">$0</small> <span>Total Earnings</span></h3>
        <div class="float-end shorting">
            <select name="id_plan">
                <option value="">All Plans</option>
                <?php
                $settings = array();
                $settings['id_users'] = Auth::id();
                $vendor_plan = getVendorPlans($settings);
                if (!empty($vendor_plan)) {
                    foreach ($vendor_plan as $value) {
                        echo '<option value="' . $value->id . '">' . $value->plan_name . '</option>';
                    }
                }
                ?>
            </select>
            <select name="timeline">
                <option value="lastyear">Last Year</option>
                <option value="last3">Last 3 Month</option>
                <option value="last6">Last 6 Month</option>
            </select>
        </div>
    </div>
    <div class='graph-wrapper'>
        <div class='graph' id='pushups'></div>
    </div>
</div>