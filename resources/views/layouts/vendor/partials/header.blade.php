 
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    	<div class="container">
    		<a class="navbar-brand" href="{{URL::to('/vendor/dashboard')}}">
    			<img src="{{asset('vendor-assets/images/logo-dark.png')}}" alt="logo">
    		</a>
    		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
    		<div class="collapse navbar-collapse" id="navbarSupportedContent">
    			<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
    				<li class="nav-item">
    					<a class="nav-link {{(request()->is('vendor/dashboard')) ? 'active' : '' }}" href="{{URL::to('vendor/dashboard')}}">Dashboard</a>
    				</li>
    				<li class="nav-item d-none">
    					<a class="nav-link {{(request()->is('vendor/profile')) ? 'active' : '' }}" href="{{URL::to('vendor/profile')}}">Profile</a>
    				</li>
    				<li class="nav-item">
    					<a class="nav-link {{(request()->is('vendor/booking')) ? 'active' : '' }}" href="{{URL::to('vendor/booking')}}">Booking Management</a>
    				</li>
    				<li class="nav-item">
    					<a class="nav-link {{(request()->is('vendor/customer')) ? 'active' : '' }}" href="{{URL::to('vendor/customer')}}">Customer Management</a>
    				</li>

    				<li class="mobilemenu">
    					<a class="nav-link" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editpro">Profile</a>
    				</li>
    				<li class="mobilemenu">
    					<a class="nav-link" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#settings">Settings</a>
    				</li>
    				<li class="mobilemenu">
    					<a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    						@csrf
    					</form>
    				</li>
    					<?php
							$total_unread = 0;
							$get_notifications = get_notifications(Auth::user()->id);
							if ($get_notifications['status'] == true) {
								$total_unread = $get_notifications['data']['total_unread'];
							}
							?>
    				<li class="nav-item dropdown mobilemenu">
    					<a class="nav-link dropdown-toggle notification isread" href="javascript:void(0);" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    						   <i class="las la-bell"></i>
                                @if($total_unread > 0)
                                    <span style="background:red">{{ $total_unread }}</span>
                                @endif
    					</a>
    					<ul class="dropdown-menu notiheader" aria-labelledby="navbarDropdown">
    						<div class="menu-heads">
    							<h3>Notifications</h3>
    							<!--<p>-->
    							<!--	<a href="{{url('home')}}"><i class="las la-ellipsis-h"></i></a>-->
    							<!--</p>-->
    						</div>
    					
    						<p class="unread"><?php echo $total_unread > 0 ? $total_unread . ' Unread' : 'No New notification'; ?></p>
    						<?php
							if ($get_notifications['status'] == true) {
								foreach ($get_notifications['data']['info'] as $value) {
							?>
    								<li>
    									<a class="dropdown-item" href="javascript:void(0);">
    										<div class="noti-list">
    											<div class="notpro d-none">
    												<p>JA</p>
    											</div>
    											<div class="notdet {{ $value->is_read == 1 ? 'read' : '' }}">
    												<p>{{ $value->notification }}</p>
    												<span>{{ $value->created_at }}</span>
    											</div>
    										</div>
    									</a>
    								</li>
    						<?php
								}
							}
							?>
    					</ul>
    				</li>
    			</ul>
    			
    				<?php
							$total_unread = 0;
							$get_notifications = get_notifications(Auth::user()->id);
							if ($get_notifications['status'] == true) {
								$total_unread = $get_notifications['data']['total_unread'];
							}
							?>
    			<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
    				<li class="nav-item d-none">
    					<a class="nav-link" href="javascript:void(0);"><i class="las la-comment-dots"></i></a>
    				</li>
    				<li class="nav-item dropdown">
    					<a class="nav-link dropdown-toggle notification asread isread" href="javascript:void(0);" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    						<i class="las la-bell"></i>
    					    @if($total_unread > 0)
                                        <span  style="background:red">{{ $total_unread }}</span>
                                    @endif
    					</a>
    					<ul class="dropdown-menu notiheader" aria-labelledby="navbarDropdown">
    						<div class="menu-heads">
    							<h3>Notifications</h3>
    							<!--<p>-->
    							<!--	<a href="{{url('home')}}"><i class="las la-ellipsis-h"></i></a>-->
    							<!--</p>-->
    						</div>
    					
    						<p class="unread"><?php echo $total_unread > 0 ? $total_unread . ' Unread' : 'No New notification'; ?></p>
    						<?php
							if ($get_notifications['status'] == true) {
								foreach ($get_notifications['data']['info'] as $value) {
							?>
    								<li>
    									<a class="dropdown-item" href="javascript:void(0);">
    										<div class="noti-list">
    											<div class="notpro ">
    												<img src="{{ asset('vendor-assets/images/bell-icon.jpg') }}">
    											</div>
    											<div class="notdet {{ $value->is_read == 1 ? 'read' : '' }}">
    												<p>{{ $value->notification }}</p>
    												<span>{{ $value->created_at }}</span>
    											</div>
    										</div>
    									</a>
    								</li>
    						<?php
								}
							}
							?>
    					</ul>
    				</li>
    				<li class="nav-item dropdown">
    					<a class="nav-link dropdown-toggle vprofile" href="javascript:void(0);" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    						<?php
							$path = asset('vendor-assets/images/profile.png');
							if (Auth::user()->profile_image != '') {
								$path = asset('uploads/profile/' . Auth::user()->profile_image);
							}
							?>
    						<img src="{{ $path }}">
    						<span>{{Auth::user()->name}}<br><span>{{Auth::user()->email}}</span></span>
    					</a>

    					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
    						<li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editpro">Profile</a></li>
    						<li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#settings">Settings</a></li>
    						<li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    								@csrf
    							</form>
    						</li>
    					</ul>
    				</li>
    			</ul>
    		</div>
    	</div>
    </nav>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
       <script>
        $(document).ready(function() {
            $('.asread').on('click', function() {
                $.ajax({
                    url: '{{ route("markAsRead") }}', // Update this URL to your actual route
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Add CSRF token for security
                    },
                    success: function(response) {
                        if (response.success) {
                            // Handle success response
                            console.log(response.message);
                            // Optionally, update the UI to reflect the change
                        } else {
                            // Handle failure response
                            console.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error('An error occurred:', error);
                    }
                });
            });
        });
    </script>