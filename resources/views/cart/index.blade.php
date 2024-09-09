@extends('layouts.app')
@section('pageStyles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
         <style>
         .pac-container {
            z-index: 10000 !important;
        }
    </style>
@endsection
@section('content')
    <div class="container mt-4 mb-4">
        <div class="row">
            <div class="col-md-12">
                <div class="organize-party">
                    <div class="heading">
                        <h3>Congrats on an amazing party!</h3>
                        <p>Your hard work and creativity made it a memarable and fun event for all!</p>
                    </div>
                    <a href="javascript:void(0);" class="d-none" data-bs-toggle="modal" data-bs-target="#organizeparty">Organize Party</a>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-4 col-lg-3">
                <div class="sle-party">
                    <a href="javascript:void(0);" class="mypt">
                        <div>
                            <img src="<?php echo URL::to('/'); ?>/assets/images/party-white.png" alt="party"> My Parties
                        </div>
                        <i class="las la-angle-down"></i>
                    </a>
                    <ul class="event-selection">
                        <?php
                    if (isset($party_info) && !empty($party_info)) {
                        foreach ($party_info as $value) {
                    ?>
                        <li><a href="<?php echo URL::to('/') . '/cart/' . my_encrypt($value->id); ?>" data-id="<?php echo my_encrypt($value->id); ?>"
                                class="<?php echo isset($default_event->id) && $default_event->id == $value->id ? 'active' : ''; ?>"><?php echo $value->event_title; ?></a></li>
                        <?php
                        }
                    } else {
                        ?>
                        <li><a href="javascript:void(0);">Add New Party</a></li>
                        <?php
                    }
                    ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-8 col-lg-9">
                <div class="clmywedparty">
                    <h3><?php echo isset($default_event->event_title) ? $default_event->event_title : 'My Wedding Party!'; ?></h3>
                </div>
                <div class="wedtable">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="shortlist-tab" data-bs-toggle="tab"
                                data-bs-target="#shortlist" type="button" role="tab" aria-controls="shortlist"
                                aria-selected="true">Shortlist</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending"
                                type="button" role="tab" aria-controls="pending" aria-selected="false">Pending</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirmed"
                                type="button" role="tab" aria-controls="confirmed"
                                aria-selected="false">Confirmed</button>
                        </li>
                        <div class="party-dets">
                            <div class="menus">
                                <a href="javascript:void(0)" class="pdt"><i class="las la-info-circle"></i> Party Details
                                </a>
                            </div>
                            <div class="party-box popparty"> 
                                <h3>Party Details</h3>
                                <form action="{{ route('createEvent') }}" name="create-event" method="POST"
                                    onsubmit="return false;">
                                    @csrf
                                    <div class="input-group">
                                        <span class="input-group-append input-group-addon">
                                            <span class="input-group-text"><i class="las la-map-marker"></i></span>
                                        </span>

                                        <input type="text" name="title" class="form-control" placeholder="Title"
                                            value="<?php echo isset($default_event->event_title) ? $default_event->event_title : ''; ?>">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-append input-group-addon">
                                            <span class="input-group-text"><i class="las la-map-marker"></i></span>
                                        </span>
                                        <input type="hidden" name="id" value="{{ $default_event->id }}" />
                                        <input type="text" name="location" class="form-control" placeholder="Location" id="txtPlaces2"
                                            value="<?php echo isset($default_event->event_location) ? $default_event->event_location : ''; ?>">
                                            
                                                 <input type="hidden" id="lat2" name="lat" />
                                                <input type="hidden" id="lng2" name="lng" />
                                    </div>
                                    <div class="input-group date" id="datepicker">
                                        <span class="input-group-append input-group-addon">
                                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                                        </span>
                                        <input class="form-control" name="event_date" value="<?php echo isset($default_event->event_date) ? date('m/d/Y', strtotime($default_event->event_date)) : ''; ?>"
                                            placeholder="MM/DD/YYYY" readonly>
                                    </div>
                                    <div class="input-group date" id="datepicker_to">
                                        <span class="input-group-append input-group-addon">
                                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                                        </span>
                                        <input class="form-control" name="event_to_date" value="<?php echo isset($default_event->event_to_date) ? date('m/d/Y', strtotime($default_event->event_to_date)) : ''; ?>"
                                            placeholder="MM/DD/YYYY" readonly>
                                    </div>
                                    {{-- <div class="input-group category">
                                        <span class="input-group-append input-group-addon">
                                            <span class="input-group-text"><i class="las la-fire-alt"></i></span>
                                        </span>
                                        <input type="text" name="category" class="form-control "
                                            placeholder="Category" value="<?php echo isset($default_event->event_category) ? $default_event->event_category : ''; ?>">
                                    </div> --}}
                                    @php
                                        use App\Helpers\Helper;
                                        $helper = new Helper();
                                        $subCategory = $helper->getSubCategory();
                                    @endphp
                                    <div class="input-group category">
                                        <span class="input-group-append input-group-addon">
                                            <span class="input-group-text"><i class="las la-fire-alt"></i></span>
                                        </span>
                                        <select class="form-control" name="category">
                                            <option value="">Select Category</option>
                                            @foreach ($subCategory as $category)
                                                <option value="{{ $category['id'] }}"  {{ isset($default_event->category) && $default_event->category == $category['id'] ? 'selected' : '' }}>
                                                    {{ $category['category_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-gray">Save Changes</button>
                                    <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#deleteparty"
                                        class="btn btn-danger">Delete Party</a>
                                </form>
                            </div>
                        </div>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="shortlist" role="tabpanel"
                            aria-labelledby="shortlist-tab">
                            <div class="filters">
                                <h3>Plans/Products</h3>
                                <div class="srch d-none">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="las la-search"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search">
                                    </div>
                                    <div class="slft">
                                        <i class="las la-filter"></i>
                                        <select class="select-control form-control">
                                            <option>Filter</option>
                                            <option>Filter 1</option>
                                            <option>Filter 2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <table id="example" class="table shortlisted" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall" id="selectAllSortlist"></th>
                                        <th>Product</th>
                                        <th>Vendor Name</th>
                                        <th>Type</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($cart_info['shortlist']) && !empty($cart_info['shortlist'])) {
                                    foreach ($cart_info['shortlist'] as $value) {
                                ?>
                                    @include('cart.listing')
                                    <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                            <div class="footer-option">
                                <div class="lefts d-none">
                                    <div class="page-row">
                                        <p>Rows per page</p>
                                        <select class="select-control form-control">
                                            <option>5</option>
                                            <option>10</option>
                                            <option>20</option>
                                            <option>50</option>
                                            <option>100</option>
                                        </select>
                                    </div>
                                    <div class="num-rec">
                                        <p>1-10 of 100</p>
                                        <a href=""><i class="las la-angle-left"></i></a>
                                        <a href=""><i class="las la-angle-right"></i></a>
                                    </div>
                                </div>
                                <?php
                            if (isset($cart_info['shortlist']) && !empty($cart_info['shortlist'])) {
                            ?>
                                <div class="right">
                                    <div class="buttons">
                                        <button class="btns btn-remove btn-remove-cart"
                                            data-url="<?php echo route('remove-cart'); ?>">Remove</button>
                                        <button class="btns btn-checkout" <?php /* data-bs-toggle="modal" data-bs-target="#checkout"*/ ?>>Checkout</button>
                                        <button class="btns btn-success btn-add-to-shortlist d-none"
                                            data-url="<?php echo route('add-to-shortlist'); ?>">Checkout</button>
                                        <button class="btns btn-success btn-add-to-confirm d-none"
                                            data-url="<?php echo route('add-to-confirm'); ?>">Confirm</button>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            <div class="right">
                                    <div class="buttons">
                                        <button class="btns btn-add-more" data-url="{{ url('/') }}" data-ignore="false">Add More</button>
                                    </div>
                            </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                            <div class="filters">
                                <h3>Plan/Products</h3>
                                <div class="srch d-none">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="las la-search"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search">
                                    </div>
                                    <div class="slft">
                                        <i class="las la-filter"></i>
                                        <select class="select-control form-control">
                                            <option>Filter</option>
                                            <option>Filter 1</option>
                                            <option>Filter 2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <table id="example1" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall" id="selectAllPending"></th>
                                        <th>Product</th>
                                        <th>Vendor Name</th>
                                        <th>Type</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                if (isset($cart_info['pending']) && !empty($cart_info['pending'])) {
                                    foreach ($cart_info['pending'] as $value) {
                                ?>
                                    @include('cart.listing')
                                    <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                            <div class="footer-option">
                                <div class="lefts d-none">
                                    <div class="page-row">
                                        <p>Rows per page</p>
                                        <select class="select-control form-control">
                                            <option>5</option>
                                            <option>10</option>
                                            <option>20</option>
                                            <option>50</option>
                                            <option>100</option>
                                        </select>
                                    </div>
                                    <div class="num-rec">
                                        <p>1-10 of 100</p>
                                        <a href=""><i class="las la-angle-left"></i></a>
                                        <a href=""><i class="las la-angle-right"></i></a>
                                    </div>
                                </div>
                                <?php
                            if (isset($cart_info['pending']) && !empty($cart_info['pending'])) {
                            ?>
                                <div class="right">
                                    <div class="buttons">
                                        <button class="btns btn-remove btn-remove-pending"
                                            data-url="<?php echo route('remove-pending'); ?>">Remove</button>
                                        <button class="btns btn-success d-none btn-add-to-shortlist"
                                            data-url="<?php echo route('add-to-shortlist'); ?>">Shortlist</button>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                             <div class="right">
                                    <div class="buttons">
                                        <button class="btns btn-add-more" data-url="{{ url('/') }}" data-ignore="false">Add More</button>
                                    </div>
                            </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="confirmed" role="tabpanel" aria-labelledby="confirmed-tab">
                            <div class="filters">
                                <h3>Plan/Products</h3>
                                <div class="srch d-none">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="las la-search"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search">
                                    </div>
                                    <div class="slft">
                                        <i class="las la-filter"></i>
                                        <select class="select-control form-control">
                                            <option>Filter</option>
                                            <option>Filter 1</option>
                                            <option>Filter 2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <table id="example2" class="table confirmed-booking" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall" id="selectAllConfirmed"></th>
                                        <th>Product</th>
                                        <th>Vendor Name</th>
                                        <th>Type</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                if (isset($cart_info['confirmed']) && !empty($cart_info['confirmed'])) {
                                    foreach ($cart_info['confirmed'] as $value) {
                                ?>
                                    @include('cart.listing')
                                    <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                            <div class="footer-option">
                                <div class="lefts d-none">
                                    <div class="page-row">
                                        <p>Rows per page</p>
                                        <select class="select-control form-control">
                                            <option>5</option>
                                            <option>10</option>
                                            <option>20</option>
                                            <option>50</option>
                                            <option>100</option>
                                        </select>
                                    </div>
                                    <div class="num-rec">
                                        <p>1-10 of 100</p>
                                        <a href=""><i class="las la-angle-left"></i></a>
                                        <a href=""><i class="las la-angle-right"></i></a>
                                    </div>
                                </div>
                                <?php
                            if (isset($cart_info['confirmed']) && !empty($cart_info['confirmed'])) {
                            ?>
                                <div class="right">
                                    <div class="buttons">
                                        <button class="btns btn-remove btn-remove-cart d-none"
                                            data-url="<?php echo route('remove-cart'); ?>">Remove</button>
                                        <button class="btns btn-checkout d-none" data-bs-toggle="modal"
                                            data-bs-target="#checkout">Checkout</button>
                                        <button class="btns btn-remove btn-cancel-booking"
                                            data-url="<?php echo route('cancel-booking'); ?>">Cancel Booking</button>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                             <div class="right">
                                    <div class="buttons">
                                        <button class="btns btn-add-more" data-url="{{ url('/') }}" data-ignore="false">Add More</button>
                                    </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dateselection" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="dateselectionLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dateselectionLabel">Party Date Range</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="time-selection modl">
                        <div class="fromdate">
                            <p>From: <span>Feb 23</span></p>
                        </div>
                        <div class="todate">
                            <p>To: <span>Feb 23</span></p>
                        </div>
                    </div>
                    <div id="calendar">
                        <div id="calendar_header">
                            <i class="icon-chevron-left las la-angle-left"></i>
                            <h1></h1><i class="icon-chevron-right las la-angle-right"></i>
                        </div>
                        <div id="calendar_weekdays"></div>
                        <div id="calendar_content"></div>
                    </div>

                    <a href="#" class="view-all-review checkout-btn" data-bs-dismiss="modal"
                        aria-label="Close">Choose
                        this date</a>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close"
                        class="btn btn-outline-dark btn-block">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="checkout" tabindex="-1" aria-labelledby="checkoutLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-7 col-md-6">
                            <form action="party-confirmed.html">
                                <div class="checkout">
                                    <h3>Checkout</h3>
                                    <div class="party-details">
                                        <p>Party Details</p>
                                        <a href="javascript:void(0);" class="d-none">+ Add new card</a>
                                    </div>
                                    <div class="select-card">
                                        <span>Credit/Debit Card</span>
                                        <i class="las la-angle-down d-none"></i>
                                    </div>
                                    <div id="card-container"></div>
                                    <div class="card-name d-none">
                                        <div class="cards"><img src="<?php echo URL::to('/'); ?>/assets/images/visa.png"
                                                alt="visa"></div>
                                        <div class="cards"><img src="<?php echo URL::to('/'); ?>/assets/images/DinersClub.png"
                                                alt="DinersClub"></div>
                                        <div class="cards"><img src="<?php echo URL::to('/'); ?>/assets/images/AMEX.png"
                                                alt="AMEX"></div>
                                        <div class="cards"><img src="<?php echo URL::to('/'); ?>/assets/images/Mastercard.png"
                                                alt="Mastercard"></div>
                                        <div class="cards"><img src="<?php echo URL::to('/'); ?>/assets/images/JCB.png"
                                                alt="JCB"></div>
                                    </div>
                                    <div class="d-none">
                                        <span>Card Holder Name</span>
                                        <input type="text" name="cardholder_name" placeholder="cardholder name"
                                            class="form-control">
                                        <span>Card Number</span>
                                        <input type="text" name="card_number" placeholder="card number"
                                            maxlength="19" class="form-control cc-number-input">
                                        <span>Expiration Date</span>
                                        <input type="text" name="expiry_date" placeholder="expiry date"
                                            maxlength="5" class="form-control cc-expiry-input">
                                        <span>CVC</span>
                                        <input type="text" name="cvv" placeholder="CVC" maxlength="3"
                                            class="form-control cc-cvc-input">
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="terms">
                                        <label class="form-check-label text-start" for="terms-stop">Terms &
                                            Conditions</label>
                                        I have read and agree to the <b><a target="_blank" class="text-secondary"
                                                href="{{ url('terms-of-use') }}">Terms of Use</a></b>, <b><a
                                                target="_blank" class="text-secondary"
                                                href="{{ url('privacy-policy') }}">Privacy Policy</a></b>, and
                                        <b><a target="_blank" class="text-secondary"
                                                href="{{ url('internet-security') }}">Internet Security Information
                                                Policy</a></b>.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                            aria-label="Close">Cancel</button>
                                        <button type="button" class="btn book-pkg btn-pay-now" id="btn-pay-now"
                                            data-url="<?php echo route('confirm-booking'); ?>">Pay Now</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="party-summary">
                                <div class="modal-header">
                                    <h3>Party Summary</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <span>Please double check before proceeding.</span>
                                <hr>
                                <h4>Party Details</h4>
                                <div class="details-list">
                                    <label>Party Name</label>
                                    <p><?php echo isset($default_event->event_title) ? $default_event->event_title : ''; ?></p>
                                </div>
                                <div class="details-list">
                                    <label>Party Address</label>
                                    <p><?php echo isset($default_event->event_location) ? $default_event->event_location : ''; ?></p>
                                </div>
                                <div class="details-list">
                                    <label>Party Date</label>
                                    <p><?php echo isset($default_event->event_date) ? $default_event->event_date : ''; ?></p>
                                </div>
                                <div class="details-list">
                                    <label>Party To Date</label>
                                    <p><?php echo isset($default_event->event_date) ? $default_event->event_to_date : ''; ?></p>
                                </div>
                                <div class="details-list">
                                    <label>Category</label>
                                    <p><?php echo isset($default_event->event_category) ? $default_event->event_category : ''; ?></p>
                                </div>
                                <h4>Product/Service List</h4>
                                <?php
                            $total_amount = 0;
                            
                            if (isset($cart_info['shortlist']) && !empty($cart_info['shortlist'])) {



                                foreach ($cart_info['shortlist'] as $value) {
                                        ?>
                                <div class="show-hide-cart-product-plan" data-id-cart="<?php echo my_encrypt($value->id); ?>">
                                    <div class="details-list">
                                        <label>Vendor</label>
                                        <p><?php echo isset($value->vendor_info[0]->name) ? $value->vendor_info[0]->name : ''; ?></p>
                                    </div>
                                    <?php
                                            if (isset($value->plan_info) && !empty($value->plan_info)) {
                                                $total_amount +=  $value->plan_info[0]->plan_amount;
                                            ?>
                                    <div class="details-list">
                                        <label>Plan</label>
                                        <p><?php echo isset($value->plan_info[0]->plan_name) ? $value->plan_info[0]->plan_name : ''; ?> (<?php echo env('CURRENCY_SYMBOL'); ?> <?php echo isset($value->plan_info[0]->plan_amount) ? $value->plan_info[0]->plan_amount : ''; ?>)</p>
                                    </div>
                                    <?php
                                            } else if (isset($value->product_info) && !empty($value->product_info)) {
                                                $total_amount +=  $value->product_info[0]->price * $value->quantity;
                                                ?>
                                    <div class="details-list">
                                        <label>Product</label>
                                        <p><?php echo isset($value->product_info[0]->title) ? $value->product_info[0]->title : ''; ?> (<?php echo env('CURRENCY_SYMBOL') . ' ' . $value->product_info[0]->price * $value->quantity; ?>)</p>
                                    </div>
                                    <?php
                                            }
                                            ?>
                                </div>
                                <?php
                                }
                            }
                            ?>
                                <div class="details-list vat mt-3 d-none">
                                    <label>VAT</label>
                                    <p>$50.00</p>
                                </div>
                                <div class="details-list total">
                                    <label>Total</label>
                                    <p><?php echo env('CURRENCY_SYMBOL'); ?><?php echo $total_amount; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteparty" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="deletepartyLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletepartyLabel">Delete Party</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete Party?</p>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close"
                        class="btn btn-outline-dark btn-block">Cancel</button>
                    <button type="button" class="btn btn-danger btn-block" data-id="{{ $default_event->id }}"
                        id="confirmDeleteBtn">Delete Party</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pageScript')
    <script src="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
@endsection
@section('pageScriptlinks') 
    <script>
        var paymentTokenUrl = '{{ route('paymentToken') }}';
        var user_info = '{!! json_encode(Auth::user()) !!}';
        user_info = JSON.parse(user_info);
        var SQUARE_CURRENCY = '{{ env('SQUARE_CURRENCY') }}';
        const SQUARE_APP_ID = '{{ env('SQUARE_APP_ID') }}';
        const SQUARE_LOCATION_ID = '{{ env('SQUARE_LOCATION_ID') }}';
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="{{ env('SQUARE_JS_URL') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/cart.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/card-input.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/page/auth.js') }}"></script>
        <script type="text/javascript">
        function initialize() {
            var input = document.getElementById('txtPlaces2');
            
            var autocomplete = new google.maps.places.Autocomplete(input);
            
              google.maps.event.addListener(autocomplete, 'place_changed', function() {
                                      console.log('autocomplete');
                var place = autocomplete.getPlace();
                 console.log('Place object:', place);

                 var place = autocomplete.getPlace();
                 console.log('place.name',place.name);
                 console.log('place.geometry.location.lat()',place.geometry.location.lat());
                 console.log('place.geometry.location.lng()',place.geometry.location.lng());

                console.log(place.geometry);
                 
                 if (place.geometry) {
                        var lat = place.geometry.location.lat();
                        var lng = place.geometry.location.lng();
                        console.log('place.name', place.name);
                        console.log('place.geometry.location.lat()', lat);
                        console.log('place.geometry.location.lng()', lng);
            
                        // Set the values of the hidden input fields
                        document.getElementById('lat2').value = lat;
                        document.getElementById('lng2').value = lng;
                } else {
                    console.log("No geometry information available for the selected place.");
                }
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "ordering": false,
                "dom": 'rtip'
            });
            $('#example1').DataTable({
                "ordering": false,
                "dom": 'rtip'
            });
            $('#example2').DataTable({
                "ordering": false,
                "dom": 'rtip'
            });

            $('#selectAllSortlist').click(function(e) {
                $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
            });

            $('#selectAllPending').click(function(e) {
                $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
            });

            $('#selectAllConfirmed').click(function(e) {
                $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
            });
            function setCheck(o, c) {
                o.prop("checked", c);
                if (c) {
                    o.closest("tr").addClass("checked");
                } else {
                    o.closest("tr").removeClass("checked");
                }
            }

            function setCheckAll(o, c) {
                o.each(function() {
                    setCheck($(this), c);
                });
                if (c) {
                    $("#selectAll").prop("title", "Check All");
                } else {
                    $("#selectAll").prop("title", "Uncheck All");
                }
            }
            
         


            if ($('[name="create-event"]').length > 0) {
                $('[name="create-event"]').validate({
                    errorClass: 'text-danger',
                    errorPlacement: function(error, element) {
                        if (element.attr('name') != 'title') {
                            error.insertAfter($(element).closest('.input-group'));
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    rules: {
                        title: {
                            required: true
                        },
                        location: {
                            required: true
                        },
                        event_date: {
                            required: true
                        },
                        event_to_date: {
                            required: true
                        },
                        category: {
                            required: true
                        },
                    },
                    messages: {
                        title: {
                            required: "Please enter title."
                        },
                        location: {
                            required: "Please enter location."
                        },
                        event_date: {
                            required: "Please enter date."
                        },
                        event_date: {
                            required: "Please enter to date."
                        },
                        category: {
                            required: "Please select category."
                        },
                    }
                });

                $('[name="create-event"]').submit(function() {
                    $('.validation-message,.success-message').remove();
                    if ($('[name="create-event"]').valid()) {
                        $('[type="submit"]').attr('disabled', 'disabled');
                        $('[type="submit"]').find('.spinner-border').removeClass('d-none');
                        var current = $(this);
                        $.ajax({
                            url: current.attr('action'),
                            method: 'POST',
                            data: current.serialize(),
                            dataType: 'json',
                            success: function(response) {
                                $('[type="submit"]').removeAttr('disabled');
                                $('[type="submit"]').find('.spinner-border').addClass('d-none');
                                if (response.status) {
                                    $('.success-msg').removeClass('d-none');
                                    $('<p class="text-success success-message">' + response
                                        .message + '</p>').insertBefore($('[name="title"]'));
                                    setTimeout(function() {
                                        window.location = window.location.href;
                                    }, 1000);
                                } else {
                                       $('#cover-spin').hide();
                                 toastr.error(response.message || 'An error occurred while processing your request.');
                                    $.each(response.message, function(input, error) {
                                        $('<small class="text-danger validation-message small">' +
                                            error + '</small>').insertAfter($(
                                            '[name="' + input + '"]'));
                                    });
                                }
                            },
                            error: function(response) {
                                $('[type="submit"]').removeAttr('disabled');
                                $('[type="submit"]').find('.spinner-border').addClass('d-none');
                                if (typeof response.responseJSON.errors != undefined) {
                                    $.each(response.responseJSON.errors, function(input,
                                        error) {
                                        $('<p class="text-danger validation-message small">' +
                                            error + '</p>').insertAfter($(
                                            '[name="' + input + '"]'));
                                    });
                                }
                            }
                        });
                    }
                });
            }

            $('#confirmDeleteBtn').click(function() {
                var eventId = $(this).data('id'); // Fetch the event ID from data-id attribute
                $.ajax({
                    url: '{{ route('event.delete') }}',
                    type: 'POST',
                    data: {
                        id: eventId,
                        _token: '{{ csrf_token() }}' // Add CSRF token if needed
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            location.reload();
                        } else {
                            // Handle error scenario
                            alert(response.message);
                        }
                    },
                    error: function(error) {
                        // Handle error response
                        console.error('Error deleting event:', error);
                        alert('Error deleting event. Please try again.');
                    }
                });
                $('#deleteparty').modal('hide');
            });
            $("#selectAll").on('change', function() {
                setCheckAll($("tbody input[type='checkbox']"), $(this).prop("checked"));
            });
            $("tbody tr").on("click", function(e) {
                var chk = $("[type='checkbox']", this);
                setCheck(chk, !$(this).hasClass("checked"));
            });

            $(".pdt").click(function() {
                $(".menus").parent().toggleClass("showopt");
            });

            $(".mypt").click(function() {
                $(".mypt").parent().toggleClass("showlist");
            });

            $(".moreptydtl").click(function() {
                $(".more-det").toggleClass("show");
                $(".moreptydtl").toggleClass("show");
            });

           $('.btn-add-more').click(function(){
                var $button = $(this);  // Store reference to the button
                var locationFilterIgnore = $button.data('ignore');
                $.ajax({
                    url: '/update-location-filter',
                    method: 'POST',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'location_filter_ignore': locationFilterIgnore
                    },
                    success: function (response) {
                        if (response.status) {
                            window.location = $button.attr('data-url') + '?id=' + $('.event-selection a.active').attr('data-id');
                        }
                    }
                });
            });
        });
    </script>
@endsection
