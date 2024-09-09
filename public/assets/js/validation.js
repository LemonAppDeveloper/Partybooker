var MB = 1048576;
var MAX_ATTACHMENT_SIZE = 5242880;

jQuery(document).ready(function() {
    jQuery(".accept-number").inputFilter(function(value) {
        return /^\d*$/.test(value); // Allow digits only, using a RegExp
    });

    jQuery(".accept-mobile-number").inputFilter(function(value) {
        return /^(?=.*[0-9])[- +()0-9]+$/.test(value); // Allow digits only, using a RegExp
    });


    $(document).on('keyup keypress', '.accept-number', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });


    //When web page loaded on webview
    $(document).on('keyup keypress paste focusout', '.accept-number', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $(document).on('keyup', 'input', function(e) {
        remove_error_class($(this));
    });
    $(document).on('change', 'select', function(e) {
        remove_error_class($(this));
    });


    $('.allow-numeric-with-decimal').keypress(function(event) {
        var $this = $(this);
        if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
            ((event.which < 48 || event.which > 57) &&
                (event.which != 0 && event.which != 8))) {
            event.preventDefault();
        }

        var text = $(this).val();
        if ((event.which == 46) && (text.indexOf('.') == -1)) {
            setTimeout(function() {
                if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                    $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
                }
            }, 1);
        }

        if ((text.indexOf('.') != -1) &&
            (text.substring(text.indexOf('.')).length > 2) &&
            (event.which != 0 && event.which != 8) &&
            ($(this)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
        }
    });

    $('.allow-numeric-with-decimal').bind("paste", function(e) {
        var text = e.originalEvent.clipboardData.getData('Text');
        if ($.isNumeric(text)) {
            if ((text.substring(text.indexOf('.')).length > 3) && (text.indexOf('.') > -1)) {
                e.preventDefault();
                $(this).val(text.substring(0, text.indexOf('.') + 3));
            }
        } else {
            e.preventDefault();
        }
    });


    jQuery(".allow-numeric-without-decimal").on("keypress keyup blur", function(event) {
        jQuery(this).val(jQuery(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });


    //Set data-maxlength=5 in input field to setup maxlength as 5
    $(document).on('keyup blue keypress', '[data-maxlength]', function(e) {
        var current = $(this);
        maxlength = current.attr('data-maxlength');
        if (this.value.length == maxlength) {
            e.preventDefault();
            $('.custom-validation-message').remove();
            $('<p class="text-danger custom-validation-message">Only ' + maxlength + ' characters are allowed.</p>').insertAfter(current);
        } else if (this.value.length > maxlength) {
            // Maximum exceeded
            this.value = this.value.substring(0, maxlength);
        }
    });

    $('.space-not-allow').keyup(function() {
        this.value = this.value.replace(/\s/g, '');
    });
});

(function($) {
    jQuery.fn.inputFilter = function(inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
        });
    };
}(jQuery));

function global_trim(s) {
    return s.replace(/^\s+/g, '').replace(/\s+$/g, '');
}


function is_valid_email(email) {
    var regex = /^([a-zA-Z0-9_\'\+\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

function round_to_two(num) {
    return +(Math.round(num + "e+2") + "e-2");
}


function remove_error_class(element) {
    if (global_trim(element.val()) != '' && element.hasClass('is-invalid')) {
        element.removeClass('is-invalid');
        element.next('.custom-validation-message').remove();
    }
}

function clear_form_errors() {
    $('.is-invalid').removeClass('is-invalid');
    $('.custom-validation-message').next('.custom-validation-message').remove();
}

$(document).on('change', '.attribute-image-input', function() {
    $('.custom-validation-message').remove();
    var current = $(this);
    var i = 0;

    var galleryContainer = $('.js-grid .my-shuffle');

    for (i = 0; i < this.files.length; i++) {
        var file = this.files[i];
        var file_name = file.name;
        var file_size = file.size;
        var valid_extensions = ['jpg', 'png', 'jpeg', 'png', 'gif'];

        if (file_size > MAX_ATTACHMENT_SIZE) {
            current.val('');
            $('<p class="text-danger custom-validation-message"><i class="fa fa-exclamation-circle"></i> Please select a file having size less than ' + (MAX_ATTACHMENT_SIZE / (1024 * 1024)) + 'MB.</p>').insertAfter(current);
            toastr.error();
            return false;
        } else if (is_valid_attachment(file_name, valid_extensions) == false) {
            current.val('');
            toastr.error('Only ' + valid_extensions.join(', ') + ' extensions are allowed.');
            return false;
        }

        // Create image preview
        var reader = new FileReader();
        console.log(reader)
        reader.onload = (function(file) {
            return function(e) {
                // Append an image element with the preview
                var imagePreview = $('<img>').attr('src', e.target.result);

                var galleryItem = $('.selected').append(imagePreview);
                console.log(galleryItem);
                galleryContainer.append(galleryItem);
            };
        })(file);

        reader.readAsDataURL(file);
    }
    
    let message = this.files.length === 1 
    ? 'You have added 1 image.' 
    : 'You have added ' + this.files.length + ' images.';
    toastr.success(message);
});


function is_valid_attachment(file_name, valid_extensions = VALID_ATTACHMENT_EXTENSION) {
    var file = file_name.toLowerCase(),
        extension = file.substring(file.lastIndexOf('.') + 1);
    if (jQuery.inArray(extension, valid_extensions) == -1) {
        return false;
    } else {
        return true;
    }
}