<div class="modal fade" id="editpro" tabindex="-1" aria-labelledby="editproLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<h5 class="modal-title" id="editproLabel">Profile Information</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
            <div class="modal-body">
                <form class="is-readonly" action="{{ route('update-profile') }}">
                    <div class="profiless">
                        <?php
                        $path = asset('vendor-assets/images/profile.png');
                        if (Auth::user() && Auth::user()->profile_image != '') {
                            $path = asset('uploads/profile/' . Auth::user()->profile_image);
                        }
                        ?>
                        <img src="{{ $path }}" alt="profile">
                        <h3>{{  Auth::user()->name }}</h3>
                    </div>
                    <div class="form-group">
                        <label>Profile Image</label>
                        <input type="file" name="profile_image" class="form-control" value="" accept="image/*" disabled>
                        <span class="clearname"></span>
                    </div>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control cname" value="{{ Auth::user()->name }}" disabled>
                        <span class="clearname"></span>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control cemail" value="{{ Auth::user()->email }}" disabled>
                        <span class="clearemail"></span>
                    </div>
                    <button type="button" class="view-all-review btn-edit js-edit">Update Profile</button>
                    <button type="button" class="view-all-review btn-save js-save1 btn-update-profile"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Save Profile</button>
                </form>
                <br /><br />
                <h5 class="pname">Change Password</h5>
                <br />
                <form method="POST" action="{{ route('change-password') }}" onsubmit="return false;">
                    @csrf
                    <label class="current-password">Current Password </label>
                    <input type="password" name="current_password" class="form-control" value="" placeholder="******">
                    <label class="password">New Password </label>
                    <input type="password" name="password" class="form-control" value="" placeholder="******">
                    <label class="password_confirmation">Confirm Password </label>
                    <input type="password" name="password_confirmation" class="form-control" value="" placeholder="******">
                    <button href="javascript:void(0);" class="view-all-review btn-change-password" id="editProfileA"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Change Password</button>
                </form>
                <button class="view-all-review" onclick="window.location='{{url('setting')}}';"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> View All Settings</button>
            </div>
        </div>
    </div>
</div>