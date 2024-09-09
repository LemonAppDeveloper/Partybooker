$(document).ready(function(){
    function initialize() {
        var input = document.getElementById('locationAdd');
        var autocomplete = new google.maps.places.Autocomplete(input);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    if (/Mobi/.test(navigator.userAgent)) {
        $(".date input").attr("type", "date");
        $(".time input").attr("type", "time");
    }else{
        $("#datepicker").datetimepicker({
            useCurrent: false,
            format: "DD-MMM-YYYY",
            minDate:new moment(),
            showTodayButton: true,
            icons: {
                next: "fa fa-chevron-right",
                previous: "fa fa-chevron-left",
                today: 'todayText',
            }
        });
        $("#timepicker").datetimepicker({
            format: "LT",
            icons: {
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down"
            }
        });
    }
    $("#createEventForm").validate({
        rules:{
            'title':"required",
            'location':"required",
            'event_date':"required",
            'event_time':"required",
            'category':"required",
        },
        messages:{
            'title':"Event title is required.!",
            'location':"Event location is required.!",
            'event_date':"Event date is required.!",
            'event_time':"Event time is required.!",
            'category':"Event category is required.!",
        },
    });
});