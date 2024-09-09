$(document).ready(function () {
    var appURL = $(".baseurl").val();
    $(document).on('click', '.change_Status', function () {
        var current = $(this);
        var status = $(this).data('status');
        var user_id = $(this).data('user_id');
        var text = "";
        var successmessage = "";
        var confirmBtn = "";
        var popupText = "";
        if (status == 1) {
            text = "You want to inactive this user!";
            successmessage = "User successfully Inactive.";
            confirmBtn = "Yes, inactive it!";
            popupText = "Inactive!";
        } else {
            text = "You want to active this user!";
            successmessage = "User successfully Active.";
            confirmBtn = "Yes, active it!";
            popupText = "Active!";
        }
        Swal.fire({
            title: 'Are you sure?',
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmBtn
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: appURL + '/change_status',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'status': status,
                        'user_id': user_id
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == 1) {
                            if (status == 1) {
                                current.data('status', 0);
                                current.text('Inactive');
                            } else {
                                current.data('status', 1);
                                current.text('Active');
                            }
                            Swal.fire(
                                popupText,
                                successmessage,
                                'success'
                            );
                        } else {
                            Swal.fire(
                                "Error",
                                'Something went wrong!',
                                'error',
                            );
                        }
                    },
                });
            }
        });
    });

    $(document).on('click', '.btn-delete-user', function () {
        var current = $(this);
        var id = $(this).data('id');
        var table = current.data('table');
        var text = "";
        var successmessage = "";
        var confirmBtn = "";
        var popupText = "";

        text = "You want to delete this user!";
        successmessage = "User successfully Deleted.";
        confirmBtn = "Yes, Delete it!";
        popupText = "Delete!";

        Swal.fire({
            title: 'Are you sure to delete this user?',
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmBtn
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: appURL + '/delete',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id': id,
                        'table': table
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == 1) {
                            current.closest('tr').remove();
                            Swal.fire(
                                popupText,
                                successmessage,
                                'success'
                            );
                        } else {
                            Swal.fire(
                                "Error",
                                'Something went wrong!',
                                'error',
                            );
                        }
                    },
                });
            }
        });
    });
});