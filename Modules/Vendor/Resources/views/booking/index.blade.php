@extends('layouts.vendor.app')
@section('pageStyles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
@endsection
@section('content')
    <link rel='stylesheet' href='https://fullcalendar.io/js/fullcalendar-3.4.0/fullcalendar.min.css'>
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="order-derails">
                        @include('vendor::order-list')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="sec-booking-info">

                    </div>
                    <div class="widget profile-widget">
                        <?php
                        $path = asset('vendor-assets/images/profile.png');
                        if (Auth::user()->profile_image != '') {
                            $path = asset('uploads/profile/' . Auth::user()->profile_image);
                        }
                        ?>
                        <img src="{{ $path }}" alt="profile" class="mw-100">
                        <p class="pname">Your Calendar</p>
                        <form>
                            <div id="calendar" style="display: none;">
                                <div id="calendar_header">
                                    <i class="icon-chevron-left las la-angle-left"></i>
                                    <h1></h1><i class="icon-chevron-right las la-angle-right"></i>
                                </div>
                                <div id="calendar_weekdays"></div>
                                <div id="calendar_content"></div>
                            </div>
                            <a href="{{route('my-schedule')}}" id="modelopen-blocked" class="view-all-review">View my Schedule</a>
                        </form>
                    </div>

                    <div class="vendor-details pending-approvals-widget" style="display: none;">
                        <div class="vdt-head">
                            <h3>Pending Approvals</h3>
                        </div>
                        <div class="vdt-overview">
                            <p class="date">Aug 25-Sept 25 <i class="las la-angle-down"></i></p>
                            <h4>John Doe</h4>
                            <p>My Wedding Party!</p>
                        </div>
                        <div class="vdt-featured-p">
                            <div class="pkg">
                                <span>856 E 23rd St Loveland, Colorado..</span>
                                <span>Aug 23 - Aug 24 | 9:00AM-6:00PM</span>
                                <p><i class="las la-credit-card"></i>$450</p>
                            </div>
                            <a href="javascript:void(0);" class="view-all-review">View Complete Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="calender-model">
                <div class="modal-header">
                    <h5 class="modal-title" id="schedulesModalLabel">My Schedule</h5>
                    <a href="javascript:void(0);" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="las la-times"></i></a>
                </div>
                <div class="modal-body cal-list">
                    <div class="list-details">
                        <div class="list-header">
                            <h3>February 17 <br><span>Thursday,</span></h3>
                            <div class="time-filter">
                                <span>Time Availability:</span>
                                <p>From: <span>9:00AM</span> <i class="las la-angle-down"></i></p>
                                <p>To: <span>9:00AM</span> <i class="las la-angle-down"></i></p>
                            </div>
                        </div>
                        <div class="list-search">
                            <div class="input-group">
                                <span class="input-group-append input-group-addon">
                                    <span class="input-group-text"><i class="las la-search"></i></span>
                                </span>
                                <input type="text" name="search" class="form-control" placeholder="Search">
                            </div>
                            <div class="input-group">
                                <span class="input-group-append input-group-addon">
                                    <span class="input-group-text"><i class="las la-filter"></i></span>
                                </span>
                                <select class="form-control">
                                    <option>All</option>
                                </select>
                            </div>
                        </div>
                        <div class="todo-list">
                            <div id="calendarfull"></div>
                        </div>
                    </div>
                    <div class="list-calender">
                        <img src="{{ asset('vendor-assets/images/calendar.png') }}" style="max-width: 100%;">
                        <a href="javascript:void(0);" class="view-all-review">Export Schedule</a>
                        <hr>
                        <h3>Your Time Schedule</h3>
                        <p class="add-new-schedule"><i class="las la-plus"></i> Add new schedule</p>
                        <div class="listing-view">

                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="addSchedule" tabindex="-1" aria-labelledby="editproLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editproLabel">Add New Schedule</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Title</p>
                            <form class="add-sechedule" onsubmit="return false;">
                                @csrf
                                <input type="hidden" name="id" value="" />
                                <input type="text" name="title" class="form-control mb-4"
                                    placeholder="Add a title of the event">

                                <div class="form-group input-group date" id="datepicker">
                                    <span class="input-group-append input-group-addon">
                                        <span class="input-group-text"><i class="las la-calendar"></i></span>
                                    </span>
                                    <input class="form-control" name="from_date" placeholder="MM/DD/YYYY">
                                </div>
                                <div class="input-group date" id="datepicker_to">
                                    <span class="input-group-append input-group-addon">
                                        <span class="input-group-text"><i class="las la-calendar"></i></span>
                                    </span>
                                    <input class="form-control" name="to_date" placeholder="MM/DD/YYYY">
                                </div>
                                <div class="input-group date" id="timepicker">
                                    <span class="input-group-append input-group-addon">
                                        <span class="input-group-text"><i class="las la-calendar"></i></span>
                                    </span>
                                    <input class="form-control" name="from_time" placeholder="HH:MM">
                                </div>
                                <div class="input-group date" id="timepicker_to">
                                    <span class="input-group-append input-group-addon">
                                        <span class="input-group-text"><i class="las la-calendar"></i></span>
                                    </span>
                                    <input class="form-control" name="to_time" placeholder="HH:MM">
                                </div>

                                <button type="submit" class="btn btn-gradient"><span
                                        class="spinner-border spinner-border-sm d-none" role="status"
                                        aria-hidden="true"></span> Create</button>
                            </form>
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
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
            </script>
            <script type="text/javascript" src="{{ asset('vendor-assets/js/script.js') }}"></script>
            <script type="text/javascript" src="{{ asset('vendor-assets/js/booking.js') }}"></script>


            <script type="text/javascript">
                $(document).ready(function() {

                    function get_listing(url = '') {
                        console.log('listing call');

                        if (url == '') {
                            url = '{{ route('sechedule-list') }}';
                        }
                        $.ajax({
                            url: url,
                            method: 'GET',

                            dataType: 'json',
                            success: function(response) {

                                $('.listing-view').html(response.data);
                            }
                        });
                    }
                    get_listing();

                    $('#modelopen').click(function() {
                        $('.calender-model').addClass('open-model');
                    });
                    $('a.close').click(function() {
                        $('.calender-model').removeClass('open-model');
                    });

                    $('#modelopen').click(function() {
                        $('.calender-model').addClass('open-model');
                    });
                    $('a.close').click(function() {
                        $('.calender-model').removeClass('open-model');
                    });

                    function openModal() {
                        $('#addSchedule').modal('show');
                    }

                    $('.add-new-schedule').on('click', function() {
                        openModal();
                    });



                    var todayDate = moment().startOf('day');
                    var YM = todayDate.format('YYYY-MM');
                    var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
                    var TODAY = todayDate.format('YYYY-MM-DD');
                    var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');
                    var cal = $('#calendarfull').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay,listWeek'
                        },
                        editable: true,
                        defaultView: 'month',
                        eventLimit: 0, // allow "more" link when too many events
                        navLinks: true,
                        events: <?php echo json_encode($calendar_event); ?>
                            
                            ,
                        dayRender: function(a) {
                        }
                    });

                    $('.add-sechedule').validate({
                        rules: {
                            title: {
                                required: true
                            },
                            from_date: {
                                required: true
                            },
                            to_date: {
                                required: true
                            },
                            from_time: {
                                required: true
                            },
                            to_time: {
                                required: true
                            },

                        },
                        messages: {
                            title: {
                                required: "Please enter title."
                            },
                            from_date: {
                                required: "Please enter date."
                            },
                            to_date: {
                                required: "Please enter to date."
                            },
                            from_time: {
                                required: "Please enter time."
                            },
                            to_time: {
                                required: "Please enter to time."
                            },

                        }
                    });
                    $('.add-sechedule').submit(function(e) {
                        $form = $('.add-sechedule');
                        e.preventDefault();
                        if ($('.add-sechedule').valid()) {
                            $.ajax({
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                url: '{{ route('add.sechedule') }}',
                                type: 'POST',
                                data: new FormData($form[0]),
                                contentType: false,
                                cache: false,
                                processData: false,
                                dataType: 'json',
                                success: function(response) {

                                    if (response.status) {
                                        toastr.success(response.message);
                                        get_listing();
                                        $('[name="title"]').val('');
                                        $('[name="from_date"]').val('');
                                        $('[name="to_date"]').val('');
                                        $('[name="from_time"]').val('');
                                        $('[name="to_time"]').val('');

                                        $('#addSchedule').modal('hide');
                                    } else {
                                        if (typeof response.message == 'object') {
                                            $.each(response.message, function(input, message) {
                                                $('<label class="error">' + message + '<label>')
                                                    .insertAfter($('[name="' + input + '"]'));
                                            });
                                        } else {
                                            toastr.error(response.message);
                                        }
                                    }
                                }
                            });
                        }
                    });

                });
            </script>
        @endsection
