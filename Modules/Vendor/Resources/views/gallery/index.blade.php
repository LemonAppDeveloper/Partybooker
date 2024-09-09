@extends('layouts.vendor.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="pg-heading">
                <h3><a href="{{ route('dashboard') }}"><i class="las la-arrow-left"></i></a>&nbsp;&nbsp;&nbsp; Vendor Details</h3>
                <div class="btn-right">
                    <button type="button" class="btn btn-outline-dark d-none"><i class="las la-eye"></i> See Preview</button>
                    <span class="line d-none"></span>
                    <button type="button" class="btn btn-success btn-update-vendor">Save & Publish</button>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9 overflow">
            <div class="row">
                <div class="col-md-12">
                    <div class="order-derails">
                        <div class="order-head">
                            <h3>Gallery</h3>
                        </div>
                        <div class="create-gallery">
                            <div class="js-grid my-shuffle">
                             <?php
                                if (isset($images) && $images['row_count'] > 0) {
                                    foreach ($images['data'] as $value) {
                                        // Determine the file type based on the URL or MIME type
                                        $fileExtension = pathinfo($value->image_url, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']);
                                        $isVideo = in_array(strtolower($fileExtension), ['mp4', 'webm', 'ogg']);
                                        ?>
                                        <figure class="js-item column">
                                            <div class="aspect aspect--16x9">
                                                <div class="img-option">
                                                    <button type="button" data-id="{{ $value->id }}" data-url="{{ route('deleteGalleryImage') }}" class="btn delete-image">
                                                        <i class="las la-times"></i> Remove
                                                    </button>
                                                    <button type="button" data-id="{{ $value->id }}" class="btn d-none">
                                                        <i class="las la-retweet"></i> Change Image
                                                    </button>
                                                </div>
                                                <div class="aspect__inner">
                                                    <?php if ($isImage): ?>
                                                        <img src="{{ $value->image_url }}" alt="{{ $value->name }}" />
                                                    <?php elseif ($isVideo): ?>
                                                        <video controls>
                                                            <source src="{{ $value->image_url }}" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    <?php else: ?>
                                                        <p>Unsupported file type.</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </figure>
                                        <?php
                                    }
                                }
                                ?>

                                <figure class="js-item column upload">
                                    <div class="upload-img">
                                        <form name="upload-image" action="{{ route('uploadgalleryimage') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="file">
                                                Add images
                                                <!--<input type="file" name="image" id="gallery-file" accept="image/*" />-->
                                                 <input type="file" name="media" id="gallery-file" accept="image/*,video/*" />
                                            </div>
                                        </form>
                                        <p>Select file to upload. </p>
                                    </div>
                                </figure>

                                <div class="column my-sizer-element js-sizer"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 overflow">
            <div class="row">
                <div class="col-md-12">
                    <div class="vendor-details">
                        <div class="vdt-head">
                            <h3>Description</h3>
                        </div>
                        <div class="plan-det">
                            <form action="<?php echo route('updateVendorAttributes') ?>" name="update-vendor-description" method="POST">
                                <textarea class="form-control" rows="6" placeholder="Vendor Description" name="description">{{ Auth::user()->getDescription() }}</textarea>
                                <hr>
                                <select class="form-control d-none">
                                    <option>Number of what you can offer</option>
                                    <?php
                                    for ($i = 1; $i <= 50; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <div class="nots">
                                    <i class="las la-info-circle"></i>
                                    <span>Inclusions</span>
                                </div>
                                <div class="clone-main-attribute">
                                    <?php
                                    $info = getVendorAttributes(Auth::user()->id);
                                    if (!empty($info)) {
                                        foreach ($info as $value) {
                                    ?>
                                            <div class="clone-sub-attribute">
                                                <div class="product-select">
                                                    <input type="text" class="form-control custom-required" name="attribute_name[]" placeholder="Offer name" value="<?php echo $value->attribute_name; ?>">
                                                    <div class="number">
                                                        <span class="minus quantity-minus">-</span>
                                                        <input type="text" name="quantity[]" value="<?php echo $value->quantity; ?>" readonly />
                                                        <span class="plus quantity-plus">+</span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="clone-sub-attribute">
                                            <div class="product-select">
                                                <input type="text" class="form-control custom-required" name="attribute_name[]" placeholder="Offer name">
                                                <div class="number">
                                                    <span class="minus quantity-minus">-</span>
                                                    <input type="text" name="quantity[]" value="1" readonly />
                                                    <span class="plus quantity-plus">+</span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="product-select">
                                    <button type="button" class="btn btn-sm btn-danger remove-attribute-clone-sec">Remove</button>
                                    <button type="button" class="btn btn-sm btn-success add-attribute-clone-sec">Add</button>
                                   
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class="package-product">
                <nav>
                    <div class="nav nav-tabs justify-content-center nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-link active" href="javascript:void(0)" id="package-tab" data-bs-toggle="tab" data-bs-target="#package" type="button" role="tab" aria-controls="package" aria-selected="true">Package</a>
                        <a class="nav-link" href="javascript:void(0)" id="single-products-tab" data-bs-toggle="tab" data-bs-target="#single-products" type="button" role="tab" aria-controls="single-products" aria-selected="false">Single Products</a>
                    </div>
                </nav>
                <div class="tab-content pt-3" id="nav-tabContent">
                    <div class="tab-pane fade active show" id="package" role="tabpanel" aria-labelledby="package-tab">
                        <?php echo isset($plan_view) ? $plan_view : ''; ?>
                    </div>
                    <div class="tab-pane fade" id="single-products" role="tabpanel" aria-labelledby="single-products-tab">
                        <?php echo isset($product_view) ? $product_view : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.vendor.modal-add-plan')
@include('layouts.vendor.modal-add-product')
@include('layouts.vendor.modal-profile')
@include('layouts.vendor.modal-calendar')
@include('layouts.vendor.modal-settings')
@endsection
@section('pageScript')
<script src="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script src="{{ asset('vendor-assets/js/page/auth.js') }}"></script>
<script src="{{ asset('assets/js/validation.js') }}"></script>
<script src="{{ asset('vendor-assets/js/product.js') }}"></script>
<script src="{{ asset('vendor-assets/js/plan.js') }}"></script>
<script src="{{ asset('vendor-assets/js/vendor.js') }}"></script>
<script src='https://unpkg.com/shufflejs@6'></script>
<script>
    $(document).on("click", ".list-unstyled .init", function() {
        $(this).closest(".list-unstyled").children('li:not(.init)').toggle();
    });

    var allOptions = $(".list-unstyled").children('li:not(.init)');
    $(document).on("click", ".list-unstyled li:not(.init)", function() {
        allOptions.removeClass('selected');
        $(this).addClass('selected');
        $('[name="product_status"]').val($(this).attr('data-value'));
        $(this).closest(".list-unstyled").children('.init').html($(this).html());
        $(this).closest(".list-unstyled").find('li').not('.init').hide();
        allOptions.toggle();
    });

    const Shuffle = window.Shuffle;
    const myShuffle = new Shuffle(document.querySelector('.my-shuffle'), {
        itemSelector: '.js-item',
        sizer: '.js-sizer',
        buffer: 1,
    });

    $('#gallery-file').change(function() {
        $(this).closest('form').submit();
    });
    $('[name="upload-image"]').submit(function(e) {
        e.preventDefault();
        $('.validation-message,.success-message').remove();
        $('#file').find('.spinner-border').removeClass('d-none');
        $('#file').attr('disabled', 'disabled');

        var current = $('[name="upload-image"]');
        var formData = new FormData($('[name="upload-image"]')[0]);
        $('#cover-spin').show();
        $.ajax({
            url: current.attr('action'),
            type: 'POST',
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            dataType: 'json',
            success: function(response) {
                $('#file').find('.spinner-border').addClass('d-none');
                $('#file').removeAttr('disabled');
                 $('#cover-spin').hide();
                if (response.status) {
                    toastr.success(response.message);
                    setTimeout(function() {
                        $('.success-message').fadeOut();;
                        window.location = window.location.href;
                    }, 1000);
                } else {
                   
                  toastr.error(response.message); 
                }
            },
            error: function(response) {
                $('#file').find('.spinner-border').addClass('d-none');
                $('#file').removeAttr('disabled');
                if (typeof response.responseJSON.errors != undefined) {
                    $.each(response.responseJSON.errors, function(input, error) {
                        toastr.error(error);
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
    $(document).on('click', '.delete-image', function() {
        var current = $(this);
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure want to delete image?',
            buttons: {
                confirm: {
                    btnClass: 'btn-success',
                    action: function() {
                        $('#cover-spin').show();
                        $.ajax({
                            url: current.attr('data-url'),
                            type: 'POST',
                            data: {
                                'id': current.attr('data-id'),
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status) {
                                    toastr.success(response.message);
                                    setTimeout(function() {
                                        window.location = window.location.href;
                                    }, 500);
                                } else {
                                    toastr.error(response.message);
                                }
                                $('#cover-spin').hide();
                            }
                        });
                    }
                },
                cancel: function() {}
            }
        });
    });
</script>
@endsection