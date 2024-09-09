$(document).ready(function () {
    //Datatable JS
    var table = $('#example').DataTable({
        //"aaSorting": [],
        "order": []
    });
    $('#example').on('click', 'tr', function () {
        $('#example tr').removeClass('selected');
        var $row = $(this),
            isSelected = $row.hasClass('selected')
        $row.toggleClass('selected').find(':checkbox').prop('checked', !isSelected);
    });
    
    $('#example1').on('click', 'tr', function () {
        $('#example1 tr').removeClass('selected');
        var $row = $(this),
            isSelected = $row.hasClass('selected')
        $row.toggleClass('selected').find(':checkbox').prop('checked', !isSelected);
    });
    
    $('#example2').on('click', 'tr', function () {
        $('#example2 tr').removeClass('selected');
        var $row = $(this),
            isSelected = $row.hasClass('selected')
        $row.toggleClass('selected').find(':checkbox').prop('checked', !isSelected);
    });
    $("#selectAll, #unselectAll").on("click", function () {
        var selectAll = this.id === 'selectAll';
        $("#example tr :checkbox").prop('checked', selectAll);
    });
    
    $("#selectAll, #unselectAll").on("click", function () {
        var selectAll = this.id === 'selectAll';
        $("#example1 tr :checkbox").prop('checked', selectAll);
    });
    
    $("#selectAll, #unselectAll").on("click", function () {
        var selectAll = this.id === 'selectAll';
        $("#example2 tr :checkbox").prop('checked', selectAll);
    });
    $('#search').keyup(function () {
        table.search($(this).val()).draw();
    });

    $("#selectAll").click(function () {
        $("#unselectAll").show();
        $("#selectAll").hide();
        const rows = Array.from(document.querySelectorAll('tr'));
        rows.forEach(row => {
            row.classList.add('selected');
        });
    });
    $("#unselectAll").click(function () {
        $("#unselectAll").hide();
        $("#selectAll").show();
        const rows = Array.from(document.querySelectorAll('tr.selected'));
        rows.forEach(row => {
            row.classList.remove('selected');
        });
    });
    //End datatable js

    var appURL = $(".baseurl").val();
   

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