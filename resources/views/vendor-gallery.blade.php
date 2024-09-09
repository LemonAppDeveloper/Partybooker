@extends('layouts.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
 

@endsection
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="party-heading vendor-heading">
                <h3><a href="/"><i class="las la-arrow-left"></i></a> <?php echo $info->name; ?></h3>
                <p class="d-none">Sydney Opera House Utzon Room, Bennelong Point, Sydney New South Wales 2000</p>
                <div class="opts">
                    <p class="invisible">Mon-Thur | 9:00AM - 6:00PM</p>
                    <p>
                        {{-- <a href="{{url('social-media-share/'.$info->id)}}"><i class="las la-share"></i> Share </a> --}}
                        <a href="#" id="shareLink" data-info-id="{{ $info->id }}"><i class="las la-share"></i> Share</a>
                        <a href="javascript:void(0);" class="d-none"><i class="lar la-heart"></i> Add to favorite</a>
                    </p> 
                </div>
            </div>
        </div> 
    </div>
</div>
<div class="clearfix"></div>
<?php
if (isset($info->vendor_gallery['row_count']) && !empty($info->vendor_gallery['row_count'])) {
?>
    <div class="v-gallery">
        <div class="container mb-4">
            <div class="row">
                <?php
                foreach ($info->vendor_gallery['data'] as $id => $gallery) {
                     $fileExtension = pathinfo($gallery->image_url, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']);
                    $isVideo = in_array(strtolower($fileExtension), ['mp4', 'webm', 'ogg']);
                ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="gallery-img">
                             <?php if ($isImage): ?>
                               <img src="<?php echo $gallery->image_url; ?>">
                            <?php elseif ($isVideo): ?>
                                <div class="video-play">
                                    <video controls>
                                        <source src="{{ $gallery->image_url }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <button class="lvideo" data-url="{{ $gallery->image_url }}"><i class="las la-play"></i></button>
                                </div>
                            <?php else: ?>
                                  <p>Unsupported file type.</p>
                                                    <?php endif; ?>
                            
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
<?php
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-100">
            <div class="offers">
                <?php
                if (isset($info->vendor_attributes) && !empty($info->vendor_attributes)) {
                ?>
                    <h3>What this place offers</h3>
                    <div class="facility">
                        <?php
                        foreach ($info->vendor_attributes as $value) {
                        ?>
                            <div class="fac-box">
                                <img src="{{ url('assets/') }}/images/table-furniture.png" alt="toilet"> <?php echo $value->attribute_name; ?>
                                <?php echo $value->quantity; ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="more-button d-none">
                        <a href="javascript:void(0);" class="line-button">See all Amenities</a>
                    </div>
                <?php
                }
                if (isset($info->description) && !empty($info->description)) {
                ?>
                    <hr>
                    <p><?php echo nl2br($info->description); ?></p>
                <?php
                }
                ?>
                <hr>
                <h3>Reviews</h3>
                <div class="review-slider">
                    <?php
                    if (isset($info->vendor_reviews) && !empty($info->vendor_reviews)) {
                    ?>
                        <div class="slick-review">
                            <?php
                            foreach ($info->vendor_reviews as $review) {
                            ?>
                                <div class="review-box">
                                    <b>"<?php echo nl2br($review->review); ?>"</b>
                                    <p><span><?php echo $review->full_name; ?></span> <span>Rating: <?php echo $review->rating; ?>/5</span></p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="more-button">
                        <a href="javascript:void(0);" class="line-button" data-bs-toggle="modal" data-bs-target="#addreview">Add Review</a>
                    </div>
                    <hr>
                    <h3>Select what best suit’s you</h3>
                    <div class="package-product">
                        <nav>
                            <div class="nav nav-tabs justify-content-center nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-link active" href="javascript:void(0)" id="package-tab" data-bs-toggle="tab" data-bs-target="#package" type="button" role="tab" aria-controls="package" aria-selected="true">Package</a>
                                <a class="nav-link" href="javascript:void(0)" id="single-products-tab" data-bs-toggle="tab" data-bs-target="#single-products" type="button" role="tab" aria-controls="single-products" aria-selected="false">Single Products</a>
                            </div>
                        </nav>
                        <div class="tab-content pt-3" id="nav-tabContent">
                            <div class="tab-pane fade active show" id="package" role="tabpanel" aria-labelledby="package-tab">
                                <?php
                                if (isset($info->vendor_plan) && !empty($info->vendor_plan)) {
                                ?>
                                    <div class="row">
                                        <?php
                                        foreach ($info->vendor_plan as $plan) {
                                        ?>
                                            <div class="col-lg-3 col-md-4">
                                                <div class="package-bx">
                                                    <h4>{{ Str::limit($plan->plan_name, 24, '...') }}</h4> 
                                                    <div class="position-relative">
                                                    <a href="javascript:void(0);" class=""><i class="las la-heart update-favorite <?php echo isset($plan->is_favorite) && $plan->is_favorite == true ? 'active' : ''; ?>" data-type="plan" data-href="{{ route('updateFavorite') }}" data-id="{{ $plan->id }}"></i></a>
                                                </div>
                                                    <img src="<?php echo $plan->image_url; ?>" alt="<?php echo $plan->plan_name; ?>">
                                                    <h2>$<?php echo $plan->plan_amount; ?></h2>
                                                    <span class="d-none">4 months to pay with 0% Interest via credit card
                                                        <span>(Only available in Australia region)</span>
                                                    </span>
                                                    <p><?php echo nl2br($plan->plan_description); ?></p>
                                                    <div class="package-det">
                                                        <a href="javascript:void(0);" class="show-pkgdtl get-plan-view" data-url=<?php echo route('get-plan-view'); ?> data-id="<?php echo my_encrypt($plan->id); ?>">View
                                                            Breakdown</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-info">
                                        Plans not available at the moment.
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="tab-pane fade" id="single-products" role="tabpanel" aria-labelledby="single-products-tab">
                                <?php
                                if (isset($info->vendor_product) && !empty($info->vendor_product)) {
                                ?>
                                    <div class="product-list">
                                        <?php
                                        foreach ($info->vendor_product as $product) {
                                        ?>
                                            <div class="product-box">
                                             <h4>{{ Str::limit($product->title, 24, '...') }}</h4> 
                                                <div class="position-relative">
                                                    <a href="javascript:void(0);" class=""><i class="las la-heart update-favorite <?php echo isset($product->is_favorite) && $product->is_favorite == true ? 'active' : ''; ?>" data-type="product" data-href="{{ route('updateFavorite') }}" data-id="{{ $product->id }}"></i></a>
                                                </div>
                                                <img src="<?php echo $product->image_url; ?>" alt="<?php echo $product->title; ?>">
                                                <div class="price-rating">
                                                    <h3><?php echo env('CURRENCY_SYMBOL'); ?><?php echo $product->price; ?></h3>
                                                    <span class="d-none"><i class="las la-star"></i> 4.5</span>
                                                </div>
                                                <p><?php echo nl2br($product->description); ?></p>
                                                <div class="package-det">
                                                    <a href="javascript:void(0);" class="show-proddet get-product-view" data-url=<?php echo route('get-product-view'); ?> data-id="<?php echo my_encrypt($product->id); ?>">View
                                                        Breakdown</a>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-info">
                                        Products not available at the moment.
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    @if (count($faqs) > 0)
                    <hr>
                    <h3>Frequently asked questions</h3>
                    <div class="faqs-list">
                        <div class="accordion" id="accordionExample">

                            @foreach ($faqs as $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="true" aria-controls="collapse{{ $faq->id }}">
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if(isset($policy) && !empty($policy->description))
                    <hr>
                    <h3>Vendor Policy</h3>
                    <div class="vendor-policy">

                        <p>{!! isset($policy) ? $policy->description : 'Policy not yet available.' !!}</p>

                        {{-- <div class="facility">
                                <div class="fac-box">
                                    <i class="las la-clock"></i> Must not exceed the time
                                </div>
                                <div class="fac-box">
                                    <i class="las la-user-friends"></i> Must not exceed the time
                                </div>
                                <div class="fac-box">
                                    <i class="las la-business-time"></i> Must not exceed the time
                                </div>
                                <div class="fac-box">
                                    <i class="las la-clock"></i> Extra charge for extra time
                                </div>
                                <div class="fac-box">
                                    <i class="las la-clock"></i> Extra charge for extra time
                                </div>
                                <div class="fac-box">
                                    <i class="las la-clock"></i> Extra charge for extra time
                                </div>
                                <div class="fac-box">
                                    <i class="las la-clock"></i> Availability until: 10:00PM
                                </div>
                                <div class="fac-box">
                                    <i class="las la-clock"></i> Availability until: 10:00PM
                                </div>
                            </div> --}}
                        {{-- <p>Nulla Lorem mollit cupidatat irure. Laborum magna nulla duis ullamco cillum dolor. Voluptate
                                exercitation incididunt aliquip deserunt reprehenderit elit laborum. Nulla Lorem mollit
                                cupidatat irure. Laborum magna nulla duis ullamco cillum dolor. Voluptate exercitation
                                incididunt aliquip deserunt reprehenderit elit laborum...</p> --}}
                        {{-- <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="costs-box">
                                        <h3>Additional Costs</h3>
                                        <hr>
                                        <p>Additional charge for other task that are not in the package</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="costs-box">
                                        <h3>Additional Costs</h3>
                                        <hr>
                                        <p>Additional charge for other task that are not in the package</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="costs-box">
                                        <h3>Additional Costs</h3>
                                        <hr>
                                        <p>Additional charge for other task that are not in the package</p>
                                    </div>
                                </div>
                            </div> --}}
                    </div>
                    @endif
                    @if (isset($termsCondition) && !empty($termsCondition))
                    <hr>
                    <h3>Terms & Condition</h3>
                    <div class="terms-condition">
                        <p>Vendor Terms and Condition</p>
                        <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#termsmodel">View <i class="las la-arrow-up"></i></a>
                    </div>
                    @else
                    <p class="d-none">Terms and conditions not available.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4 col-30">
            <div class="sidebar-package sidebar-widget">

            </div>
            <div class="sidebar-product sidebar-widget">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addreview" tabindex="-1" aria-labelledby="addreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addreviewLabel">Add Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="review-form" action="{{ route('submitreview') }}" enctype="multipart/form-data" id="img-upload-form">
                    <input type="hidden" name="id" value="<?php echo my_encrypt($info->id); ?>">
                    <div class="overall-rating">
                        <p>Overall Rating</p>
                        <div class="rate">
                            <input type="radio" id="star5" name="rating" value="5" />
                            <label for="star5" title="text">5 stars</label>
                            <input type="radio" id="star4" name="rating" value="4" />
                            <label for="star4" title="text">4 stars</label>
                            <input type="radio" id="star3" name="rating" value="3" />
                            <label for="star3" title="text">3 stars</label>
                            <input type="radio" id="star2" name="rating" value="2" />
                            <label for="star2" title="text">2 stars</label>
                            <input type="radio" id="star1" name="rating" value="1" />
                            <label for="star1" title="text">1 star</label>
                        </div>
                    </div>
                    <div class="select-user d-none">
                        <ul class="list-unstyled">
                            <li class="init"><i class="las la-user-circle"></i> Send as</li>
                            <li data-value="value 1"><img src="{{ url('assets/') }}/images/profile.png"> John doe
                            </li>
                            <li data-value="value 2"><i class="las la-user-circle"></i> Anonymous</li>
                            <li data-value="value 3"><i class="las la-user-circle"></i> Anonymous</li>
                        </ul>
                        <i class="las la-angle-down arrows"></i>
                    </div>
                    <div class="select-user">
                        <select name="send_as" class="form-control">
                            <option value="">Send as</option>
                            <?php
                            if (Auth::check()) {
                            ?>
                                <option value="user">{{Auth::user()->name}}</option>
                            <?php
                            }
                            ?>
                            <option value="anonymous">Anonymous</option>
                        </select>
                    </div>
                    <textarea class="form-control" name="review" placeholder="Tell us what you think" rows="5"></textarea>
                    <div class="create-gallery d-none">
                        <div class="js-grid my-shuffle">
                            <div class="quote-imgs-thumbs quote-imgs-thumbs--hidden" id="img_preview" aria-live="polite">
                                
                            </div>
                            <figure class="js-item column upload">
                                <div class="upload-img">
                                    <div class="file">
                                        Add Files
                                        <input type="file" name="review_image[]" id="upload_imgs" class="attribute-image-input" accept="image/*" multiple />
                                    </div>
                                    <p>Add photos </p>
                                </div>
                            </figure>
                            <div class="column my-sizer-element js-sizer"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                <button href="javascript:void(0);" class="btn book-pkg submit-review">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="vendorcal" tabindex="-1" aria-labelledby="vendorcalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vendorcalLabel">Vendor Calendar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="model-date">
                    <a href="javascript:void(0);"><i class="las la-angle-left"></i></a>
                    <p>February 5, 2022</p>
                    <a href="javascript:void(0);"><i class="las la-angle-right"></i></a>
                </div>
                <div class="short-by">
                    <p>Sort by</p>
                    <i class="las la-minus"></i>
                </div>

                <div class="short-dates">
                    <nav>
                        <div class="nav nav-tabs justify-content-center nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-link" href="javascript:void(0)" id="alldate-tab" data-bs-toggle="tab" data-bs-target="#alldate" type="button" role="tab" aria-controls="alldate" aria-selected="true">All</a>
                            <a class="nav-link active" href="javascript:void(0)" id="availability-tab" data-bs-toggle="tab" data-bs-target="#availability" type="button" role="tab" aria-controls="availability" aria-selected="false">Availability</a>
                            <a class="nav-link" href="javascript:void(0)" id="booked-tab" data-bs-toggle="tab" data-bs-target="#booked" type="button" role="tab" aria-controls="booked" aria-selected="false">Booked</a>
                        </div>
                    </nav>
                    <div class="tab-content pt-3 bg-white" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="alldate" role="tabpanel" aria-labelledby="alldate-tab">
                            <div class="button-group-pills">
                                <label><input type="radio" name="rgroup" />2PM</label>
                                <label class="isSelected"><input type="radio" name="rgroup" />3PM</label>
                                <label><input type="radio" name="rgroup" />4PM</label>
                                <label><input type="radio" name="rgroup" />5PM</label>
                                <label><input type="radio" name="rgroup" />9PM</label>
                                <label><input type="radio" name="rgroup" />10PM</label>
                                <label><input type="radio" name="rgroup" />9AM</label>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="availability" role="tabpanel" aria-labelledby="availability-tab">
                            <div class="button-group-pills">
                                <label><input type="radio" name="rgroup" />2PM</label>
                                <label class="isSelected"><input type="radio" name="rgroup" />3PM</label>
                                <label><input type="radio" name="rgroup" />4PM</label>
                                <label><input type="radio" name="rgroup" />5PM</label>
                                <label><input type="radio" name="rgroup" />9PM</label>
                                <label><input type="radio" name="rgroup" />10PM</label>
                                <label><input type="radio" name="rgroup" />9AM</label>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="booked" role="tabpanel" aria-labelledby="booked-tab">
                            <div class="button-group-pills">
                                <label><input type="radio" name="rgroup" />2PM</label>
                                <label class="isSelected"><input type="radio" name="rgroup" />3PM</label>
                                <label><input type="radio" name="rgroup" />4PM</label>
                                <label><input type="radio" name="rgroup" />5PM</label>
                                <label><input type="radio" name="rgroup" />9PM</label>
                                <label><input type="radio" name="rgroup" />10PM</label>
                                <label><input type="radio" name="rgroup" />9AM</label>
                            </div>
                        </div>
                    </div>
                    <div class="info-massage">
                        <p>This time is available.</p>
                        <span>Select a time range that best suits your party.</span>
                    </div>
                    <a href="javascript:void(0);" class="view-all-review" id="timerange" data-bs-toggle="modal" data-bs-target="#timerangemodel">Time Range Selection</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="timerangemodel" tabindex="-1" aria-labelledby="timerangemodelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="javascript:void(0);" id="beckvendorcal" data-bs-toggle="modal" data-bs-target="#timerangemodel"><i class="las la-arrow-left"></i></a>
                <h5 class="modal-title" id="timerangemodelLabel">Time Range Selection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span>Your time availability will be reflected on the vendor page once you set your time of the
                    party.</span>
                <form>
                    <label>Start Time</label>
                    <select class="form-control">
                        <option>3:00PM</option>
                        <option>4:00PM</option>
                        <option>5:00PM</option>
                        <option>6:00PM</option>
                        <option>7:00PM</option>
                        <option>8:00PM</option>
                    </select>
                    <label>Finish Time</label>
                    <select class="form-control">
                        <option>5:00PM</option>
                        <option>6:00PM</option>
                        <option>7:00PM</option>
                        <option>8:00PM</option>
                        <option>9:00PM</option>
                        <option>10:00PM</option>
                    </select>
                    <div class="total-time">
                        <p>Total Hours</p>
                        <p>2 Hours</p>
                    </div>
                    <a href="javascript:void(0);" class="view-all-review checkout-btn" id="closetimerang" data-bs-toggle="modal" data-bs-target="#vendorcalsucc">Continue</a>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="vendorcalsucc" tabindex="-1" aria-labelledby="vendorcalsuccLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vendorcalsuccLabel">Vendor Calendar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="model-date">
                    <a href="javascript:void(0);"><i class="las la-angle-left"></i></a>
                    <p>February 5, 2022</p>
                    <a href="javascript:void(0);"><i class="las la-angle-right"></i></a>
                </div>
                <div class="short-by">
                    <p>Sort by</p>
                    <i class="las la-minus"></i>
                </div>

                <div class="short-dates">
                    <nav>
                        <div class="nav nav-tabs justify-content-center nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-link" href="javascript:void(0)" id="alldate-tab" data-bs-toggle="tab" data-bs-target="#alldate" type="button" role="tab" aria-controls="alldate" aria-selected="true">All</a>
                            <a class="nav-link active" href="javascript:void(0)" id="availability-tab" data-bs-toggle="tab" data-bs-target="#availability" type="button" role="tab" aria-controls="availability" aria-selected="false">Availability</a>
                            <a class="nav-link" href="javascript:void(0)" id="booked-tab" data-bs-toggle="tab" data-bs-target="#booked" type="button" role="tab" aria-controls="booked" aria-selected="false">Booked</a>
                        </div>
                    </nav>
                    <div class="tab-content pt-3 bg-white" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="alldate" role="tabpanel" aria-labelledby="alldate-tab">
                            <div class="button-group-pills">
                                <label><input type="radio" name="rgroup" />2PM</label>
                                <label class="isSelected"><input type="radio" name="rgroup" />3PM - 5PM</label>
                                <label><input type="radio" name="rgroup" />9PM</label>
                                <label><input type="radio" name="rgroup" />10PM</label>
                                <label><input type="radio" name="rgroup" />9AM</label>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="availability" role="tabpanel" aria-labelledby="availability-tab">
                            <div class="button-group-pills">
                                <label><input type="radio" name="rgroup" />2PM</label>
                                <label class="isSelected"><input type="radio" name="rgroup" />3PM - 5PM</label>
                                <label><input type="radio" name="rgroup" />9PM</label>
                                <label><input type="radio" name="rgroup" />10PM</label>
                                <label><input type="radio" name="rgroup" />9AM</label>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="booked" role="tabpanel" aria-labelledby="booked-tab">
                            <div class="button-group-pills">
                                <label><input type="radio" name="rgroup" />2PM</label>
                                <label class="isSelected"><input type="radio" name="rgroup" />3PM - 5PM</label>
                                <label><input type="radio" name="rgroup" />9PM</label>
                                <label><input type="radio" name="rgroup" />10PM</label>
                                <label><input type="radio" name="rgroup" />9AM</label>
                            </div>
                        </div>
                    </div>
                    <div class="info-massage success-msg">
                        <span class="text-success">You successfully secured this time!</span>
                        <span>We secured your place at this time, but take note that your spot will only be available
                            until the week before the event date.</span>
                        <span>If you don’t check out before that, we will forfeit your place and make this time and date
                            available to other users.</span>
                    </div>
                    <a href="javascript:void(0);" class="view-all-review" id="timeranges" data-bs-toggle="modal" data-bs-target="#timerangemodel">Time Range Selection</a>
                    <a href="javascript:void(0);" class="view-all-review checkout-btn" data-bs-dismiss="modal">Choose
                        this Time</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="advancedsearch" tabindex="-1" aria-labelledby="advancedsearchLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="advancedsearchLabel">Advanced Search</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mode-search">
                    <div class="input-group">
                        <span class="input-group-append input-group-addon">
                            <span class="input-group-text"><i class="las la-search"></i></span>
                        </span>
                        <input type="text" name="search" class="form-control" placeholder="Search nearby events">
                    </div>
                </div>
                <div class="short-by">
                    <p>Advanced filtering</p>
                    <i class="las la-minus"></i>
                </div>
                <div class="my-details">
                    <p><i class="las la-map-marker"></i> Add location of the party</p>
                    <div class="date-time">
                        <div class="left-side">
                            <i class="las la-calendar"></i>
                            <p>Add preferred day</p>
                        </div>
                        <div class="right-side">
                            <i class="las la-stopwatch"></i>
                            <p>Add preferred time</p>
                        </div>
                    </div>
                    <p><i class="las la-fire"></i> Add specific category</p>
                </div>
                <div class="short-by">
                    <p>Advanced filtering</p>
                    <i class="las la-minus"></i>
                </div>

                <div class="short-dates">
                    <nav>
                        <div class="nav nav-tabs justify-content-center nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-link" href="javascript:void(0)" id="popularity-tab" data-bs-toggle="tab" data-bs-target="#popularity" type="button" role="tab" aria-controls="popularity" aria-selected="true">Popularity</a>
                            <a class="nav-link active" href="javascript:void(0)" id="newest-tab" data-bs-toggle="tab" data-bs-target="#newest" type="button" role="tab" aria-controls="newest" aria-selected="false">Newest</a>
                            <a class="nav-link" href="javascript:void(0)" id="oldest-tab" data-bs-toggle="tab" data-bs-target="#oldest" type="button" role="tab" aria-controls="oldest" aria-selected="false">Oldest</a>
                        </div>
                    </nav>
                    <div class="tab-content pt-3 bg-white" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="popularity" role="tabpanel" aria-labelledby="popularity-tab">
                        </div>
                        <div class="tab-pane fade" id="newest" role="tabpanel" aria-labelledby="newest-tab">

                        </div>
                        <div class="tab-pane fade" id="oldest" role="tabpanel" aria-labelledby="oldest-tab">
                        </div>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-search d-block">Search</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="quickanswer" class="d-none">
    <a href="#">
        <i class="las la-comment-dots"></i>
        Quick Answer
    </a>
</div>

<div class="modal fade" id="termsmodel" tabindex="-1" aria-labelledby="termsmodelLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="termsconditionmodel">
                    {!! !empty($termsCondition) && !empty(trim($termsCondition->description)) ? $termsCondition->description : 'No terms and conditions found.' !!}

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="shareModalBody">
                <!-- Share widget content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection
@section('pageScript')
@endsection
@section('pageScriptlinks')
<script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/page/auth.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.slick/1.4.1/slick.min.js"></script>
<script>
    $().ready(function() {

        $('#shareLink').click(function (e) {
            e.preventDefault();
            var infoId = $(this).data('info-id');
            $.ajax({
                url: "{{ url('social-media-share') }}/" + infoId,
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    $('#shareModalBody').html(response.shareComponentHtml);
                    $('#shareModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });


        $('.slick-review').slick({
            arrows: false,
            centerPadding: "0px",
            dots: false,
            infinite: true,
            margin: '10px',
            autoplay: true,
            slidesToShow: 4,
            autoplay: 1000,
            interval: 1000,
            // centerMode: true,
            responsive: [{
                    breakpoint: 1240,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 540,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });

        $('.submit-review').click(function() {
            $('.submit-review').attr('disabled', 'disabled');
            $('.submit-review').text('Please Wait...');
            $('#cover-spin').show();
            var current = $('[name="review-form"]');
            var formData = new FormData($('[name="review-form"]')[0]);

            $.ajax({
                url: current.attr('action'),
                type: 'POST',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                dataType: 'json',
                success: function(response) {
                    $('.submit-review').removeAttr('disabled');
                    $('.submit-review').text('Submit');
                    $('#cover-spin').hide();
                    $('#file').find('.spinner-border').addClass('d-none');
                    $('#file').removeAttr('disabled');
                    if (response.status) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            $('.success-message').fadeOut();
                            window.location = window.location.href;
                        }, 1000);
                    } else {
                        $.each(response.message, function(input, error) {
                            toastr.error(error);
                        });
                    }
                },
                error: function(response) {
                    $('.submit-review').removeAttr('disabled');
                    $('.submit-review').text('Submit');
                    $('#cover-spin').hide();
                    $('#file').find('.spinner-border').addClass('d-none');
                    $('#file').removeAttr('disabled');
                    var response = JSON.parse(response.responseText);
                    if (typeof response.errors != undefined) {
                        $.each(response.errors, function(input, error) {
                            $('<p class="text-danger validation-message">' + error[
                                0] + '</p>').insertAfter($(
                                '[name="review-form"]').find('[name="' +
                                input + '"]'));
                        });
                    }
                }
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".get-plan-view").click(function() {
            $('#cover-spin').show();

            $(".get-plan-view").not(this).text("View Breakdown");
            var current = $(this);
            $.ajax({
                url: current.attr('data-url'),
                method: 'POST',
                data: {
                    'id': current.attr('data-id')
                },
                dataType: 'json',
                success: function(response) {
                    $('#cover-spin').hide();
                    if (response.status) {
                        current.text("Selected");
                        $(".sidebar-package").html(response.data.html);
                        $(".col-100").removeClass("col-md-12");
                        $(".col-100").addClass("col-md-8");
                        $(".col-30").addClass("show");
                        $(".sidebar-package").addClass("show");
                        $(".sidebar-product").removeClass("show");

                        setTimeout(function() {
                            $('html, body').animate({
                                scrollTop: $(".sidebar-package").offset()
                                    .top
                            }, 500);
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        });
        
         

        $(".get-product-view").click(function() {
            $('#cover-spin').show();
            $(".get-plan-view").not(this).text("View Breakdown");
            var current = $(this);
            $.ajax({
                url: current.attr('data-url'),
                method: 'POST',
                data: {
                    'id': current.attr('data-id')
                },
                dataType: 'json',
                success: function(response) {
                    $('#cover-spin').hide();
                    if (response.status) {
                        current.text('Selected');
                        $(".sidebar-product").html(response.data.html);
                        $(".col-100").removeClass("col-md-12");
                        $(".col-100").addClass("col-md-8");
                        $(".col-30").addClass("show");
                        $("#single-products").addClass("show-det");
                        $(".sidebar-package").removeClass("show");
                        $(".sidebar-product").addClass("show");

                        setTimeout(function() {
                            $('html, body').animate({
                                scrollTop: $(".sidebar-product").offset()
                                    .top
                            }, 500);
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        });

        $("#package-tab").click(function() {
            $(".col-100").removeClass("col-md-8");
            $(".col-100").addClass("col-md-12");
            $(".col-30").removeClass("show");
            $("#single-products").removeClass("show-det");
        });
        $("#single-products-tab").click(function() {
            $(".col-100").removeClass("col-md-8");
            $(".col-100").addClass("col-md-12");
            $(".col-30").removeClass("show");
            $("#single-products").removeClass("show-det");
        });

        $(document).on('click', '.update-favorite', function(event) {
            event.stopPropagation();
            var current = $(this);
            $('#cover-spin').show();
            $.ajax({
                url: current.attr('data-href'),
                type: 'POST',
                data: {
                    'id': current.attr('data-id'),
                    'type': current.attr('data-type'),
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        toastr.remove();
                        toastr.success(response.message);
                        if (response.data.is_favorite) {
                            current.addClass('active');
                        } else {
                            current.removeClass('active');
                        }
                    } else {
                        toastr.remove();
                        toastr.error(response.message);
                    }
                    $('#cover-spin').hide();
                }
            });
        });
    });
</script>
<script>
var imgUpload = document.getElementById('upload_imgs')
  , imgPreview = document.getElementById('img_preview')
  , imgUploadForm = document.getElementById('img-upload-form')
  , totalFiles
  , previewTitle
  , img;

imgUpload.addEventListener('change', previewImgs, false);
imgUploadForm.addEventListener('submit', function (e) {
  e.preventDefault();
  alert('Images Uploaded! (not really, but it would if this was on your website)');
}, false);

function previewImgs(event) {
  totalFiles = imgUpload.files.length;
  
  if(!!totalFiles) {
    imgPreview.classList.remove('quote-imgs-thumbs--hidden');
    previewTitle = document.createElement('p');
    previewTitle.style.fontWeight = 'bold';
    imgPreview.appendChild(previewTitle);
  }
  
  for(var i = 0; i < totalFiles; i++) {
    img = document.createElement('img');
    img.src = URL.createObjectURL(event.target.files[i]);
    img.classList.add('img-preview-thumb');
    imgPreview.appendChild(img);
  }
}
</script>
<script src="{{ asset('assets/js/calendar.js') }}"></script>
<script src="{{ asset('assets/js/validation.js') }}"></script>
<script src="{{ asset('assets/js/cart.js') }}"></script>
<script src="{{ asset('assets/js/videoplay.js') }}"></script>
@endsection