$(document).ready(function () {
  
    $(document).on('click', '.dropdown-toggle', function () {
        $(this).next('.dropdown-menu').toggleClass('show');
    });

    $(document).on('click', '.btn-booking-status', function () {
        var current = $(this);
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure want to ' + current.attr('data-title') + ' this booking?',
            buttons: {
                confirm: {
                    btnClass: 'btn-success',
                    action: function () {
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
                            success: function (response) {
                                if (response.status) {
                                    toastr.success(response.message);
                                    setTimeout(function () {
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
                cancel: function () { }
            }
        });
    });
    
 
    $(document).on('click', '#example tbody tr', function () {
        var current = $(this);
        $('#cover-spin').show();
        $.ajax({
            url: current.attr('data-url'),
            type: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': current.attr('data-id'),
            },
            dataType: 'json',
            success: function (response) {
                $('#cover-spin').hide();
                if (response.status) {
                    $('.sec-booking-info').html(response.data.html);
                    $('html, body').animate({
                        scrollTop: $('.sec-booking-info').offset().top
                    }, 150);
                } else {
                    $('#cover-spin').hide();
                    toastr.error(response.message);
                }
            }
        });
    });
 
    $('.btn-search').click(function() {
        $(this).closest('form').submit();
    });
    $('[name="booking_status"]').change(function() {
        $(this).closest('form').submit();
    });
    $('[name="filter_option"]').change(function() {
        $(this).closest('form').submit();
    });
});