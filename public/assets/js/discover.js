$(document).ready(function () {
    $(document).on('click', '.go-to-detail', function () {
        window.location = $(this).attr('data-url');
    });   


    $('[name="rating"]').change(function () {
        filter_vendors();
    });
    $('[name="sort_by"]').change(function () {
        filter_vendors();
    });
    $('[name="sort_by"]').change(function () {
        filter_vendors();
    });
    $(document).on('click', '.filter-category', function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('.filter-category').removeClass('active');
        } else {
            $('.filter-category').removeClass('active');
            $(this).addClass('active');
        }
        filter_vendors();
    });
    $(document).on('click', '.btn-filter', function () {
        filter_vendors();
    });
  
});

function filter_vendors() {
    $('#cover-spin').show();
    $.ajax({
        url: window.location.href,
        method: 'GET',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'action': 'remove',
            'id_category': $('.filter-category.active').attr('data-id'),
            'sort_by': $('[name="sort_by"]:checked').val(),
            'rating': $('[name="rating"]:checked').val(),
            'search': $.trim($('[name="search"]').val()),
        },
        dataType: 'json',
        success: function (response) {
            $('#cover-spin').hide();
            if (response.status) {
                $('.sec-vendor-list').html(response.data.html);
            }
        }
    });
}