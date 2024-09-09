$(document).ready(function () {
    $('[name="customer_breakdown_time"]').change(function () {
        get_customer_breakdown();
    });
    get_customer_breakdown();

    $('.sec-revenue-graph [name="id_plan"]').change(function () {
        get_graph_data();
    });
    $('.sec-revenue-graph [name="timeline"]').change(function () {
        get_graph_data();
    });
    get_graph_data();

    function get_graph_data() {
        $('#pushups').html('');

        var current = $('.sec-revenue-graph');
        $('#cover-spin').show();
        $.ajax({
            url: current.attr('data-url'),
            type: 'GET',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'timeline': current.find('[name="timeline"]').val(),
                'id_plan': current.find('[name="id_plan"]').val(),
            },
            dataType: 'json',
            success: function (response) {
                $('#cover-spin').hide();
                if (response.status) {
                    var data = (response.data.graph);
                    $('.total_earning').html(response.data.total);
                    // console.log(data);
                    // var data = [{
                    //     day: 'Oct 2021',
                    //     Earnings: 0,
                    // },
                    // {
                    //     day: 'Nov 2021',
                    //     Earnings: 0,
                    // },
                    // {
                    //     day: 'Dec 2021',
                    //     Earnings: 0,
                    // },
                    // {
                    //     day: 'Jan 2022',
                    //     Earnings: 0,
                    // },
                    // {
                    //     day: 'Feb 2022',
                    //     Earnings: 0,
                    // },
                    // {
                    //     day: 'Mar 202333',
                    //     Earnings: 0,
                    // }
                    // ];
                    // console.log(data);
                    new Morris.Line({
                        element: 'pushups',
                        data: data,
                    
                        xkey: 'day',
                        parseTime: false,
                    
                        ykeys: ['Earnings'],
                        labels: ['Earnings'],
                        lineColors: ['#FB8547']
                    });
                } else {
                    $('#cover-spin').hide();
                    toastr.error(response.message);
                }
            }
        });


    }

});

function get_customer_breakdown() {
    var current = $('[name="customer_breakdown_time"]');
    $('#cover-spin').show();
    $.ajax({
        url: current.attr('data-url'),
        type: 'GET',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'customer_breakdown_time': current.val(),
        },
        dataType: 'json',
        success: function (response) {
            $('#cover-spin').hide();
            if (response.status) {
                $('.total_total').text(response.data.total);
                $('.total_cancelled').text(response.data.cancelled);
                $('.total_booked').text(response.data.booked);
                $('.total_ongoing').text(response.data.ongoing);
            } else {
                $('#cover-spin').hide();
                toastr.error(response.message);
            }
        }
    });
}