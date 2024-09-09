@extends('layouts.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
@endsection
@section('content')
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="organize-party">
                <div class="heading">
                    <h3>Start organizing your party! </h3>
                    <p>We'll help you set up your best party!</p>
                </div>
                <a href="#" data-bs-toggle="modal" data-bs-target="#organizeparty">Organize Party</a>
            </div>
        </div>
    </div>
</div>
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="all-settings mt-4">
                <span>Parties</span>
                <a href="{{ route('party-planned') }}">Planned Parties <i class="las la-arrow-right"></i></a>
                <a href="{{ route('party-previous') }}">Previous Parties <i class="las la-arrow-right"></i></a>
                <a href="{{ route('favorite-list') }}">Favourites <i class="las la-arrow-right"></i></a>
            </div>
            <div class="all-settings d-none">
                <span>Payments</span>
                <a href="cards.html">Debit & Credit Cards <i class="las la-arrow-right"></i></a>
                <a href="e-wallet.html">E-Wallet <i class="las la-arrow-right"></i></a>
            </div>
            <div class="all-settings">
                <span>Settings</span>
                <a href="{{route('notification')}}">Notifications <i class="las la-arrow-right"></i></a>
                <a class="d-none" href="help-center.html">Help Center <i class="las la-arrow-right"></i></a>
                <a class="d-none" href="about.html">About <i class="las la-arrow-right"></i></a>
            </div>

            <div class="all-settings logouts">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out <i class="las la-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

@endsection
@section('pageScript')
<script src="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.slick/1.4.1/slick.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/js/script.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/page/auth.js')}}"></script>
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
</script>
@endsection
@section('pageScriptlinks')
<script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/page/auth.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/discover.js') }}"></script>
@endsection