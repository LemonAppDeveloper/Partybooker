@extends('layouts.admin.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="pheading" style="margin-bottom: 20px;">
                        <h2><a href="{{ route('admin.settings') }}"><i class="las la-arrow-left"></i></a> Category Management</h2>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-green d-none">Save Changes</button>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="order-conf category-details">
                        <div class="cat-heading">
                            <h3>Category Management</h3>
                            <a href="javascript:void(0);" class="btn-add"><i class="las la-plus"></i> Add New</a>
                        </div>
                        <div class="input-group mb-5">
                            <span class="input-group-text"><i class="las la-search"></i></span>
                            <input type="text" class="form-control" name="search_value" placeholder="Search">
                        </div>

                        <table class="table-search">
                            <thead>
                                <tr>
                                    <th>Category ID</th>
                                    <th>Category Name</th>
                                    <th>Category Icon</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($category))
                                @foreach($category as $category_info)
                                <tr>
                                    <td>#{{$category_info['id']}}</td>
                                    <td>{{$category_info['category_name']}}</td>
                                    <td><img class="img img-thumbnail img-listing" src="{{ asset(env('CATEGORY_PATH').$category_info['category_icon']) }}" alt="{{$category_info['category_name']}}" title="{{$category_info['category_name']}}" /></td>
                                    <td class="{{$category_info['is_enable'] == 1 ? 'active' : 'Inactive'}}">{{$category_info['is_enable'] == 1 ? 'Active' : 'Inactive'}}</td>
                                    <td>
                                        <a href="javascript:void(0);" class="edit edit-data" data-detail="<?php echo base64_encode(json_encode($category_info)); ?>">Edit</a>
                                        <a href="javascript:void(0);" class="remove btn-delete" data-table="categories" data-id="<?php echo $category_info['id']; ?>">Remove</a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5">No Record Found.</td>
                                </tr>
                                @endif
                                </<tbody>
                        </table>
                        <div class="paginations d-none">
                            <div class="prv">
                                <a href="javascript:void(0);"><i class="las la-angle-left"></i> Previous</a>
                            </div>
                            <div class="page">
                                <a href="javascript:void(0);" class="active">1</a>
                                <a href="javascript:void(0);">2</a>
                                <a href="javascript:void(0);">3</a>
                                <span>...</span>
                                <a href="javascript:void(0);">9</a>
                                <a href="javascript:void(0);">10</a>
                            </div>
                            <div class="next">
                                <a href="javascript:void(0);">Next <i class="las la-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="addcat">
                <form name="form-add" id="form-add" onsubmit="return false;">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" value="" />
                        <input type="text" class="form-control" id="category_name" placeholder="Enter name" name="category_name" autocomplete="off" />
                        <div class="statuss">
                            <div class="form-check form-switch">
                                <span class="form-check-label">Status</span>
                                <div class="sst">
                                    <label class="active change-status-switch d-none" for="status">Active</label>
                                    <label class="deactive change-status-switch d-none" for="status">Deactive</label>
                                    <input class="form-check-input email-noti" type="checkbox" name="is_enable_temp" id="status" value="1" role="switch">
                                    <input type="hidden" name="is_enable" value="1">
                                </div>
                            </div>
                        </div>
                        <input type="file" class="form-control" id="category_icon" name="category_icon">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn save-change d-block">Save Changes</button>
                        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary d-block" aria-label="Close">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('pageScript')
<script>
    $(document).ready(function() {
        $('.btn-add').click(function() {
            $('#form-add').find('input,select').not('[name="_token"]').val('');
            $('.modal').modal('show');
        });
        $('[name="search_value"]').on("keyup", function() {
            var value = $(this).val();

            $('.table-search tr').each(function(index) {
                if (index != 0) {
                    $row = $(this);
                    var id = $row.find("td:nth-child(2)").text();
                    var id = $row.find("td:nth-child(2)").text().toLowerCase().trim();
                    var not_found = (id.indexOf(value) == -1);
                    $(this).toggle(!not_found);
                }
                if(value.length == 0) {
                    $(this).show(); 
                }
            });
        });
        $(document).on('click', '.edit-data', function() {
            var current = $(this);
            var data_detail = JSON.parse(atob(current.attr('data-detail')));
            $.each(data_detail, function(key, value) {
                if ($('#form-add').find('[name="' + key + '"]').length > 0) {
                    if (key == 'is_enable') {
                        if (value == '1') {
                            $('#form-add').find('[name="is_enable"]').val(1);
                            $('#form-add').find('[name="is_enable_temp"]').prop('checked', true);
                        } else {
                            $('#form-add').find('[name="is_enable"]').val(0);
                            $('#form-add').find('[name="is_enable_temp"]').prop('checked', false);
                        }
                    } else if (key != 'category_icon') {
                        $('#form-add').find('[name="' + key + '"]').val(value);
                    }
                }
            });
            $('.modal').modal('show');
        });

        $(document).on('submit', '#form-add', function() {
            $('#cover-spin').show();
            $('.custom-validation-message').remove();
            var formData = new FormData($('#form-add')[0]);
            $('#form-add').find('[type="submit"]').find('.spinner-border').removeClass('d-none');
            $('#form-add').find('[type="submit"]').attr('disabled', 'disabled');
            $.ajax({
                url: BASE_URL + '/category',
                type: 'POST',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    $('#cover-spin').hide();
                    $('#form-add').find('[type="submit"]').find('.spinner-border').addClass('d-none');
                    $('#form-add').find('[type="submit"]').removeAttr('disabled');
                    if (response.status) {
                        toastr.success(response.message);
                        $('.modal').modal('hide');
                        $('.modal').find('input,select').not('[name="_token"]').val('');
                        window.location = window.location.href;
                    } else {
                        if (typeof response.message == 'object') {
                            $.each(response.message, function(input, message) {
                                $('<p class="text-danger custom-validation-message">' + message + '</p>').insertAfter($('[name="' + input + '"]'));
                            });
                        } else {
                            toastr.error(response.message);
                        }
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $(document).on('change', '[name="is_enable_temp"]', function() {
            if ($(this).prop('checked')) {
                $('[name="is_enable"]').val(1);
            } else {
                $('[name="is_enable"]').val(0);
            }
        });

        $(document).on('click', '.btn-delete', function() {
            var current = $(this);
            var id = $(this).data('id');
            var table = current.data('table');
            var text = "";
            var successmessage = "";
            var confirmBtn = "";
            var popupText = "";

            text = "You want to delete this record!";
            successmessage = "Record successfully Deleted.";
            confirmBtn = "Yes, Delete it!";
            popupText = "Delete!";

            Swal.fire({
                title: 'Are you sure to delete this category?',
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmBtn
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: BASE_URL + '/category/' + id,
                        data: {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'id': id,
                            'table': table
                        },
                        dataType: 'json',
                        success: function(data) {
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
</script>
@endsection