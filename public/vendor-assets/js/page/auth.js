$(document).ready(function () {
    if ($("#loginForm").length > 0) {
        $("#loginForm").validate({
            rules: {
                'email': {
                    required: true,
                    email: true,
                }
            },
            messages: {
                'email': {
                    required: "Please enter email address.",
                    email: "Please enter valid email address.",
                }
            }
        });
    }
    if ($("#registerForm").length > 0) {
        $("#registerForm").validate({
            errorPlacement: function (error, element) {
                if (element.attr("type") == "checkbox") {
                    error.insertAfter($(element).closest('div'));
                } else {
                    error.insertAfter(element);
                }
            },
            rules: {
                'name': {
                    required: true,
                    maxlength: 50
                },
                'email': {
                    required: true,
                    email: true,
                }
            },
            messages: {
                'name': {
                    required: "Please enter your full name.",
                    maxlength: "Your name cannot exceed 50 characters."
                },
                'email': {
                    required: "Please enter email address.",
                    email: "Please enter valid email address.",
                }
            }
        });
    }

    if ($("#forgot-password-form").length > 0) {
        $("#forgot-password-form").validate({
            rules: {
                'email': {
                    required: true,
                    email: true,
                }
            },
            messages: {
                'email': {
                    required: "Please enter email address.",
                    email: "Please enter valid email address.",
                }
            }
        });

        $("#forgot-password-form").submit(function () {
            $('.validation-message,.success-message').remove();
            if ($("#forgot-password-form").valid()) {
                $('[type="submit"]').attr('disabled', 'disabled');
                $('[type="submit"]').find('.spinner-border').removeClass('d-none');
                var current = $("#forgot-password-form");
                $.ajax({
                    url: current.attr('action'),
                    type: 'POST',
                    data: current.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        $('[type="submit"]').removeAttr('disabled');
                        $('[type="submit"]').find('.spinner-border').addClass('d-none');
                        if (response.status) {
                            $("#forgot-password-form").closest('.forgotpwd').hide();
                            $('.success-msg').removeClass('d-none');
                            $('<p class="text-success success-message">' + response.message + '</p>').insertBefore($('[name="email"]'));
                            $('[name="email"]').val('');
                            // setTimeout(function () {
                            //     $('.success-message').fadeOut();;
                            // }, 1000);
                        } else {
                            $.each(response.message, function (input, error) {
                                $('<small class="text-danger validation-message small">' + error + '</small>').insertAfter($('[name="' + input + '"]'));
                            });
                        }
                    },
                    error: function (response) {
                        $('[type="submit"]').removeAttr('disabled');
                        $('[type="submit"]').find('.spinner-border').addClass('d-none');
                        if (typeof response.responseJSON.errors != undefined) {
                            $.each(response.responseJSON.errors, function (input, error) {
                                $('<p class="text-danger validation-message small">' + error + '</p>').insertAfter($('[name="' + input + '"]'));
                            });
                        }
                    }
                });
            }
        });
    }

    if ($("#reset-password-form").length > 0) {
        $("#reset-password-form").validate({
            rules: {
                'email': {
                    required: true,
                    email: true,
                }
            },
            messages: {
                'email': {
                    required: "Please enter email address.",
                    email: "Please enter valid email address.",
                }
            }
        });

        $("#reset-password-form").submit(function () {
            $('.validation-message,.success-message').remove();
            if ($("#reset-password-form").valid()) {
                $('[type="submit"]').attr('disabled', 'disabled');
                $('[type="submit"]').find('.spinner-border').removeClass('d-none');
                var current = $("#reset-password-form");
                $.ajax({
                    url: current.attr('action'),
                    type: 'POST',
                    data: current.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            $('#reset-password-form').hide();
                            //$('<p class="text-success success-message">' + response.message + '</p>').insertBefore($('[name="password"]'));
                            $('.successmsg').removeClass('d-none');
                            $('.reset-password-sec').addClass('d-none');
                            setTimeout(function () {
                                window.location = window.location.href;
                            }, 1500);
                        } else {
                            $('[type="submit"]').removeAttr('disabled');
                            $('[type="submit"]').find('.spinner-border').addClass('d-none');
                            $.each(response.message, function (input, error) {
                                $('<small class="text-danger validation-message small">' + error + '</small>').insertAfter($('[name="' + input + '"]'));
                            });
                        }
                    },
                    error: function (response) {
                        $('[type="submit"]').removeAttr('disabled');
                        $('[type="submit"]').find('.spinner-border').addClass('d-none');
                        if (typeof response.responseJSON.errors != undefined) {
                            $.each(response.responseJSON.errors, function (input, error) {
                                $('<p class="text-danger validation-message small">' + error + '</p>').insertAfter($('[name="' + input + '"]'));
                            });
                        }
                    }
                });
            }
        });
    }

    $('.btn-update-profile').click(function () {
        $('.validation-message,.success-message').remove();
        $('.btn-update-profile').find('.spinner-border').removeClass('d-none');
        $('.btn-update-profile').attr('disabled', 'disabled');
        var current = $(this).closest('form');

        var formData = new FormData(current[0]);

        $.ajax({
            url: current.attr('action'),
            type: 'POST',
            //data: current.serialize(),
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            dataType: 'json',
            success: function (response) {
                $('.btn-update-profile').find('.spinner-border').addClass('d-none');
                $('.btn-update-profile').removeAttr('disabled');
                if (response.status) {
                    $('<p class="text-success success-message">' + response.message + '</p>').insertBefore($('.btn-update-profile'));
                    setTimeout(function () {
                        $('.success-message').fadeOut();;
                        window.location = window.location.href;
                    }, 1000);
                } else {
                     $('<p class="text-danger success-message">' + response.message + '</p>').insertBefore($('.btn-update-profile'));
                    $.each(response.message, function (input, error) {
                        $('<small class="text-danger validation-message small">' + error + '</small>').insertAfter($('[name="' + input + '"]'));
                    });
                }
            },
            error: function (response) {
                $('.btn-update-profile').find('.spinner-border').addClass('d-none');
                $('.btn-update-profile').removeAttr('disabled');
                if (typeof response.responseJSON.errors != undefined) {
                    $.each(response.responseJSON.errors, function (input, error) {
                        $('<p class="text-danger validation-message small">' + error + '</p>').insertAfter($('[name="' + input + '"]'));
                    });
                }
            }
        });
    });

    $('.btn-change-password').click(function () {
        $('.validation-message,.success-message').remove();
        $('.btn-change-password').find('.spinner-border').removeClass('d-none');
        $('.btn-change-password').attr('disabled', 'disabled');
        var current = $(this).closest('form');
        $.ajax({
            url: current.attr('action'),
            type: 'POST',
            data: current.serialize(),
            dataType: 'json',
            success: function (response) {
                $('.btn-change-password').find('.spinner-border').addClass('d-none');
                $('.btn-change-password').removeAttr('disabled');
                if (response.status) {
                    $('<p class="text-success success-message">' + response.message + '</p>').insertBefore($('.btn-change-password'));
                    setTimeout(function () {
                        $('.success-message').fadeOut();;
                    }, 1000);
                } else {
                    $.each(response.message, function (input, error) {
                        $('<small class="text-danger validation-message small">' + error + '</small>').insertAfter($('[name="' + input + '"]'));
                    });
                }
            },
            error: function (response) {
                $('.btn-change-password').find('.spinner-border').addClass('d-none');
                $('.btn-change-password').removeAttr('disabled');
                var data = JSON.parse(response.responseText);
                if (typeof data.errors != undefined) {
                    $.each(data.errors, function (input, error) {
                        $('<p class="text-danger validation-message small">' + error + '</p>').insertAfter($('[name="' + input + '"]'));
                    });
                }
            }
        });
    });

    $('.update-description').click(function () {
        $('.success-message').remove();
        $('.sec-update-description').removeClass('d-none');
    });

    $('.btn-update-description').click(function () {
        $('.validation-message,.success-message').remove();
        $('.btn-update-description').find('.spinner-border').removeClass('d-none');
        $('.btn-update-description').attr('disabled', 'disabled');
        var current = $(this).closest('form');

        var formData = new FormData(current[0]);

        $.ajax({
            url: current.attr('action'),
            type: 'POST',
            //data: current.serialize(),
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            dataType: 'json',
            success: function (response) {
                $('.btn-update-description').find('.spinner-border').addClass('d-none');
                $('.btn-update-description').removeAttr('disabled');
                if (response.status) {
                    $('<p class="text-success success-message">' + response.message + '</p>').insertBefore($('.btn-update-description'));
                    $('.sec-description p').html($('[name="description"]').val().replace(/\r?\n/g, '<br/>'));
                    $('.sec-update-description').addClass('d-none');
                    setTimeout(function () {
                        $('.success-message').fadeOut();;
                        // window.location = window.location.href;
                    }, 1000);
                } else {
                    $.each(response.message, function (input, error) {
                        $('<small class="text-danger validation-message small">' + error + '</small>').insertAfter($('[name="' + input + '"]'));
                    });
                }
            },
            error: function (response) {
                $('.btn-update-description').find('.spinner-border').addClass('d-none');
                $('.btn-update-description').removeAttr('disabled');
                var data = JSON.parse(response.responseText);
                if (typeof data.errors != undefined) {
                    $.each(data.errors, function (input, error) {
                        $('<p class="text-danger validation-message small">' + error + '</p>').insertAfter($('[name="' + input + '"]'));
                    });
                }
            }
        });
    });


    $(document).on('click', '.open-modal-addUpdatePlan', function () {
        $('.validation-message').remove();
        $('#modal-addUpdatePlan').find('[name="id"]').val('');
        $('#modal-addUpdatePlan').find('input,textarea').val('');
        $('#modal-addUpdatePlan').find('.modal-title').text('Add Update Plan');
        $('#modal-addUpdatePlan').modal('show');
    });

    $(document).on('click', '.edit-plan', function () {
        $('.validation-message').remove();
        var current = $(this);
        $('#cover-spin').show();
        var details = atob(current.attr('data-detail'));

        details = JSON.parse(details);
        $('#modal-addUpdatePlan').find('.modal-title').text('Edit Plan');
        $.each(details, function (key, value) {
            if (key == 'plan_image_url') {

            } else {
                $('#modal-addUpdatePlan').find('[name="' + key + '"]').val(value);
            }
        });
        $('label.error').remove();        
        $('#modal-addUpdatePlan').modal('show');
        $('#cover-spin').hide();
    });


    $('.btn-add-update-plan').click(function () {
        var $form = $('.btn-add-update-plan').closest('form');
        $('.btn-add-update-plan').find('.spinner-border').removeClass('d-none');
        $('.btn-add-update-plan').attr('disabled', 'disabled');
        $('#cover-spin').show();
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
                $('.btn-add-update-plan').find('.spinner-border').addClass('d-none');
                $('.btn-add-update-plan').removeAttr('disabled');
                if (response.status) {
                    $('<p class="text-success success-message">' + response.message + '</p>').insertBefore($('.btn-add-update-plan'));
                    $('.sec-description p').html($('[name="description"]').val().replace(/\r?\n/g, '<br/>'));
                    $('.sec-update-description').addClass('d-none');
                    setTimeout(function () {
                        //$('.success-message').fadeOut();;
                        window.location = window.location.href;
                    }, 2000);
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
    });
});