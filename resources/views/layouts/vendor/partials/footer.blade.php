<script src="{{asset('vendor-assets/js/jquery.min.js')}}"></script>
<script src="{{asset('vendor-assets/js/popper.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js'></script>
<script src="{{asset('vendor-assets/js/bootstrap.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="{{asset('vendor-assets/js/calendar.js')}}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js'></script>
<script src="{{asset('admin-assets/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{asset('vendor-assets/js/index.global.js')}}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js'></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

@yield('pageScript')
<script type="text/javascript">
    if ($('#example').length > 0) {
        $('#example').dataTable({
        "order": []
    });
        $('#example').on('click', 'tr', function() {
            $('#example').find('tr').removeClass('selected');
            var $row = $(this),
                isSelected = $row.hasClass('selected')
            $row.toggleClass('selected').find(':checkbox').prop('checked', !isSelected);
        });
    }
    $("#selectAll, #unselectAll").on("click", function() {
        var selectAll = this.id === 'selectAll';
        $("#example tr :checkbox").prop('checked', selectAll);
    });
</script>
<script type="text/javascript">
    $("#selectAll").click(function() {
        $("#unselectAll").show();
        $("#selectAll").hide();
        const rows = Array.from(document.querySelectorAll('tr'));
        rows.forEach(row => {
            row.classList.add('selected');
        });
    });
    $("#unselectAll").click(function() {
        $("#unselectAll").hide();
        $("#selectAll").show();
        const rows = Array.from(document.querySelectorAll('tr.selected'));
        rows.forEach(row => {
            row.classList.remove('selected');
        });
    });
</script>
 