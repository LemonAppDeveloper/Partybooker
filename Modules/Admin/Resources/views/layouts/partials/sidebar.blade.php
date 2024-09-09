<div class="navigation-menu-body">
    <div class="navigation-menu-group">
        <div class="open" id="dashboards">
            <ul>
                <li><a href="{{URL::to('admin/dashboard')}}">Dashboard</a></li>
                <li><a href="{{URL::to('admin/users')}}">User Management</a></li>
                <li><a href="{{URL::to('admin/vendors')}}">Vendor Management</a></li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>