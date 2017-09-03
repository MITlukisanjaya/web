<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class=" {{ active('admin') }}">
                <a href="{{url('/admin')}}">
                    <i class="fa fa-laptop"></i> <span>Dashboard</span>
                </a>
            </li>

@php
    $sessionLogin = Session::get('login')->data;
@endphp

            @if ($sessionLogin->role == 'administrator' || $sessionLogin->role == 'educator')
            <li class="treeview {{ active(['admin/lesson','admin/lesson/*']) }}">
                <a href="#">
                    <i class="fa fa-youtube-play"></i> <span>Lesson</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ active('admin/lesson') }}"><a href="{{url('/admin/lesson')}}"><i class="fa fa-circle-o"></i> List Lesson</a></li>
                    <li class="{{ active('admin/lesson/draft') }}"><a href="{{url('/admin/lesson/draft')}}"><i class="fa fa-circle-o"></i> Draft Lesson</a></li>
                    <li class="{{ active('admin/lesson/create') }}"><a href="{{url('/admin/lesson/create')}}"><i class="fa fa-circle-o"></i> Add Lesson</a></li>
                </ul>
            </li>
            @endif

            @if ($sessionLogin->role == 'administrator' || $sessionLogin->role == 'moderator')
            <li class="treeview {{ active(['admin/article','admin/article/*']) }}">
                <a href="#">
                    <i class="fa fa-pencil-square-o"></i> <span>Articles</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ active('admin/article') }}"><a href="{{url('/admin/article')}}"><i class="fa fa-circle-o"></i> List Articles</a></li>
                    <li class="{{ active('admin/article/draft') }}"><a href="{{url('/admin/article/draft')}}"><i class="fa fa-circle-o"></i> Draft Articles</a></li>
                    <li class="{{ active('admin/article/create') }}"><a href="{{url('/admin/article/create')}}"><i class="fa fa-circle-o"></i> Add Articles</a></li>
                </ul>
            </li>
            @endif

            @if ($sessionLogin->role == 'administrator')
            <li class="treeview {{ active(['admin/user','admin/user/*']) }}">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Users Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ active('admin/user') }}"><a href="{{url('/admin/user')}}"><i class="fa fa-circle-o"></i> List Users</a></li>
                </ul>
            </li>

            <li class="treeview {{ active(['admin/subcription','admin/subcription/*']) }}">
                <a href="#">
                    <i class="fa fa-money"></i> <span>Subcription</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ active('admin/subcription') }}"><a href="{{url('/admin/subcription')}}"><i class="fa fa-circle-o"></i> List Subcription</a></li>
                    <li class="{{ active('admin/transaction') }}"><a href="{{url('/admin/transaction')}}"><i class="fa fa-circle-o"></i> List Transaction</a></li>
                </ul>
            </li>
            @endif

            <li class="treeview {{ active(['admin/profile','admin/profile/*']) }}">
                <a href="#">
                    <i class="fa fa-id-card"></i> <span>Profile</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ active('admin/profile') }}"><a href="{{url('/admin/profile')}}"><i class="fa fa-circle-o"></i> Info Profile</a></li>
                </ul>
            </li>

        </ul>
    </section>
</aside>