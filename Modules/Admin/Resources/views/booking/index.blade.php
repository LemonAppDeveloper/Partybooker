@extends('layouts.admin.app')
@section('pageStyles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
    <style>
        div#usermanage table#example1 {
            min-width: 1800px!important;
            overflow: auto;
        }
        div#usermanage table#example1 tr td span.active{
            font-weight: 500;
            color: #04D833;
        }
        div#usermanage table#example1 tr td span.inactive{
            color: var(--text-color-light);
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-12">
                    <div class="bookingpage">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home">Booking Management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#menu1">Pay Out</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#menu2">Paid</a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane container active" id="home">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="order-derails">
                                            @include('admin::booking-management')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane container fade" id="menu1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="order-derails">
                                            @include('admin::ready-to-pay')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane container fade" id="menu2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="order-derails">
                                            @include('admin::paid')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="sec-booking-info bookingsidebar">

                    </div>
                </div>
            </div>
        </div>
        <div> 
            @include('layouts.vendor.modal-profile')

            @include('layouts.vendor.modal-settings')
        @endsection
        @section('pageScript')
            <script src="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
            </script>
            <script type="text/javascript" src="{{ asset('admin-assets/js/booking.js') }}"></script>
            <script>
            
              $(document).on('click', '.mark-as-paid', function() {
        var current = $(this);
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure want to ' + current.attr('data-title') + ' this booking ?',
            buttons: {
                confirm: {
                    btnClass: 'btn-success',
                    action: function() {
                        $('#cover-spin').show();
                        $.ajax({
                            url: current.attr('data-url'),
                            type: 'POST',
                            data: {
                                '_token': $('meta[name="csrf-token"]').attr('content'),
                                'id': current.attr('data-id'),
                                'status': current.attr('data-status'),
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status) {
                                    toastr.success(response.message);
                                    setTimeout(function() {
                                        window.location = window.location.href;
                                    }, 1000);
                                } else {
                                    $('#cover-spin').hide();
                                    toastr.error(response.message);
                                }
                            }
                        });
                    }
                },
                cancel: function() {}
            }
        });
    }); 
    
                $('#example1').dataTable({
                    "order": []
                });
                
                $('#example2').dataTable({
                    "order": []
                });
            
                $('#example1').on('click', 'tr', function() {
                    var $row = $(this),
                    isSelected = $row.hasClass('selected')
                    $row.toggleClass('selected').find(':checkbox').prop('checked', !isSelected);
                });
                
                $('#example2').on('click', 'tr', function() {
                    var $row = $(this),
                    isSelected = $row.hasClass('selected')
                    $row.toggleClass('selected').find(':checkbox').prop('checked', !isSelected);
                });
            
                $("#selectAll, #unselectAll").on("click", function() {
                    var selectAll = this.id === 'selectAll';
                    $("#example1 tr :checkbox").prop('checked', selectAll);
                });
                
                $("#selectAll, #unselectAll").on("click", function() {
                    var selectAll = this.id === 'selectAll';
                    $("#example2 tr :checkbox").prop('checked', selectAll);
                });
            </script>
        @endsection
