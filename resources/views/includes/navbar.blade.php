<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <div class="navbar-header">
        <a href="/" class="navbar-brand">HFMD Real-time Case Reporting System</a>
    </div>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Home -->
        <li class="nav-item">
            <a class="nav-link" href="/" role="button" aria-haspopup="true" aria-expanded="false">
                <table>
                    <tr><td><div class="col">
                        <i class="fas fa-home fa-lg"></i>
                    </div></td></tr>
                    <tr><td><div class="col">Home</div></td></tr>
                </table>
            </a>


        </li>

        <!-- Nav Item - Report -->
        <li class="nav-item">
            <a class="nav-link " href="{{ url('/report/create') }}" role="button" aria-haspopup="true" aria-expanded="false">
                <table>
                    <tr>
                        <td>
                            <div class="col">
                                <i class="fas fa-file-medical fa-lg"></i>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="col">Report</div>
                        </td>
                    </tr>
                </table>
            </a>
        </li>

        <!-- Nav Item - Symptoms -->
        <li class="nav-item">
            <a class="nav-link " href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <table>
                    <tr>
                        <td>
                            <div class="col">
                                <i class="fas fa-briefcase-medical fa-lg"></i>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="col">Symptoms</div>
                        </td>
                    </tr>
                </table>
            </a>
        </li>

        <!-- Nav Item - Hospital -->
        <li class="nav-item">
            <a class="nav-link " href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <table>
                    <tr>
                        <td>
                            <div class="col">
                                <i class="fas fa-hospital fa-lg"></i>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="col">Hospital</div>
                        </td>
                    </tr>
                </table>
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        @if(Auth::guest())
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link " href="{{ url('/login') }}" role="button" aria-haspopup="true" aria-expanded="false">Login
                <img class="img-profile rounded-circle" height="60" width="60" src="{{asset('images/person-circle-outline.svg')}}">
                </a>
            </li>
        @else
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                <img class="img-profile rounded-circle" src="{{asset('images/person-circle-outline.svg')}}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    {{__('Logout')}}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
                    @csrf
                </form>
            </div>
        </li>
        @endif
    </ul>

</nav>
<!-- End of Topbar -->
