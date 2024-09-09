<div class="order-head">
    <h3>Ready to pay</h3>
    <select class="form-control d-none">
        <option>Download</option>
    </select>
    <a href="{{ route('booking-export') }}" class="btn btn-secondary text-white">Download</a>
</div>
<form>
    <div class="order-search">
        <div class="input-group">
            <span class="input-group-append input-group-addon btn-search">
                <span class="input-group-text"><i class="las la-search"></i></span>
            </span>
            <input type="text" name="search" id="search" value="{{ isset($filter_data['search']) ? $filter_data['search'] : '' }}" class="form-control" placeholder="Search">
        </div>

        <div class="input-group">
            <span class="input-group-append input-group-addon">
                <span class="input-group-text"><i class="las la-filter"></i></span>
            </span>
            <select class="form-control" name="booking_status">
                <option value="">Status</option>
                <?php
                $selected = isset($filter_data['booking_status']) ? $filter_data['booking_status'] : '';
                foreach (getBookingStatus() as $key => $value) {
                    $selected_text = $key == $selected ? 'selected="selected"' : '';
                ?>
                    <option value="<?php echo $key; ?>" {{$selected_text}}><?php echo $value; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="input-group">
            <span class="input-group-append input-group-addon">
                <span class="input-group-text"><img src="{{asset('vendor-assets/images/icon.png')}}" alt="icon"></span>
            </span>
            <select class="form-control" name="filter_option">
                <option value="">Select</option>
                <option value="with_product" {{ isset($filter_data['filter_option']) && $filter_data['filter_option'] == 'with_product' ? 'selected="selected"' : '' }}>With Product</option>
                <option value="only_package" {{ isset($filter_data['filter_option']) && $filter_data['filter_option'] == 'only_package' ? 'selected="selected"' : '' }}>Only Package</option>
                <option value="only_product" {{ isset($filter_data['filter_option']) && $filter_data['filter_option'] == 'only_product' ? 'selected="selected"' : '' }}>Only Product</option>
            </select>
        </div>
    </div>
</form>
<table id="example1" class="table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Vendor Name</th>
            <th>Customer Name</th>
            <th>Party Name (Title)</th>
            <th>Amount</th>
            <th>Status</th>
            <th class="text-left">Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($confirm_info['row_count']) && $confirm_info['row_count'] > 0) {
            foreach ($confirm_info['data'] as $value) {
                $booking_info = getBookingInfo($value->id);
        ?>
                <tr data-id="{{ my_encrypt($value->id) }}" data-url="{{ route('booking-management-info',['ready_to_pay' => 1]) }}">
                    <td><?php echo $value->booking_number; ?></td>
                    <td> 
                        <?php
                            // $vedors = get_booking_vendor($value->id);
                            // $temp = array();
                            // foreach ($vedors as $vendor) {
                            //     $temp[] = isset($vendor[0]->name) ? $vendor[0]->name : '';
                            // }
                            // echo implode(',<br/>',array_filter($temp));
                            if(isset($booking_info['booking_info']->details[0]->vendor_info[0]->name)){
                                echo $booking_info['booking_info']->details[0]->vendor_info[0]->name; 
                            } 
                        ?>
                    </td>
                    <td><?php echo $value->name; ?></td>
                    <td><?php echo $value->event_title; ?></td>
                    <td><?php echo format_number($value->total_amount, true); ?></td>
                    <td><?php echo getBookingStatus($value->booking_status); ?></td> 
                    <td class="text-left"><?php echo format_datetime($value->from_date); ?></td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>