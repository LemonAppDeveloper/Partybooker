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
                    <button class="btn btn-outline-dark"><i class="las la-eye"></i> See Preview</button>
                    <span class="line"></span>
                    <button class="btn btn-success">Save & Publish</button>
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
                                ?>
                                        <figure class="js-item column">
                                            <div class="aspect aspect--16x9">
                                                <div class="img-option">
                                                    <button type="button" data-id="{{ $value->id }}" data-url="{{ route('deleteGalleryImage') }}" class="btn delete-image"><i class="las la-times"></i> Remove</button>
                                                    <button type="button" data-id="{{ $value->id }}" class="btn d-none"><i class="las la-retweet"></i> Change Image</button>
                                                </div>
                                                <div class="aspect__inner">
                                                    <img src="{{ $value->image_url }}" alt="{{ $value->name }}" />
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
                                                Add Files
                                                <input type="file" name="image" id="gallery-file" accept="image/*" />
                                            </div>
                                        </form>
                                        <!-- <a href="#" class="btn btn-upload"></a> -->
                                        <p style="visibility: hidden;">Select file to upload. </p>
                                    </div>
                                </figure>

                                <div class="column my-sizer-element js-sizer"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 overflow">
            <div class="row">
                <div class="col-md-12">
                    <div class="vendor-details">
                        <div class="vdt-head">
                            <h3>Plan Details</h3>
                            <a href="#"><i class="las la-exchange-alt"></i> Arrange</a>
                        </div>
                        <div class="plan-det">
                            <form action="" method="POST">
                                <select class="form-control">
                                    <option>Number of Plans</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                                <div class="nots">
                                    <i class="las la-info-circle"></i>
                                    <span>Reducing the number of filled plans will automatically remove the most bottom plan.</span>
                                </div>
                                <hr>
                                <input type="text" class="form-control" name="plan-name" placeholder="Plan Name" value="Basic VIP">
                                <select class="form-control">
                                    <option>None</option>
                                    <option>100</option>
                                    <option>200</option>
                                    <option>300</option>
                                </select>
                                <textarea rows="8" class="form-control" placeholder="Description">Nulla Lorem mollit cupidatat irure. Laborum magna nulla duis ullamco cillum dolor. Voluptate exercitation incididunt aliquip deserunt reprehenderit elit laborum. </textarea>
                                <input type="text" class="form-control" name="price" placeholder="Plan Price" value="$450.00">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="chargeplan">
                                    <label class="form-check-label text-start" for="chargeplan">
                                        Charge tax on this plan
                                    </label>
                                </div>
                                <div class="btn-opt">
                                    <a href="#" class="view-all-review">Mark as Unavailable</a>
                                    <a href="#" class="view-all-review discard-btn">Discard</a>
                                </div>

                                <hr>
                                <input type="text" class="form-control" name="plan-name" placeholder="Plan Name" value="Premium VIP">
                                <select class="form-control">
                                    <option>100</option>
                                    <option>None</option>
                                    <option>200</option>
                                    <option>300</option>
                                </select>
                                <textarea rows="8" class="form-control" placeholder="Description">Nulla Lorem mollit cupidatat irure. Laborum magna nulla duis ullamco cillum dolor. Voluptate exercitation incididunt aliquip deserunt reprehenderit elit laborum. </textarea>
                                <input type="text" class="form-control" name="price" placeholder="Plan Price" value="$550.00">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="chargeplana">
                                    <label class="form-check-label text-start" for="chargeplana">
                                        Charge tax on this plan
                                    </label>
                                </div>
                                <div class="btn-opt">
                                    <a href="#" class="view-all-review">Mark as Unavailable</a>
                                    <a href="#" class="view-all-review discard-btn">Discard</a>
                                </div>
                            </form>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.vendor.modal-profile')
@include('layouts.vendor.modal-calendar')
@include('layouts.vendor.modal-settings')
@endsection
@section('pageScript')
<script src="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script src='https://unpkg.com/shufflejs@6'></script>
<script>
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

        $.ajax({
            url: current.attr('action'),
            type: 'POST',
            //data: current.serialize(),
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            dataType: 'json',
            success: function(response) {
                $('#file').find('.spinner-border').addClass('d-none');
                $('#file').removeAttr('disabled');
                if (response.status) {
                    toastr.success(response.message);
                    setTimeout(function() {
                        $('.success-message').fadeOut();;
                        window.location = window.location.href;
                    }, 1000);
                } else {
                    $.each(response.message, function(input, error) {
                        toastr.success(error);
                    });
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