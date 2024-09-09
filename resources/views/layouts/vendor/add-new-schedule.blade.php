<div class="modal fade" id="add-new-schedule" tabindex="-1" aria-labelledby="editproLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editproLabel">Profile Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="is-readonly" action="{{ route('updateProfile') }}" onsubmit="return false;">
                    @csrf
                    <div class="profiless">
                        <?php
                        $path = asset('vendor-assets/images/profile.png');
                        if (Auth::user()->profile_image != '') {
                            $path = asset('uploads/profile/' . Auth::user()->profile_image);
                        }
                        ?>
                        <img src="{{ $path }}" alt="profile">
                    </div>
                    <div class="form-group">
                        <label>Profile Image</label>
                        <input type="file" name="profile_image" class="form-control cname" value="" accept="image/*">
                        <span class="clearname"></span>
                    </div>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control cname" value="{{ Auth::user()->name }}">
                        <span class="clearname"></span>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control cemail" value="{{ Auth::user()->email }}">
                        <span class="clearemail"></span>
                    </div>
                    <?php
                    $helper = new App\Helpers\Helper();
                    $category = $helper->getCategory();
                    ?>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control ccat" name="id_category">
                            <option value="">Select</option>
                            <?php
                            if (!empty($category)) {
                                $selected = Auth::user()->getCategory();
                                foreach ($category as $value) {
                                    $selected_text = $value->id == $selected ? 'selected="selected"' : '';
                            ?>
                                    <option value="{{ $value->id }}" {{ $selected_text }}>{{ $value->category_name }}</option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button type="button" class="view-all-review btn-edit js-edit btn-update-profile"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Edit Profile</button>
                    <button type="button" class="view-all-review btn-save js-save">Save Profile</button>
                </form>
                <form class="is-readonly mt-3" action="{{ route('changePassword') }}" onsubmit="return false;">
                    @csrf
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" class="form-control cpassword" value="" placeholder="********">
                        <span class="clearpassword"></span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control cpassword" value="" placeholder="********">
                        <span class="clearpassword"></span>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control crpassword" value="" placeholder="********">
                        <span class="clearrpassword"></span>
                    </div>
                    <button type="button" class="view-all-review btn-edit js-edit btn-change-password"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Change Password</button>
                    <button type="button" class="view-all-review btn-save js-save">Save Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>