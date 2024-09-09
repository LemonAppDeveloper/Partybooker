<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" />
<style>
form.is-readonly .form-group span {
    visibility: visible!important;
}
.form-group.sub-category .dropdown.bootstrap-select {
    border: 1px solid #ced4da;
    border-radius: 4px;
}
.bootstrap-select .dropdown-toggle:focus {
    outline: none !important;
}
</style>
<div class="modal fade" id="editpro" tabindex="-1" aria-labelledby="editproLabel" aria-hidden="true">
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
                        <input type="file" name="profile_image" class="form-control cname" value=""
                            accept="image/*">
                        <span class="clearname"></span>
                    </div>
                    <div class="form-group">
                        <label>Vendor name</label>
                        <input type="text" name="name" class="form-control cname"
                            value="{{ Auth::user()->name }}">
                        <span class="clearname"></span>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control cemail"
                            value="{{ Auth::user()->email }}">
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
                            <option value="{{ $value->id }}" {{ $selected_text }}>{{ $value->category_name }}
                            </option>
                            <?php 
                                }
                            }
                            ?>
                        </select>
                    </div>

                    @php
                        use App\Helpers\Helper;
                        use Illuminate\Support\Facades\Auth;

                        $helper = new Helper();
                        $subCategory = $helper->getSubCategory();
                        $selectedCategories = Auth::user()->getSubCategory(); // Assuming this now returns an array of selected category IDs
                    @endphp
                    
                    <div class="form-group sub-category">
                        <label>Party Category</label>
                            <select class="selectpicker form-control" multiple aria-label="size 3 select example"  name="id_sub_category[]">
                                <option value="">Select</option>
                                @foreach ($subCategory as $category)
                                    <option value="{{ $category['id'] }}"
                                        {{ in_array($category['id'], $selectedCategories) ? 'selected' : '' }}>
                                        {{ $category['category_name'] }}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                    
                    
                    <div class="form-group">
                         <label>Location</label>
                        <input type="text" name="location"  id="txtPlaces" class="form-control clocation"
                            value="{{ Auth::user()->location }}">
                        <input type="hidden" id="lat"  value="{{ Auth::user()->latitude }}" name="lat" />
                        <input type="hidden" id="lng"  value="{{ Auth::user()->longitude }}" name="lng" />
                        <span class="clearlocation"></span>
                    </div>


                    <button type="button" class="view-all-review btn-edit js-edit btn-update-profile"><span
                            class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Edit Profile</button>
                    <button type="button" class="view-all-review btn-save js-save">Save Profile</button>
                </form>
                <form class="is-readonly mt-3" action="{{ route('changePassword') }}" onsubmit="return false;">
                    @csrf
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" class="form-control cpassword" value=""
                            placeholder="********">
                        <span class="clearpassword"></span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control cpassword" value=""
                            placeholder="********">
                        <span class="clearpassword"></span>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control crpassword"
                            value="" placeholder="********">
                        <span class="clearrpassword"></span>
                    </div>
                    <button type="button" class="view-all-review btn-edit js-edit btn-change-password"><span
                            class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Change Password</button>
                    <button type="button" class="view-all-review btn-save js-save">Save Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
<script type="text/javascript">

        function initialize() {
            var input = document.getElementById('txtPlaces');
           
            var autocomplete = new google.maps.places.Autocomplete(input);
            
              // Event listener to clear the location value when typing starts
                input.addEventListener('input', function() {
                    document.getElementById('lat').value = '';
                    document.getElementById('lng').value = '';
                });

              google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                 console.log('Place object:', place);

                 var place = autocomplete.getPlace();
                 console.log('place.name',place.name);
                 console.log('place.geometry.location.lat()',place.geometry.location.lat());
                 console.log('place.geometry.location.lng()',place.geometry.location.lng());

                console.log(place.geometry);
                 
                 if (place.geometry) {
                        var lat = place.geometry.location.lat();
                        var lng = place.geometry.location.lng();
                        console.log('place.name', place.name);
                        console.log('place.geometry.location.lat()', lat);
                        console.log('place.geometry.location.lng()', lng);
            
                        // Set the values of the hidden input fields
                        document.getElementById('lat').value = lat;
                        document.getElementById('lng').value = lng;
                } else {
                    console.log("No geometry information available for the selected place.");
                }
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>

