$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
                },
                'password': {
                    required: "Please enter password.",
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
                    method: 'POST',
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
                    method: 'POST',
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
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    $('<p class="text-success success-message">' + response.message + '</p>').insertBefore($('.btn-update-profile'));
                    $('.btn-update-profile').find('.spinner-border').addClass('d-none');
                    $('.btn-update-profile').removeAttr('disabled');
                    setTimeout(function () {
                        $('.success-message').fadeOut();
                        window.location = window.location.href;
                    }, 1000);
                } else {
                    $.each(response.message, function (input, error) {
                        $('<small class="text-danger validation-message small">' + error + '</small>').insertAfter($('[name="' + input + '"]'));
                    });
                }
            },
            error: function (response) {
                $('.btn-update-profile').find('.spinner-border').addClass('d-none');
                $('.btn-update-profile').removeAttr('disabled');
                var errors = JSON.parse(response.responseText);
                if (typeof errors.errors != undefined) {
                    $.each(errors.errors, function (input, error) {
                        $('<p class="text-danger mt-0 mb-0 validation-message small">' + error + '</p>').insertAfter($('[name="' + input + '"]'));
                    });
                }
            }
        });
    });

    $('.btn-change-password').click(function () {
        $('.validation-message,.success-message').remove();
        var current = $(this).closest('form');
        $('.btn-change-password').find('.spinner-border').removeClass('d-none');
        $('.btn-change-password').attr('disabled', 'disabled');
        $.ajax({
            url: current.attr('action'),
            type: 'POST',
            data: current.serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    $('<p class="text-success success-message">' + response.message + '</p>').insertBefore($('.btn-change-password'));
                    $('.btn-change-password').find('.spinner-border').addClass('d-none');
                    $('.btn-change-password').removeAttr('disabled');
                    setTimeout(function () {
                        $('.success-message').fadeOut();
                        window.location = window.location.href;
                    }, 1000);
                } else {
                    $.each(response.message, function (input, error) {
                        $('<small class="text-danger mt-0 mb-0 validation-message small">' + error + '</small>').insertAfter($('[name="' + input + '"]'));
                    });
                }
            },
            error: function (response) {
                $('.btn-change-password').find('.spinner-border').addClass('d-none');
                $('.btn-change-password').removeAttr('disabled');
                var errors = JSON.parse(response.responseText);
                if (typeof errors.errors != undefined) {
                    $.each(errors.errors, function (input, error) {
                        $('<p class="text-danger mt-0 mb-0 validation-message small">' + error + '</p>').insertAfter($('[name="' + input + '"]'));
                    });
                }
            }
        });
    });

});