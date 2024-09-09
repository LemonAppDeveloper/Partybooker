<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module Vendor</title>

    </head>
    <body>
        <div class="navigation-menu-body">
            <div class="navigation-menu-group">
                <div class="open" id="dashboards">
                    <ul>
                        <li><a href="{{URL::to('vendor/dashboard')}}">Dashboard</a></li>
                        <li><a href="{{URL::to('vendor/profile')}}">Profile</a></li>
                        <li><a href="{{URL::to('vendor/booking')}}">Booking Management</a></li>
                        <li><a href="{{URL::to('vendor/customer')}}">Customer Management</a></li>
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @yield('content')
      
    </body>
</html>
