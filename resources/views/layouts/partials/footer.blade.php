<script src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-ui-1.13.2/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-ui-timepicker-addon/dist/jquery-ui-timepicker-addon.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js'></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script> 
<script src="{{ asset('admin-assets/plugins/toastr/toastr.min.js') }}"></script>
<script>
   
      
   
    $(document).ready(function() {
        $('.open-notification').click(function(e) {
            document.getElementById('navbarDropdownBell').click();
            e.stopPropagation();
        });
        
        $('#featureCarousel').carousel({
            interval: 1000 * 10
        });
        $('#featureCarousel').carousel('pause');

        if ($('[name="event_date"]').length > 0) {
            $('[name="event_date"]').datepicker({
                dateFormat: 'mm/dd/yy',
                minDate: 0, // Disable past dates
                onSelect: function(selectedDate) {
                },
                //Following code is for clear date
                showButtonPanel: true,
                closeText: 'Clear',
                onClose: function(dateText, inst) {
                    if ($(window.event.srcElement).hasClass('ui-datepicker-close')) {
                        document.getElementById(this.id).value = '';
                    }
                }
            });
        }

        if ($('[name="event_to_date"]').length > 0) {
            $('[name="event_to_date"]').datepicker({
                dateFormat: 'mm/dd/yy',
                minDate: 0, // Disable past dates
                onSelect: function(selectedDate) {
                },
                //Following code is for clear date
                showButtonPanel: true,
                closeText: 'Clear',
                onClose: function(dateText, inst) {
                    if ($(window.event.srcElement).hasClass('ui-datepicker-close')) {
                        document.getElementById(this.id).value = '';
                    }
                }
            });
        }

        var enforceModalFocusFn = $.fn.modal.Constructor.prototype._enforceFocus;

        $.fn.modal.Constructor.prototype._enforceFocus = function() {};

        if ($('[name="main-create-event"]').length > 0) {
            $('[name="main-create-event"]').validate({
                errorClass: 'text-danger',
                errorPlacement: function(error, element) {
                    if (element.attr('name') != 'title') {
                        error.insertAfter($(element).closest('.input-group'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    title: {
                        required: true
                    },
                    location: {
                        required: true
                    },
                    event_date: {
                        required: true
                    },
                    event_to_date: {
                        required: true
                    },
                    category: {
                        required: true
                    },
                },
                messages: {
                    title: {
                        required: "Please enter title."
                    },
                    location: {
                        required: "Please enter location."
                    },
                    event_date: {
                        required: "Please enter date."
                    },
                    event_to_date: {
                        required: "Please enter to date."
                    },
                    category: { 
                        required: "Please select category."
                    },
                }
            });
            $.ajaxSetup({ 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('[name="main-create-event"]').submit(function() {
                $('.validation-message,.success-message').remove();
                if ($('[name="main-create-event"]').valid()) {
                    $('#cover-spin').show();
                    $('[type="submit"]').attr('disabled', 'disabled');
                    $('[type="submit"]').find('.spinner-border').removeClass('d-none');
                    var current = $('[name="main-create-event"]');
                    $.ajax({
                        url: current.attr('action'),
                        method: 'POST',
                        data: current.serialize(),
                        dataType: 'json',
                        success: function(response) {
                            $('[type="submit"]').removeAttr('disabled');
                            $('[type="submit"]').find('.spinner-border').addClass('d-none');
                            if (response.status) {
                                 $('#cover-spin').hide();
                                $('.success-msg').removeClass('d-none');
                                $('<p class="text-success success-message">' + response
                                    .message + '</p>').insertBefore($('[name="title"]'));
                                setTimeout(function() {
                                  
                                    var domain = window.location.protocol + '//' + window.location.host;
                                      console.log(domain);
                                    var encryptedId = response.data.encrypted_id;
                                    var redirectUrl = domain + '/cart/' + encryptedId;
                                    window.location = redirectUrl;
                                }, 1000);
                            } else {
                                $('#cover-spin').hide();
                                 toastr.error(response.message || 'An error occurred while processing your request.');
                                $.each(response.message, function(input, error) {
                                    $('<small class="text-danger validation-message small">' +
                                        error + '</small>').insertAfter($(
                                        '[name="' + input + '"]'));
                                });
                            }
                        },
                        error: function(response) {
                            $('[type="submit"]').removeAttr('disabled');
                            $('[type="submit"]').find('.spinner-border').addClass('d-none');
                            if (typeof response.responseJSON.errors != undefined) {
                                $.each(response.responseJSON.errors, function(input,
                                    error) {
                                    $('<p class="text-danger validation-message small">' +
                                        error + '</p>').insertAfter($(
                                        '[name="' + input + '"]'));
                                });
                            }
                        }
                    });
                }
            });
        }

    });
</script>
@yield('pageScript')
@yield('pageScriptlinks')
</body>

</html>