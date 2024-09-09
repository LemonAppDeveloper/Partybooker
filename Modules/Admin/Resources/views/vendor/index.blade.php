@extends('layouts.admin.app')
@section('content')
    <div class="row">
		<div class="col-md-12" id="usermanage">
			<div class="row">
                <div class="col-md-12">
                    <div class="order-derails">
                        <div class="order-head">
                            <h3>Vendors Details</h3>                          
                            <a href="{{ url('/') }}/admin/users/export/2" class="btn btn-info btn-theme text-white">Export</a>
                        </div>
                        <div class="order-search">
                            <div class="input-group">
                                <span class="input-group-append input-group-addon">
                                    <span class="input-group-text"><i class="las la-search"></i></span>
                                </span>
                                <input type="text" name="search" class="form-control" placeholder="Search" id="search">
                            </div>

                            <div class="input-group d-none">
                                <span class="input-group-append input-group-addon">
                                    <span class="input-group-text"><i class="las la-filter"></i></span>
                                </span>
                                <select class="form-control">
                                    <option>Filter</option>
                                </select>
                            </div>
                            <div class="input-group d-none">
                                <span class="input-group-append input-group-addon">
                                    <span class="input-group-text"><img src="{{asset('admin-assets/images/icon.png')}}" alt="icon"></span>
                                </span>
                                <select class="form-control">
                                    <option>Category: All</option>
                                </select>
                            </div>								
                        </div>
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th>Vendor ID</th>
                                    <th>Vendor Name</th>
                                    <th>Date Joined</th>                                    
                                    <th>Status</th>
                                    <th>Email Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($vendors))
                                    @foreach($vendors as $user)
                                        <tr data-id="{{ $user['id'] }}" data-url="{{ route('vendor-info') }}">
                                            <td>#{{$user['id']}}</td>
                                            <td>{{$user['name']}}</td>
                                            <td>{{Carbon\Carbon::parse($user['created_at'])->format('F d,Y')}}</td>                                            
                                            <td><a href="javascript:void(0);" class="change_Status" data-status = "{{$user['status']}}" data-user_id = "{{$user['id']}}">{{$user['status'] === 1 ? 'Active':'Inactive'}}</td>
                                            <td>{{$user['email']}}</td>
                                            <td>
                                                @if($user['status'] == 1)

                                                @else

                                                @endif
                                                <button class="btn btn-danger btn-sm btn-delete-user" data-table="users" data-id="<?php echo $user['id']; ?>">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="11">No Record Found.</td>
                                    </tr>
                                @endif
                            </<tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-3" id="userdetails">
            <div class="user-head">
                <img src="{{ asset('uploads/profile/') }}" alt="profile" style="max-width: 200px;max-height:200px;">
                <p class="pname" id="name">Premium Catering</p>
                <span id="email">adelbertjay@party.com</span>
            </div>
            <div class="headings">
                <h3>Overview</h3>
                <a href="javascript:void(0);" class="d-none">Edit</a>
            </div>
            <div class="infos">
                <div class="info-box">
                    <h2>--</h2>
                    <p>Hours Spent</p>
                </div>
                <div class="info-box">
                    <h2 id="completed-events">5</h2>
                    <p>Completed Events</p>
                </div>
                <div class="info-box">
                    <h2 id="active-events">3</h2>
                    <p>Active Events</p>
                </div>
                <div class="info-box">
                    <h2 id="cancelled-events">3</h2>
                    <p>Cancelled Events</p>
                </div>
                <div class="info-box">
                    <h2 id="status">Active</h2>
                    <p>Status</p>
                </div>
                <div class="info-box">
                    <h2>--</h2>
                    <p>Total Spent</p>
                </div>
            </div>
            <div class="headings">
                <h3>Bank Details</h3>
                 
            </div>
            <div class="activity-list">
                <p>Bank Name</p>
                <span id="bank_name">--</span>
            </div>
            <div class="activity-list">
                <p>Account Number</p>
                <span id="account_number">--</span>
            </div>

            <div class="activity-list">
                <p>Code</p>
                <span id="code">--</span>
            </div>
            {{-- <div class="headings mt-4">
                <h3>Recent Activities</h3>
                <a href="javascript:void(0);">View all</a>
            </div>
            <div class="activity-list">
                <p>Added Astound to favourites.</p>
                <span>14d</span>
            </div>
            <div class="activity-list">
                <p>Added Astound to the listing.</p>
                <span>22d</span>
            </div>
            <div class="activity-list">
                <p>Left a rating to Cateringzen.</p>
                <span>1mo</span>
            </div>
            <div class="activity-list">
                <p>Left a comment to Cateringzen.</p>
                <span>1mo</span>
            </div>
            <div class="activity-list">
                <p>Added Billie Eilish to the favourites.</p>
                <span>2mo</span>
            </div>
            <div class="activity-list">
                <p>Left a comment to John Myer’s page.</p>
                <span>3mo</span>
            </div> --}}
            <a href="javascript:void(0);" class="d-none view-all-review">Contact User</a>
        </div>
    </div>
@endsection
@section('pageScript')
<script src="{{ asset('admin-assets/js/popper.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#example tbody').on('click', 'tr', function() {
            var userId = $(this).data('id');
            var route = $(this).data('url');
            $('#cover-spin').show();
            // Make AJAX request to get user details
            $.ajax({
                type: 'GET',
                url: route,
                data: {
                    userId: userId
                },
                dataType: 'json',
                success: function(response) {
                    $('#cover-spin').hide();
                    console.log(response.data[0].name);
                    $('#name').text(response.data[0].name);
                    $('#email').text(response.data[0].email);
                    var status = response.data[0].status;
                    if (status === 1) {
                        $('#status').text('Active');
                    } else {
                        $('#status').text('Inactive');
                    }
                    $('#completed-events').text(response.CompleteEvents);
                    $('#active-events').text(response.ActiveEvents);
                    $('#cancelled-events').text(response.CancelEvents);
                      // Check if bank details exist
                        if (response.bankDetail) {
                            console.log(response.bankDetail.bank_name);
                            $('#bank_name').text(response.bankDetail.bank_name);
                            $('#account_number').text(response.bankDetail.account_no);
                            $('#code').text(response.bankDetail.code);
                        } else {
                            $('#bank_name').text('N/A');
                            $('#account_number').text('N/A');
                            $('#code').text('N/A');
                        }
                    var baseUrl ='{{ asset('uploads/profile/') }}';  
                    var imageUrl = baseUrl + '/' + response.data[0].profile_image;
                    $('#userdetails img').attr('src', response.user_info.path);
                    var element = document.getElementById("usermanage");
                    element.classList.remove("col-md-12");
                    element.classList.add("col-md-9");
                    $("#userdetails").show();
                },
                error: function(error) {
                    console.error('Error fetching user details:', error);
                }
            });
        });
    });
</script>
@endsection