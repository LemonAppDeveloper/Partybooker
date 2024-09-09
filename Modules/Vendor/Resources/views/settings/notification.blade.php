@extends('layouts.vendor.app')
@section('pageStyles')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('vendor-assets/css/settings.css') }}" />
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="pheading" style="margin-bottom: 20px;">
                        <h2><a href="{{ route('vender.configration') }}"><i class="las la-arrow-left"></i></a> Notification Management</h2>
                    </div>
                </div>
                <div class="col-md-4 text-end d-none">
                    <button class="btn btn-green">Save Changes</button>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-8">
                    <div class="order-conf">
                        <h3 class="title">Update Template</h3>
                        <form action="{{ route('admin.settings.notification') }}" name="form-add" onsubmit="return false;">
                            @csrf
                            <input type="hidden" name="id" />
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <input type="text" name="subject" placeholder="Subject" class="form-control" />
                                </div>
                            </div>
                            <div class="massage-box mb-3">
                                <textarea id="email_content" name="email_content">
									<p>Hi, </p>
									<p>Thank you for your order</p>
									<p>Sample text here for order confirmation.</p>
								</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="button" class="btn btn-green btn-submit"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="order-conf mt-3 d-none">
                        <h3 class="title">Usable Keys</h3>
                        <div class="alert alert-info">
                            You can use following keys to bind the values dynamically in the email template.
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Key</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($data['keys'])) {
                                                foreach ($data['keys'] as $key => $description) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $key; ?></td>
                                                        <td><?php echo $description['description']; ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="order-list">
                        <h3>Notification List</h3>
                        <div class="notification-list">
                            <?php
                            echo view('admin::settings.notification-list', compact('data'));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('pageScript')
<script src="{{ asset('assets/plugins/ckeditor5/ckeditor.js') }}"></script>
<script>
    let editor;
    ClassicEditor.defaultConfig = {
        toolbar: {
            items: [
                'heading',
                '|',
                'bold',
                'italic',
                '|',
                'bulletedList',
                'numberedList',
                '|',
                'undo',
                'redo'
            ]
        },
        
        language: 'en'
    };

    ClassicEditor.create(document.querySelector('#email_content'))
        .then(newEditor  => {
            newEditor .ui.view.editable.element.style.minHeight = '400px'
            editor = newEditor;
        })
        .catch(error => {
            console.error(error);
        });

    $(document).ready(function() {

        $(document).on('click', '.btn-select-template', function() {
            $('.btn-select-template').removeClass('active');
            var current = $(this);
            current.addClass('active');
            var detail = JSON.parse(atob(current.attr('data-detail')));
            $('[name="subject"]').val(detail.subject);
            $('[name="id"]').val(detail.id);            
            editor.setData(detail.email_content);
        });
        setTimeout(function() {
            $('.btn-select-template:first').trigger('click');
        }, 500);

        $('.btn-submit').click(function() {            
            var content = editor.getData();
            $('#email_content').val(content);
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
                        get_notification_listing($('[name="form-add"]').find('[name="id"]').val());
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

        function get_notification_listing(id) {
            $('#cover-spin').show();
            $.ajax({
                url: '/vendor/configration/notification-list',
                type: 'GET',
                data: {
                    'action': 'list',
                    'id': id
                },
                dataType: 'json',
                success: function(response) {
                    $('#cover-spin').hide();
                    if (response.status) {
                        $('.notification-list').html(response.data.html);
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
</script>
@endsection