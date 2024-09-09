$(document).ready(function () {

    $(document).on('click', '.quantity-minus', function () {
        var quantity = parseInt($(this).next('[name="quantity[]"]').val());
        if (quantity > 1) {
            $(this).next('[name="quantity[]"]').val(quantity - 1);
        }
    });

    $(document).on('click', '.quantity-plus', function () {
        var quantity = parseInt($(this).prev('[name="quantity[]"]').val());
        $(this).prev('[name="quantity[]"]').val(quantity + 1);
    });

    var clone_attribute = $('.clone-main-attribute').find('.clone-sub-attribute:first').clone();
    clone_attribute.find('[name="attribute_name[]"]').val('');
    clone_attribute.find('[name="quantity[]"]').val(1);
    $(document).on('click', '.add-attribute-clone-sec', function () {
        if ($.find('.clone-sub-attribute').length <= 50 && is_valid_clone_attribute()) {
            var clone_attribute2 = clone_attribute.clone();
            $('.clone-main-attribute').append(clone_attribute2);
        }
    });

    $(document).on('click', '.remove-attribute-clone-sec', function () {
        if ($.find('.clone-sub-attribute').length > 1) {
            $('.clone-sub-attribute:last').remove();
        } else {
            //toastr.error('Please keep at least one record.');
        }
    });

    function is_valid_clone_attribute() {
        var is_valid = true;
        $('.custom-validation-message').remove();
        $('.clone-sub-attribute').each(function () {
            $(this).find('.custom-required').each(function () {
                if ($.trim($(this).val()) == '') {
                    $(this).addClass('border-danger');
                    $(this).focus();
                    //$('<p class="text-danger custom-validation-message">This field is required.</p>').insertAfter($(this));
                    toastr.remove();
                    toastr.error('Please enter offer.');
                    is_valid = false;
                    return false;
                }
            });
        });
        return is_valid;
    }

    $(document).on('click', '.btn-update-vendor', function () {
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure want to save the profile?',
            buttons: {
                confirm: {
                    btnClass: 'btn-success',
                    action: function () {
                        $('#cover-spin').show();
                        var current = $('[name="update-vendor-description"]');
                        var formData = new FormData($('[name="update-vendor-description"]')[0]);

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
                                        $('<p class="text-danger validation-message">' + error[0] + '</p>').insertAfter($('[name="update-vendor-description"]').find('[name="' + input + '"]'));
                                    });
                                }
                            }
                        });
                    }
                },
                cancel: function () { }
            }
        });
    });
});