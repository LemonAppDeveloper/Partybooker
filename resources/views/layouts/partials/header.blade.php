<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui-1.13.2/jquery-ui.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/jquery-ui-timepicker-addon/dist/jquery-ui-timepicker-addon.min.css') }}">
    <link href="//kenwheeler.github.io/slick/slick/slick.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="stylesheet"
        href="//maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/date-time.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/plugins/toastr/toastr.min.css') }}">
    @yield('pageStyles')
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/developer.css') }}">
    <script>
        var BASE_URL = '{{ url(' / ') }}';
    </script>

    <style>
        .ui-state-default,
        .ui-widget-content .ui-state-default {
            border: 0px;
            background: #ffffff;
            font-weight: normal;
            color: #000000;
        }

        .ui-widget-header {
            border: 0px solid #ddd;
            background: #ffffff
        }

        .ui-state-default,
        .ui-widget-content .ui-state-default:hover {
            background-color: #6F10DD;
            color: #ffffff
        }
        div#organizeparty::-webkit-scrollbar {
          width: 0px!important;
        }
        
        
        div#organizeparty::-webkit-scrollbar-track {
          background: #f1f1f1;
        }
        
        div#organizeparty::-webkit-scrollbar-thumb {
          background: #888;
        }
        
        div#organizeparty::-webkit-scrollbar-thumb:hover {
          background: #555;
        }
    </style>

    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe4wpJ11h1ZivefTePLG0iIOOQMAfIo3g&libraries=places"></script>

</head>
<?php
$class = ''; 
if (request()->is('login') || request()->is('register') || request()->is('vendor_register') || request()->is('forgot-password') || request()->routeIs('reset-password')) {
    $class = 'gradient-bg';
} elseif (request()->is('preferences')) {
    $class = 'gradient-bg setting-up preferences-pg';
} else {
    $class = 'discover-page';
}              
?>

