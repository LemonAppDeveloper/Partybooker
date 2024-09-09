@extends('layouts.vendor.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-date-range-picker/daterangepicker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui-1.13.2/jquery-ui.min.css') }}">
@endsection
@section('content')
<link rel='stylesheet' href='https://fullcalendar.io/js/fullcalendar-3.4.0/fullcalendar.min.css'>
<style>
    .date-picker-wrapper {
        z-index: 9999;
    }

    #from_date-container {
        width: 100%;
    }

    .date-picker-wrapper,
    .date-picker-wrapper.no-topbar,
    .date-picker-wrapper.no-shortcuts {
        padding: 0px;
    }

    .date-picker-wrapper .month-wrapper {
        border: none;
        padding: 0px;
    }

    .month-wrapper {
        width: 100% !important;
    }

    .date-picker-wrapper .month-wrapper table {
        width: 100%;
    }

    .calender-schedule .ui-widget-header {
        border: none;
        background: #fff;
    }

    .calender-schedule .ui-widget.ui-widget-content {
        border: none;
    }

    .calender-schedule .ui-state-default,
    .calender-schedule .ui-widget-content .ui-state-default {
        border: none;
        background: #fff;
        text-align: center;
        font-size: 20px;
    }

    .ui-state-active,
    .ui-widget-content .ui-state-active {
        color: #000;
    }
    .ui-state-default, .ui-widget-content .ui-state-default {color:#FB8547;}
    .ui-state-disabled  .ui-state-default{color:#212529;}
</style>
<div class="row mb-5">
    <div class="col-md-12">
        <div class="pheading">
            <h2><a href="{{route('dashboard')}}"><i class="las la-arrow-left"></i></a> Settings</h2>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 bg-white p-3 rounded-3">
        <div class="list-details">
            <div class="list-header">
                <h3>My Schedule<br><span class="d-none">Thursday,</span></h3>
                <div class="time-filter d-none">
                    <span>Time Availability:</span>
                    <p>From: <span>9:00AM</span> <i class="las la-angle-down"></i></p>
                    <p>To: <span>9:00AM</span> <i class="las la-angle-down"></i></p>
                </div>
            </div>
            <div class="list-search d-none">
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
            <div id="datepicker" class="calender-schedule"></div>
            <a href="javascript:void(0);" class="view-all-review d-none">Export Schedule</a>
            <hr>
            <h3>Your Time Schedule</h3>
            <p class="add-new-schedule"><i class="las la-plus"></i> Add new schedule</p>
            <div class="listing-view">
            </div>
        </div>
    </div>
    <br />
    <br /><br /><br />
</div>

<div class="modal fade" id="addSchedule" tabindex="-1" aria-labelledby="editproLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="max-width: 400px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editproLabel">Add New Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="add-sechedule" onsubmit="return false;">
                    @csrf
                    <input type="hidden" name="id" value="" />
                    <input type="text" name="title" class="form-control mb-4" placeholder="Schedule Name">

                    <div class="row">
                        <div class="col-6">
                            <select name="from_time" class="form-control">
                                <option value="">Start Time</option>
                                <?php
                                for ($i = 0; $i <= 23; $i++) {
                                    $time = str_pad($i, 2, 0, STR_PAD_LEFT) . ':00:00';
                                    echo '<option value="' . $time . '">' . $time . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <select name="to_time" class="form-control">
                                <option value="">End Time</option>
                                <?php
                                for ($i = 0; $i <= 23; $i++) {
                                    $time = str_pad($i, 2, 0, STR_PAD_LEFT) . ':00:00';
                                    echo '<option value="' . $time . '">' . $time . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 text-center">
                            <input class="form-control" name="from_date" id="from_date" style="display: none;" placeholder="MM/DD/YYYY">
                            <div id="from_date-container"></div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gradient"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Create</button>
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
<script src="{{ asset('assets/plugins/jquery-date-range-picker/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-ui-1.13.2/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-date-range-picker/jquery.daterangepicker.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('vendor-assets/js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor-assets/js/booking.js') }}"></script>


<script type="text/javascript">
    $(document).ready(function() {

        var disabled_dates = {!! json_encode(array_values($available_dates)) !!};
       
        var configObject = {
            inline: true,
            container: '#from_date-container',
            alwaysOpen: true,
            singleMonth: true,
            showShortcuts: false,
            showTopbar: false
        };
        $('#from_date').dateRangePicker(configObject);
        $("#datepicker").datepicker({
            beforeShowDay: function(date) {
                if (disabled_dates.length > 0) {
                    yr = date.getFullYear();
                    month = date.getMonth() + 1;
                    month = month < 10 ? '0' + month : month;
                    day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
                    y_m_d = yr + '-' + month + '-' + day;
                    if ($.inArray(y_m_d,disabled_dates) != -1) {
                        return [true, "", "Available"];
                    } else {
                        return [false, "", "unAvailable"];
                    }
                } else {
                    return [true, "", "Available"];
                }
            }
        });

        function get_listing(url = '') {
            if (url == '') {
                url = "{{ route('sechedule-list') }}";
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
            $('#addSchedule').find('[name="id"]').val('');
            $('#addSchedule').find('[name="from_date"]').val('');
            $('#addSchedule').find('[name="from_time"]').val('');
            $('#addSchedule').find('[name="to_time"]').val('');
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
            errorPlacement: function(error, element) {
                toastr.error(error);
            },
            rules: {
                title: {
                    required: true
                },
                from_date: {
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
                $('#cover-spin').show();
                $.ajax({
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    url: "{{ route('add.sechedule') }}",
                    type: 'POST',
                    data: new FormData($form[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        $('#cover-spin').hide();
                        if (response.status) {
                            toastr.success(response.message);
                            get_listing();
                            $('[name="title"]').val('');
                            $('[name="from_date"]').val('');
                            $('[name="from_time"]').val('');
                            $('[name="to_time"]').val('');

                            $('#addSchedule').modal('hide');
                        } else {
                            if (typeof response.message == 'object') {
                                $.each(response.message, function(input, message) {
                                    toastr.error(message);
                                });
                            } else {
                                toastr.error(response.message);
                            }
                        }
                    }
                });
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.edit-schedule', function() {
            var current = $(this);
            var detail = JSON.parse(atob(current.attr('data-detail')));
            $('#addSchedule').find('[name="id"]').val(detail.id);
            $('#addSchedule').find('[name="from_date"]').val(detail.from_date + ' to ' + detail.to_date);
            $('#addSchedule').find('[name="from_time"]').val(detail.from_time);
            $('#addSchedule').find('[name="to_time"]').val(detail.to_time);
            $('#addSchedule').find('[name="title"]').val(detail.title);
            $('#from_date').data('dateRangePicker').setDateRange(detail.from_date, detail.to_date);
            $('#addSchedule').modal('show');
        });

        $(document).on('click', '.make-default-time', function() {
            $('#cover-spin').show();
            var current = $(this);
            $.ajax({
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                url: "{{ route('make-default-time') }}",
                type: 'POST',
                data: {
                    'id': current.attr('data-id')
                },
                dataType: 'json',
                success: function(response) {
                    $('#cover-spin').hide();
                    if (response.status) {
                        $('.working-hours').addClass('inactive');
                        current.closest('.working-hours').removeClass('inactive');
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
        });
    });
</script>
@endsection