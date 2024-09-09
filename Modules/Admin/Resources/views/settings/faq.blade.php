@extends('layouts.admin.app')
@section('pageStyles')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="pheading" style="margin-bottom: 20px;">
                        <h2><a href="{{ route('admin.settings') }}"><i class="las la-arrow-left"></i></a> Faq Management</h2>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-secondary btn-green btn-add">Add New</button>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-8">
                    <div class="order-conf">
                        <h3 class="title form-title">Add New</h3>
                        <form action="{{ route('admin.settings.faq') }}" name="form-add" onsubmit="return false;">
                            @csrf
                            <input type="hidden" name="id" />
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <input type="text" name="question" placeholder="Question" class="form-control" />
                                </div>
                            </div>
                            <div class="massage-box mb-3">
                                <textarea id="answer" name="answer" class="form-control" placeholder="Answer"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="button" class="btn btn-green btn-submit"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="list-area">
                        <div class="listarea-heading">
                            <h2>FAQs</h2>
                            <a style="display: none;" href="javascript:void(0);">Add</a>
                        </div>
                        <div class="scroll-list">
                            <div class="faq-list">
                                <?php
                                echo view('admin::settings.faq-list', compact('data'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('pageScript')
<script src="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $(document).on('click', '.btn-select-template', function() {
            $('.form-title').text('Update');
            $('.btn-select-template').removeClass('active');
            var current = $(this);
            current.addClass('active');
            var detail = JSON.parse(atob(current.attr('data-detail')));
            $('[name="question"]').val(detail.question);
            $('[name="answer"]').val(detail.answer);
            $('[name="id"]').val(detail.id);
        });

        $('.btn-add').click(function() {
            $('.form-title').text('Add New');
            $('[name="question"]').val('');
            $('[name="answer"]').val('');
            $('[name="id"]').val('');
        });

        $(document).on('click', '.btn-delete-faq', function() {
            var current = $(this);
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure want to delete this question?',
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

        $('.btn-submit').click(function() {
            $('[name="form-add"]').submit();
        });

        $('[name="form-add"]').submit(function() {
            var current = $(this);
            $('.custom-validation-message').remove();
            $('.btn-submit').find('.spinner-border').removeClass('d-none');
            $('.btn-submit').attr('disabled', 'disabled');
            $.ajax({
                url: current.attr('action'),
                type: 'POST',
                data: $('[name="form-add"]').serialize(),
                dataType: 'json',
                success: function(response) {
                    $('.btn-submit').find('.spinner-border').addClass('d-none');
                    $('.btn-submit').removeAttr('disabled');
                    if (response.status) {
                        get_faq_listing($('[name="form-add"]').find('[name="id"]').val());
                        $('.btn-add').trigger('click');
                        toastr.success(response.message);
                    } else {
                        if (typeof response.message == 'object') {
                            $.each(response.message, function(index, message) {
                                $('<p class="text-danger custom-validation-message">' + message + '</p>').insertAfter('[name="' + input + '"]');
                            });
                        } else {
                            toastr.error(response.message);
                        }
                    }
                },
                error: function(reject) {
                    $('.btn-submit').find('.spinner-border').addClass('d-none');
                    $('.btn-submit').removeAttr('disabled');
                    if (reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);
                        $.each(errors.errors, function(input, val) {
                            $('<p class="text-danger custom-validation-message">' + val[0] + '</p>').insertAfter('[name="' + input + '"]');
                        });
                    }
                }
            });
        });

        function get_faq_listing(id) {
            $('#cover-spin').show();
            $.ajax({
                url: BASE_URL + '/settings/faq-list',
                type: 'GET',
                data: {
                    'action': 'list',
                    'id': id
                },
                dataType: 'json',
                success: function(response) {
                    $('#cover-spin').hide();
                    if (response.status) {
                        $('.faq-list').html(response.data.html);
                    } else {
                        if (typeof response.message == 'object') {
                            $.each(response.message, function(index, message) {
                                $('<p class="text-danger custom-validation-message">' + message + '</p>').insertAfter('[name="' + input + '"]');
                            });
                        } else {
                            toastr.error(response.message);
                        }
                    }
                },
                error: function(reject) {
                    $('#cover-spin').hide();
                    if (reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);
                        $.each(errors.errors, function(input, val) {
                            $('<p class="text-danger custom-validation-message">' + val[0] + '</p>').insertAfter('[name="' + input + '"]');
                        });
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

</script>
@endsection