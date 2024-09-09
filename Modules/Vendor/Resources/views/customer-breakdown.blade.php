<div class="widget-breakdown">
    <div class="widget-head">
        <h3>Customer Breakdown</h3>
        <select name="customer_breakdown_time" data-url="{{ route('get-customer-breakdown') }}">
            <?php
            foreach (getDateFilterOption() as $date => $text) {
                echo '<option value="' . $date . '">' . $text . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="widget-body">
        <div class="widget-count">
            <div class="counts">
                <p>Total</p>
                <h3 class="text-muted total_total">--</h3>
            </div>
            <div class="counts">
                <p>Cancelled</p>
                <h3 class="text-muted total_cancelled">--</h3>
            </div>
            <div class="counts">
                <p>Booked</p>
                <h3 class="text-muted total_booked">--</h3>
            </div>
            <div class="counts">
                <p>Ongoing</p>
                <h3 class="text-muted total_ongoing">--</h3>
            </div>
        </div>
    </div>
</div>