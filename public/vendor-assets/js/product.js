$(document).ready(function () {

    var addProductModal = new bootstrap.Modal(document.getElementById("singleproduct"), {});

    $('.edit-product').click(function () {
        var current = $(this);
        $('#cover-spin').show();
        $.ajax({
            url: current.data('action'),
            type: 'POST',
            data: { 'id': current.attr('data-id') },
            dataType: 'json',
            success: function (response) {
                $('#cover-spin').hide();
                if (response.status) {
                    $('[name="add-update-product"]').html(response.data.html)
                } else {
                    $.each(response.message, function (input, error) {
                        toastr.success(error);
                    });
                }
                addProductModal.show();
            },
            error: function (response) {
                $('#cover-spin').hide();

                var response = JSON.parse(response.responseText);
                if (typeof response.errors != undefined) {
                    $.each(response.errors, function (input, error) {
                        $('<p class="text-danger validation-message">' + error[0] + '</p>').insertAfter($('[name="add-update-product"]').find('[name="' + input + '"]'));
                    });
                }
            }
        });
    });

    $('[name="add-update-product"]').submit(function (e) {
        e.preventDefault();
        $('#cover-spin').show();
        $('.validation-message,.success-message').remove();
        $('#file').find('.spinner-border').removeClass('d-none');
        $('#file').attr('disabled', 'disabled');

        var current = $('[name="add-update-product"]');
        var formData = new FormData($('[name="add-update-product"]')[0]);

        $.ajax({
            url: current.attr('action'),
            type: 'POST',
            //data: current.serialize(),
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            dataType: 'json',
            success: function (response) {
                $('#cover-spin').hide();
                $('#file').find('.spinner-border').addClass('d-none');
                $('#file').removeAttr('disabled');
                if (response.status) {
                    toastr.success(response.message);
                    setTimeout(function () {
                        $('.success-message').fadeOut();
                        window.location = window.location.href;
                    }, 1000);
                } else {
                    $.each(response.message, function (input, error) {
                        toastr.success(error);
                    });
                }
            },
            error: function (response) {
                $('#cover-spin').hide();
                $('#file').find('.spinner-border').addClass('d-none');
                $('#file').removeAttr('disabled');
                var response = JSON.parse(response.responseText);
                if (typeof response.errors != undefined) {
                    $.each(response.errors, function (input, error) {
                        $('<p class="text-danger validation-message">' + error[0] + '</p>').insertAfter($('[name="add-update-product"]').find('[name="' + input + '"]'));
                    });
                }
            }
        });
    });

    $(document).on('click', '.btn-remove-product-image', function () {
        var current = $(this);
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure want to delete image?',
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
                                    current.closest('figure').remove();
                                } else {
                                    toastr.error(response.message);
                                }
                                $('#cover-spin').hide();
                            }
                        });
                    }
                },
                cancel: function () { }
            }
        });
    });

    $(document).on('click', '[data-bs-target="#singleproduct"]', function () {
        $('[name="add-update-product"]').find('figure').not('.upload').remove();
        $('[name="add-update-product"]').find('input,select,textarea').val('');
        $('[name="add-update-product"]').find('[name="product_status"]').val(1);
    });

    $(document).on('click', '.btn-delete-product', function () {
        var current = $(this);
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure want to delete this product?',
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
                                    window.location = window.location.href;
                                } else {
                                    toastr.error(response.message);
                                }
                                $('#cover-spin').hide();
                            }
                        });
                    }
                },
                cancel: function () { }
            }
        });
    });

    $(document).on('click', '.refresh-page', function () {
        window.location = window.location.href;
    });
});