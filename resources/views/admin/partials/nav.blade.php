<header class="main-header">
    <a href="#" class="logo">
        <span class="logo-mini"><b>E L</b></span>
        <span class="logo-lg"><b>E-Learning</b></span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ Session::get('login')->data->photo }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">
                            {{ Session::get('login')->data->name }}
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{ Session::get('login')->data->photo }}" class="user-circle" alt="User Image">
                            <p>
                                {{ Session::get('login')->data->name }}
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{route('admin.user.profile')}}" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('auth.logout') }}" class="btn btn-default btn-flat">Logout</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>