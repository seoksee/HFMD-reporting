<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-sidebar nav-header">
                    <a href="{{route('admin')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{__('Admin')}}</p>
                    </a>
                </li>
                <hr class="sidebar-divider">
                <hr>
                {{-- <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>{{__('Overview')}}</p>
                    </a>
                </li> --}}
                <li class="nav-item has-treeview">
                    <a href="{{route('admin.report.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>{{__('Report')}}</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('admin.notifications.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-lightbulb"></i>
                        <p>{{__('Notifications')}}</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('admin.manageUsers.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>{{__('Manage Users')}}</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('admin.symptoms.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-syringe"></i>
                        <p>{{__('Symptoms')}}</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
