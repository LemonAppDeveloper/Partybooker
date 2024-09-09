@extends('layouts.app')
@section('pageStyles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.css') }}" />
@endsection
@section('content')
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="party-heading">
                <h3 class="mb-4"><a href="{{ route('setting') }}"><i class="las la-arrow-left"></i></a> Favorites</h3>
            </div>
        </div>
        <div class="col-md-12 overflow overflow-h">
            <div class="row">
                <div class="col-md-2">
                    <div class="sidebar-menus">
                        <a href="javascript:void(0);" class="cat-btn"><span><img src="{{ asset('assets/images/icon-15.png') }}">Categories</span> <i class="las la-angle-up"></i></a>
                        <a href="{{route('favorite-list')}}" class="{{ $id_category == null ? 'active' : '' }}"><img src="{{ asset('assets/images/icon-14.png') }}">All</a>
                        <?php
                        if (isset($category) && !empty($category)) {
                            foreach ($category as $key => $value) {
                        ?>
                                <a href="{{route('favorite-list',my_encrypt($value->id))}}" class="{{ $id_category == my_encrypt($value->id) ? 'active' : '' }}"><img src="{{ $value->category_icon_url }}">{{ $value->category_name }}</a>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="fav-items">
                        <div class="head-titact">
                            <h4><?php echo !empty($getMyFavorite) ? count($getMyFavorite) : 0 ?> Items</h4>
                            <button type="submit" class="btn btn-secondary" id="deletebtn" data-href="{{route('updateFavorite')}}"> <i class="las la-trash-alt"></i> Delete</button>
                        </div>
                        <div class="data-tableview">
                            <div class="wedtable">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item d-none" role="presentation">
                                        <button class="nav-link active" id="shortlist-tab" data-bs-toggle="tab" data-bs-target="#shortlist" type="button" role="tab" aria-controls="shortlist" aria-selected="true">Shortlist</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="shortlist" role="tabpanel" aria-labelledby="shortlist-tab">
                                        <table id="example" class="table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" name="checkall" id="selectAll"></th>
                                                    <th>Items</th>
                                                    <th>Vendor Name</th>
                                                    <th>Category</th>
                                                    <th>Availability</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($getMyFavorite) && !empty($getMyFavorite)) {
                                                    foreach ($getMyFavorite as $myFavorite) {
                                                ?>
                                                        <tr>
                                                            <td><input type="checkbox" name="favorite[]" value="{{my_encrypt($myFavorite->id)}}"></td>
                                                            <td>
                                                                <div class="partynm">
                                                                    <?php
                                                                    if (!empty($myFavorite->product_info)) {
                                                                    ?>
                                                                        <img src="{{$myFavorite->product_info->image_url}}" alt="party">
                                                                        <span>{{ $myFavorite->product_info->title }}</span>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <img src="{{$myFavorite->plan_info->image_url}}" alt="party">
                                                                        <span>{{ $myFavorite->plan_info->plan_name }} <a href="javascript:void(0)" class="moreptydtl"><i class="las la-angle-down"></i></a>
                                                                            <span class="more-det">
                                                                                {{ $myFavorite->plan_info->plan_description }}
                                                                            </span>
                                                                        </span>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </td>
                                                            <td>{{ isset($myFavorite->vendor_info[0]->name) ? $myFavorite->vendor_info[0]->name : '' }}</td>
                                                            <td>{{ isset($myFavorite->vendor_info[0]->category) ? $myFavorite->vendor_info[0]->category : '' }}</td>
                                                            <td>{{ isset($myFavorite->vendor_info[0]->timing) ? $myFavorite->vendor_info[0]->timing : '' }}</td>
                                                        </tr>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td colspan="5">Favorite list not available.</td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>

                                        <div class="footer-option">
                                            <div class="lefts">
                                                <div class="page-row d-none">
                                                    <p>Rows per page</p>
                                                    <select class="select-control form-control">
                                                        <option>5</option>
                                                        <option>10</option>
                                                        <option>20</option>
                                                        <option>50</option>
                                                        <option>100</option>
                                                    </select>
                                                </div>
                                                <div class="num-rec d-none">
                                                    <p>1-10 of 100</p>
                                                    <a href=""><i class="las la-angle-left"></i></a>
                                                    <a href=""><i class="las la-angle-right"></i></a>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <div class="buttons">
                                                    <button class="btns btn-checkout text-center btn-choose-party" <?php /*data-bs-toggle="modal" data-bs-target="#addparty"  */ ?> {{ (isset($getMyFavorite) && !empty($getMyFavorite)) ? '' : 'disabled' }}>Add to my party</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addparty" tabindex="-1" aria-labelledby="addpartyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addpartyLabel">Party Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="is-readonly">
                    <div class="form-group">
                        <select class="form-select" name="id_event">
                            <option value="">Choose a Party</option>
                            <?php
                            if (isset($party_info) && !empty($party_info)) {
                                foreach ($party_info as $value) {
                                    echo '<option value="' . my_encrypt($value->id) . '">' . $value->event_title . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                <button type="button" class="btn-gradient1 btn-add-to-cart" data-href="{{ route('favorite-to-cart') }}" <?php /*data-bs-toggle="modal" data-bs-target="#successparty"*/ ?>>Add to my party</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successparty" tabindex="-1" aria-labelledby="successpartyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="successmsg text-center">
                    <i class="las la-check"></i>
                    <h2>Successfully added to Party</h2>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-gradient1" onclick="window.location='{{url("cart")}}';">Continue</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('pageScript')
<script>
    $('#selectAll').click(function(e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
    $(function() {

        function setCheck(o, c) {
            o.prop("checked", c);
            if (c) {
                o.closest("tr").addClass("checked");
                $('#deletebtn').addClass("btn-danger");
                $('#deletebtn').removeClass("btn-secondary");
            } else {
                o.closest("tr").removeClass("checked");
                $('#deletebtn').addClass("btn-secondary");
                $('#deletebtn').removeClass("btn-danger");
            }
        }

        function setCheckAll(o, c) {
            o.each(function() {
                setCheck($(this), c);
            });
            if (c) {
                $("#selectAll").prop("title", "Check All");
            } else {
                $("#selectAll").prop("title", "Uncheck All");
            }
        }


        $("#selectAll").on('change', function() {
            setCheckAll($("tbody input[type='checkbox']"), $(this).prop("checked"));
        });
        $("tbody tr").on("click", function(e) {
            var chk = $("[type='checkbox']", this);
            setCheck(chk, !$(this).hasClass("checked"));
        });

        $('.btn-choose-party').click(function() {
            var current = $(this);
            if ($('[name="favorite[]"]:checked').length == 0) {
                $.alert('Please select record to proceed.');
            } else {
                $('#addparty').modal('show');
            }
        });

        $('.btn-add-to-cart').click(function() {
            var current = $(this);
            if ($('[name="favorite[]"]:checked').length == 0) {
                $.alert('Please select record to proceed.');
            } else {
                if ($('[name="id_event"]').val() == '') {
                    $.alert('Please select party.');
                } else {
                    $('#cover-spin').show();
                    var id = [];
                    $('[name="favorite[]"]:checked').each(function() {
                        id.push($(this).val());
                    });
                    $.ajax({
                        url: current.attr('data-href'),
                        type: 'POST',
                        data: {
                            'id': id,
                            'id_event': $('[name="id_event"]').val(),
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                toastr.remove();
                                toastr.success(response.message);
                                $('[name="favorite[]"]:checked').each(function() {
                                    $(this).closest('tr').remove();
                                });
                                $('#successparty').modal('show');
                            } else {
                                toastr.remove();
                                toastr.error(response.message);
                            }
                            $('#cover-spin').hide();
                        }
                    });
                }
            }
        });

        $('#deletebtn').click(function() {
            var current = $(this);
            if ($('[name="favorite[]"]:checked').length == 0) {
                $.alert('Please select record to remove.');
            } else {
                $('#cover-spin').show();
                var id = [];
                $('[name="favorite[]"]:checked').each(function() {
                    id.push($(this).val());
                });
                $.ajax({
                    url: current.attr('data-href'),
                    type: 'POST',
                    data: {
                        'id': id,
                        'type': 'remove',
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            toastr.remove();
                            toastr.success(response.message);
                            $('[name="favorite[]"]:checked').each(function() {
                                $(this).closest('tr').remove();
                            });
                        } else {
                            toastr.remove();
                            toastr.error(response.message);
                        }
                        $('#cover-spin').hide();
                    }
                });
            }
        });
    });
</script>
@endsection
@section('pageScriptlinks')
<script src="{{ asset('assets/plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/page/auth.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/discover.js') }}"></script>
@endsection