<body class="<?php echo $class; ?>">
    <div id="cover-spin"></div>
    <input type="hidden" class="baseurl" value="{{ URL::to('/') }}">
    @if (request()->is('login') ||
            request()->is('register') ||
            request()->is('vendor_register') ||
            request()->is('forgot-password') || request()->routeIs('reset-password'))
        <nav class="navbar navbar-expand-lg navbar-light bg-light ">
            <div class="container">
                <a class="navbar-brand" href="{{ URL::to('/') }}">
                    <img src="{{ asset('assets/images/logo.png') }}">
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ url('contact') }}">Need help?<br><span>Contact
                                    us</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @else
        <nav class="navbar navbar-expand-lg navbar-light bg-light discover">
            <div class="container">
                <a class="navbar-brand" href="{{ url('') }}">
                    <img src="{{ asset('assets/images/logo-dark.png') }}">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="top-search navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item mobile-menu">
                            <a class="nav-link" href="javascript:void(0);">Profile</a>
                        </li>
                        <li class="nav-item mobile-menu">
                            <a class="nav-link" href="javascript:void(0);">Settings</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 nav-right">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('about') }}">About Us</i></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle summenu" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">Help</a>
                            <ul class="dropdown-menu menu-opt" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ url('contact') }}">Customer Support</a></li>
                                <li><a class="dropdown-item" href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
                                <li><a class="dropdown-item" href="{{ url('terms-of-use') }}">Terms of Use</a></li>
                                <li><a class="dropdown-item" href="{{ url('faq') }}">FAQs</a></li>
                            </ul>
                        </li>
                        @if (!Auth::user())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('vendor_register') }}">Become a Vendor</i></a>
                            </li>
                            <li class="nav-item logregbtn">
                                <a class="nav-link" href="{{ url('login') }}">
                                    <i class="las la-sign-in-alt"></i>
                                    Login
                                </a>
                            </li>
                            <li class="nav-item logregbtn">
                                <a class="nav-link" href="{{ url('register') }}">
                                    <i class="las la-user-plus"></i>
                                    Register
                                </a>
                            </li>
                            <li class="nav-item dropdown ddmenu">
                                <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarDropdowns"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('assets/images/bar.png') }}">
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdowns" id="maindropdowns">
                                    <div class="menu-heads">
                                        <h3>Menu</h3>
                                    </div>
                                    <li>
                                        <a class="nav-link" href="{{ url('login') }}">
                                            <i class="las la-sign-in-alt"></i>
                                            Login
                                        </a>
                                        <a class="nav-link" href="{{ url('register') }}">
                                            <i class="las la-user-plus"></i>
                                            Register
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link vprofile" href="javascript:void(0);" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php
                                    $path = asset('vendor-assets/images/profile.png');
                                    if (Auth::user()->profile_image != '') {
                                        $path = asset('uploads/profile/' . Auth::user()->profile_image);
                                    }
                                    ?>
                                    <img src="{{ $path }}">
                                    <span>{{ Auth::user()->name }}<br><span>{{ Auth::user()->email }}</span></span>
                                </a>
                            </li>
                            
                               <?php
                                    $total_unread = 0;
                                    $get_notifications = get_notifications(Auth::user()->id);
                                    if ($get_notifications['status'] == true) {
                                        $total_unread = $get_notifications['data']['total_unread'];
                                    }
                                    ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle notification asread isread" href="javascript:void(0);"
                                    id="navbarDropdownBell" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="las la-bell "></i>
                                    @if($total_unread > 0)
                                            <span  style="background:red">{{ $total_unread }}</span>
                                        @endif
                                </a>
                                <ul class="dropdown-menu notiheader" aria-labelledby="navbarDropdownBell">
                                    <div class="menu-heads">
                                        <h3>Notifications</h3>
                                        <!--<p>-->
                                        <!--    <a href="{{ url('home') }}"><i class="las la-ellipsis-h"></i></a>-->
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
                                                <div class="notpro  ">
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
                                <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarDropdowns"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('assets/images/bar.png') }}">
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdowns" id="maindropdowns">
                                    <div class="menu-heads">
                                        <h3>Menu</h3>
                                    </div>
                                    <li>
                                        <?php
                                        $path = asset('vendor-assets/images/profile.png');
                                        if (Auth::user()->profile_image != '') {
                                            $path = asset('uploads/profile/' . Auth::user()->profile_image);
                                        }
                                        ?>
                                        <a class="nav-link" href="javascript:void(0);" data-bs-toggle="modal"
                                            data-bs-target="#editpro">
                                            <img src="{{ $path }}" style="max-width:40px;" class="dark">
                                            <img src="{{ $path }}" style="max-width:40px;" class="white">
                                            Profile</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ url('cart') }}">
                                            <img src="{{ asset('assets/images/party-icon.png') }}" class="dark">
                                            <img src="{{ asset('assets/images/party-white.png') }}" class="white">
                                            My Parties</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="javascript:void(0);" data-bs-toggle="modal"
                                            data-bs-target="#organizeparty">
                                            <img src="{{ asset('assets/images/plus.png') }}" class="dark">
                                            <img src="{{ asset('assets/images/plus-white.png') }}" class="white">
                                            Organize Party</a>
                                    </li>
                                    <li>
                                        <a class="nav-link open-notification" href="javascript:void(0);">
                                            <img src="{{ asset('assets/images/notification.png') }}" class="dark">
                                            <img src="{{ asset('assets/images/notification-white.png') }}"
                                                class="white">
                                            Notifications</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                        <a class="nav-link" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <img src="{{ asset('assets/images/logout.png') }}" class="dark">
                                            <img src="{{ asset('assets/images/logout-white.png') }}" class="white">
                                            Logout</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    @endif

    <div class="modal fade" id="organizeparty" tabindex="-1" aria-labelledby="editproLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editproLabel">Let's organize<br>your party</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Let us serve you better (fill up all the details needed).</p>
                    <form action="{{ route('createEvent') }}" name="main-create-event" method="POST"
                        onsubmit="return false;"> 
                        @csrf 
                        <input type="hidden" name="id" value="" />
                        <input type="text" name="title" class="form-control mb-4"
                            placeholder="Add a title of the event">
                        <div class="input-group mb-4">
                            <span class="input-group-append input-group-addon">
                                <span class="input-group-text"><i class="las la-map-marker"></i></span>
                            </span>
                            <input type="text" name="location" id="txtPlaces" class="form-control  "
                                placeholder="Add location of the party"> 
                                <input type="hidden" id="lat" name="lat" />
                                <input type="hidden" id="lng" name="lng" />
                        </div>
                        <div class="row">
                            <div class="col-6 pe-0">
                                <div class="input-group date" id="datepicker">
                                    <span class="input-group-append input-group-addon rounded-0">
                                        <span class="input-group-text"><i class="las la-calendar"></i></span>
                                    </span>
                                    <input class="form-control" name="event_date" placeholder="MM/DD/YYYY" readonly>
                                </div>
                            </div>
                            <div class="col-6 ps-0">
                                <div class="input-group date" id="datepicker_to">
                                    <span class="input-group-append input-group-addon rounded-0">
                                        <span class="input-group-text"><i class="las la-calendar"></i></span>
                                    </span>
                                    <input class="form-control" name="event_to_date" placeholder="MM/DD/YYYY"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        @php
                            use App\Helpers\Helper;
                            $helper = new Helper();
                            $subCategory = $helper->getSubCategory();
                        @endphp
                        <div class="input-group category  mt-4">
                            <span class="input-group-append input-group-addon">
                                <span class="input-group-text"><i class="las la-fire-alt"></i></span>
                            </span>
                            {{-- <input type="text" name="category" class="form-control" placeholder="Add category"> --}}
                            <select class="form-control" name="category">
                              <option value="">Select Category</option>
                                @foreach ($subCategory as $category)
                                <option value="{{ $category['id'] }}">
                                    {{ $category['category_name'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-gradient"><span
                                class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span> Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script type="text/javascript">
        function initialize() {
            var input = document.getElementById('txtPlaces');
           
            var autocomplete = new google.maps.places.Autocomplete(input);

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

    <script>
        $(document).ready(function() {
            $('.asread').on('click', function() {
                $.ajax({
                    url: '/mark-as-read', // Update this URL to your actual route
                    method: 'POST',
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
