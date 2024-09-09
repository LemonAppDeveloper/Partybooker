@extends('layouts.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
<style>
    .input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n+3), .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu) {
            border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
    }
    
    .input-group-text{
            border-radius: 10px 0 0 10px;
    }
</style>
@endsection

@section('content')
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-md-12">
          
            <div id="featureContainer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="party-banner" style="background-image:url({{ asset('assets/images/party-banner.png') }})">
                            <div class="row">
                                <div class="col-lg-4 offset-lg-8">
                                    <span>Welcome to <span>Partybookr</span></span>
                                    <h3>Let's organize your party!</h3>
                                    <p>We’ll help you set up your best party!</p>

                                    @if(Auth::check())
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#organizeparty">
                                        Organize Party
                                    </a>
                                    @else
                                    <a href="{{url('login')}}">
                                        Login
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<section class="ctlist">
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div id="featureContainer">
                    <div class="categories-widget">
                        <div class="cat-head">
                            <form id="search-forms">
                                <div class="input-group">
                                    <span class="input-group-append input-group-addon btn-filter">
                                        <span class="input-group-text"><i class="las la-search"></i></span>
                                    </span>
                                    <input id="search" type="text" name="search" class="form-control" placeholder="Search">
                                    <span class="input-group-append input-group-addon adv-search">
                                       
                                    </span>
                                    <div class="locations-view">
                                        <p><label><i class="las la-map-marker-alt"></i></label> 
                                          <span>
                                  
                                            @if(!Auth::check() || session('location_filter_ignore') == '1' || !$location)
                                                All
                                                <a href="javascript:void()" class="clear-btn-filter" data-ignore="1">
                                                    <i class="las la-times "></i>
                                                </a>
                                            @else
                                                {{ Str::limit($location, 12, '...') }}
                                                <a href="javascript:void()" class="clear-btn-filter" data-ignore="1">
                                                    <i class="las la-times"></i>
                                                </a>
                                                <div class="tooltipshow">{{$location}}</div>
                                            @endif
                                        </span>
                                        
                                        </p>
                                    </div>
                                </div>
                                <div class="star-filters">
                                    <div class="stars-f">
                                        <i class="las la-filter"></i>
                                        <span>Filter by</span>
                                        <i class="las la-angle-down"></i>
                                    </div>
                                    <div class="stars-opt">
                                        <div class="f-header">
                                            <h3>Filter by </h3>
                                            <a href="javascript:void()" class="remove"><i class="las la-times"></i></a>
                                        </div>
                                        <div class="f-body">
                                             <div class="opt">
                                                <div class="starss">
                                              <label for="so1">Rating</label>
                                              </div>
                                              </div>
                                            <div class="opt">
                                                <div class="starss">
                                                  
                                                    <i class="las la-star"></i>
                                                    <i class="las la-star"></i>
                                                    <i class="las la-star"></i>
                                                    <i class="las la-star"></i>
                                                    <i class="las la-star"></i>
                                                </div>
                                                <input type="radio" value="5" name="rating">
                                            </div>
                                            <div class="opt">
                                                <div class="starss">
                                                    <i class="las la-star"></i>
                                                    <i class="las la-star"></i>
                                                    <i class="las la-star"></i>
                                                    <i class="las la-star"></i>
                                                    <i class="lar la-star"></i>
                                                </div>
                                                <input type="radio" value="4" name="rating">
                                            </div>
                                            <div class="opt">
                                                <div class="starss">
                                                    <i class="las la-star"></i>
                                                    <i class="las la-star"></i>
                                                    <i class="las la-star"></i>
                                                    <i class="lar la-star"></i>
                                                    <i class="lar la-star"></i>
                                                </div>
                                                <input type="radio" value="3" name="rating">
                                            </div>
                                            <div class="opt">
                                                <div class="starss">
                                                    <i class="las la-star"></i>
                                                    <i class="las la-star"></i>
                                                    <i class="lar la-star"></i>
                                                    <i class="lar la-star"></i>
                                                    <i class="lar la-star"></i>
                                                </div>
                                                <input type="radio" value="2" name="rating">
                                            </div>
                                            <div class="opt">
                                                <div class="starss">
                                                    <i class="las la-star"></i>
                                                    <i class="lar la-star"></i>
                                                    <i class="lar la-star"></i>
                                                    <i class="lar la-star"></i>
                                                    <i class="lar la-star"></i>
                                                </div>
                                                <input type="radio" value="1" name="rating">
                                            </div>
                                            <div class="opt">
                                                <div class="starss">
                                                    <i class="lar la-star"></i>
                                                    <i class="lar la-star"></i>
                                                    <i class="lar la-star"></i>
                                                    <i class="lar la-star"></i>
                                                    <i class="lar la-star"></i>
                                                </div>
                                                <input type="radio" value="0" name="rating">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="star-filters">
                                    <div class="stars-f">
                                        <i class="las la-sort-amount-down"></i>
                                        <span>Sort by</span>
                                        <i class="las la-angle-down"></i>
                                    </div>
                                    <div class="stars-opt">
                                        <div class="f-header">
                                            <h3>Sort by</h3>
                                            <a href="javascript:void()" class="remove"><i class="las la-times"></i></a>
                                        </div>
                                        <div class="f-body">
                                            <div class="opt d-none">
                                                <div class="starss">
                                                    <label for="so1">Relevance</label>
                                                </div>
                                                <input type="radio" value="relevance" name="sort_by" id="so1">
                                            </div>
                                            <div class="opt">
                                                <div class="starss">
                                                    <label for="so2">Latest - Oldest</label>
                                                </div>
                                                <input type="radio" value="latest" name="sort_by" id="so2">
                                            </div>
                                            <div class="opt">
                                                <div class="starss">
                                                    <label for="so3">Oldest - Latest</label>
                                                </div>
                                                <input type="radio" value="oldest" name="sort_by" id="so3">
                                            </div>
                                            <div class="opt d-none">
                                                <div class="starss">
                                                    <label for="so4">Most Viewed</label>
                                                </div>
                                                <input type="radio" name="sort_by" id="so4">
                                            </div>
                                            <div class="opt">
                                                <div class="starss">
                                                    <label for="so5">Most Booked</label>
                                                </div>
                                                <input type="radio" value="most_booked" name="sort_by" id="so5">
                                            </div>
                                            <div class="opt">
                                                <div class="starss">
                                                    <label for="so6">Alphabetically A-Z</label>
                                                </div>
                                                <input type="radio" value="A-Z" name="sort_by" id="so6">
                                            </div>
                                            <div class="opt">
                                                <div class="starss">
                                                    <label for="so7">Alphabetically Z-A</label>
                                                </div>
                                                <input type="radio" value="Z-A" name="sort_by" id="so7">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                      
                        
                          <div class="cat-name">
                        <?php
                        if (isset($category) && !empty($category)) {
                        ?>
                            <div class="cat-name">
                                <?php
                                foreach ($category as $key => $value) {
                                ?>
                                    <div class="cat-name-box filter-category" data-id="<?php echo $value->id; ?>" <?php //other class active; 
                                                                ?>>
                                        <a href="javascript:void(0);"><img src="{{ $value->category_icon_url }}"></a>
                                        <p>{{ $value->category_name }}</p>
                                        <p class="d-none">{{ Str::limit($value->category_name, 12, '...') }}</p>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                        <div class="cat-list">
                            <div class="slick-carousels">
                                <div class="sec-vendor-list">  
                                    @include('discover-vendor-list')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('pageScript')
<script src="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.slick/1.4.1/slick.min.js"></script>
<script>
    $('#partydropdowns').on('click', function(event) {
        event.stopPropagation();
    });
    let items = document.querySelectorAll('#featureContainer .carousel .carousel-item');
    items.forEach((el) => {
        const minPerSlide = 3
        let next = el.nextElementSibling
        for (var i = 1; i < minPerSlide; i++) {
            if (!next) {
                next = items[0]
            }
            let cloneChild = next.cloneNode(true)
            el.appendChild(cloneChild.children[0])
            next = next.nextElementSibling
        }
    })
    $(document).ready(function() {
        
     $('#search').on('keydown', function(e) {
        if (e.keyCode === 8) {  
           $('.btn-filter').trigger('click');
        } else {
            $('.btn-filter').trigger('click');
        }
    });
        
        
        $(document).on('click', '.clear-btn-filter', function () {
            var locationFilterIgnore = $(this).data('ignore');
            $.ajax({
                url: '/update-location-filter',
                method: 'POST',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'location_filter_ignore': locationFilterIgnore
                },
                success: function (response) {
                    if (response.status) {
                         
                        window.location = BASE_URL.replace(' ','');
                    }
                }
            });
        });
      
        
        $('#featureCarousel').carousel({
            interval: 1000 * 10
        });
        $('#featureCarousel').carousel('pause');

       

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
                        required: "Please enter category."
                    },
                }
            });

            $('[name="create-event"]').submit(function() {
                $('.validation-message,.success-message').remove();
                if ($('[name="create-event"]').valid()) {
                    $('[type="submit"]').attr('disabled', 'disabled');
                    $('[type="submit"]').find('.spinner-border').removeClass('d-none');
                    var current = $('[name="create-event"]');
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.btn-view-event-detail', function() {
            var current = $(this);
            current.attr('disabled', 'disabled');
            current.find('.spinner-border').removeClass('d-none');
            $.ajax({
                url: current.attr('data-url'),
                method: 'POST',
                data: {
                    'id': current.attr('data-id')
                },
                dataType: 'json',
                success: function(response) {
                    current.removeAttr('disabled');
                    current.find('.spinner-border').addClass('d-none');
                    if (response.status) {
                        $('.sec-event-deail').html(response.data.html);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(response) {
                    current.removeAttr('disabled');
                    current.find('.spinner-border').addClass('d-none');
                    if (typeof response.responseJSON.errors != undefined) {
                        $.each(response.responseJSON.errors, function(input, error) {
                            alert(error);
                        });
                    }
                }
            });
        });


        $(document).on('click', '.btn-view-vendor-detail', function() {
            var current = $(this);
            current.attr('disabled', 'disabled');
            current.find('.spinner-border').removeClass('d-none');
            $.ajax({
                url: current.attr('data-url'),
                method: 'POST',
                data: {
                    'id': current.attr('data-id')
                },
                dataType: 'json',
                success: function(response) {
                    current.removeAttr('disabled');
                    current.find('.spinner-border').addClass('d-none');
                    if (response.status) {
                        $('.sec-event-deail').html(response.data.html);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(response) {
                    current.removeAttr('disabled');
                    current.find('.spinner-border').addClass('d-none');
                    if (typeof response.responseJSON.errors != undefined) {
                        $.each(response.responseJSON.errors, function(input, error) {
                            alert(error);
                        });
                    }
                }
            });
        });

        $('.slick-home').slick({
            arrows: false,
            centerPadding: "0px",
            dots: true,
            infinite: true,
            slidesToShow: 3,
            autoplay: 1000,
            interval: 1000,
            centerMode: true,
            responsive: [{
                    breakpoint: 1440,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 1367,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 1,
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



        $(document).on('click', '.btn-open-event-action', function() {
            var current = $(this);
            $('.event-action-modal').find('[data-id]').attr('data-id', current.attr('data-id'));
            $('.event-action-modal').modal('show');
        });

        $(document).on('click', '.btn-delete-event', function() {
            var current = $(this);
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure want to delete party?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-success',
                        action: function() {
                            $('#cover-spin').show();
                            $.ajax({
                                url: current.attr('data-href'),
                                type: 'POST',
                                data: {
                                    'id': current.attr('data-id'),
                                },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status) {
                                        toastr.success(response.message);
                                        setTimeout(function() {
                                            window.location = window
                                                .location.href;
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

        $(document).on('click', '.btn-edit-event', function() {
            var current = $(this);
            $('#cover-spin').show();
            $.ajax({
                url: current.attr('data-href'),
                type: 'POST',
                data: {
                    'id': current.attr('data-id'),
                    'action': 'detail'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        $('#bookingopt').modal('hide');
                        $('#organizeparty').find('[name="id"]').val(response.data
                            .event_detail.id);
                        $('#organizeparty').find('[name="title"]').val(response.data
                            .event_detail.event_title);
                        $('#organizeparty').find('[name="location"]').val(response.data
                            .event_detail.event_location);
                        $('#organizeparty').find('[name="event_date"]').val(response.data
                            .event_detail.event_date);
                        $('#organizeparty').find('[name="category"]').val(response.data
                            .event_detail.event_category);
                        $('#organizeparty').modal('show');
                    } else {
                        toastr.error(response.message);
                    }
                    $('#cover-spin').hide();
                }
            });
        });

      
    });
    $('.stars-f').click(function() {
        $('.star-filters').removeClass('show');
        $(this).parents('.star-filters').toggleClass('show');
    });
    $('.remove').click(function() {
        
        $(this).parents('.star-filters').toggleClass('show');
    });
    
    document.querySelector('.remove').addEventListener('click', function() {
            const radios = document.querySelectorAll('.stars-opt input[type="radio"]');
            radios.forEach(radio => {
                radio.checked = false;
            });
        });
</script>
@endsection
@section('pageScriptlinks')
<script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/page/auth.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/discover.js') }}"></script>
@endsection