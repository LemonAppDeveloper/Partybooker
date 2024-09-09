$(document).ready(function () {

    $('[name="filter_by"]').change(function () {
        get_plan_list();
    });
    $('[name="is_enable"]').change(function () {
        get_plan_list();
    });

    function get_plan_list() {
        var $form = $('[name="form-filter-plan"]');
        $('#cover-spin').show();
        $('.sec-plan-list').html('');
        $.ajax({
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            url: $form.attr('action'),
            type: 'POST',
            data: new FormData($form[0]),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    $('.sec-plan-list').html(response.data.html);
                } else {
                    $.each(response.message, function (input, error) {
                        $('<small class="text-danger validation-message small">' + error + '</small>').insertAfter($('[name="' + input + '"]'));
                    });
                }
            },
            error: function (response) {
                $('.btn-add-update-plan').find('.spinner-border').addClass('d-none');
                $('.btn-add-update-plan').removeAttr('disabled');
                var data = JSON.parse(response.responseText);
                if (typeof data.errors != undefined) {
                    $.each(data.errors, function (input, error) {
                        $('<p class="text-danger validation-message small">' + error + '</p>').insertAfter($('[name="' + input + '"]'));
                    });
                }
            }
        });
    }
    get_plan_list();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.delete-plan', function () {
        var current = $(this);
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure want to charge customer?',
            buttons: {
                confirm: {
                    btnClass: 'btn-success',
                    action: function () {
                        $('#cover-spin').show();
                        $.ajax({
                            url: current.attr('data-url'),
                            type: 'POST',
                            data: {
                                'id': current.attr('data-id'),
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response.status) {
                                    toastr.success(response.message);
                                    get_plan_list();
                                } else {
                                    toastr.error(response.message);
                                }
                                $('#cover-spin').hide();
                            }
                        });
                    }
                },
                cancel: function () {
                }
            }
        });
    });
});