	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="{{URL::to('/admin/dashboard')}}">
				<img src="{{asset('admin-assets/images/logo-dark.png')}}" alt="logo">
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link {{(request()->is('admin/dashboard')) ? 'active' : '' }}" href="{{URL::to('admin/dashboard')}}">Dashboard</a>
					</li>
					<li class="nav-item">
						<a class="nav-link {{(request()->is('admin/users')) ? 'active' : '' }}" href="{{URL::to('admin/users')}}">User Management</a>
					</li>
					<li class="nav-item">
						<a class="nav-link {{(request()->is('admin/booking')) ? 'active' : '' }}" href="{{URL::to('admin/booking')}}">Booking Management</a> 
					</li>
					<li class="nav-item">
						<a class="nav-link {{(request()->is('admin/vendors')) ? 'active' : '' }}" href="{{URL::to('admin/vendors')}}">Vendor Management</a>
					</li>
				</ul>
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle vprofile" href="javascript:void(0);" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="{{ !empty(Auth::user()->profile_image) ? url('/').'/uploads/profile/'.Auth::user()->profile_image : asset('assets/images/profile.png')}}">
							<span>{{Auth::user()->name}}<br><span>{{Auth::user()->email}}</span></span>
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li>
								<a class="dropdown-item" href="{{ route('admin.update-profile') }}" title="Edit Profile">Edit Profile</a>
							</li>
							<li>
								<a class="dropdown-item" href="{{ route('admin.settings') }}" title="Settings">Settings</a>
							</li>
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