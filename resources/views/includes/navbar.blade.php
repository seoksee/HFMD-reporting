<nav class="navbar navbar-expand-sm navbar-light bg-white mb-4 static-top shadow">
    <button class="btn btn-link d-md-none rounded-circle" type="button" data-toggle="collapse" data-target='#Navbar'>
                <i class="fa fa-bars"></i>
            </button>
        <a href="/" class="navbar-brand d-sm-none ml-auto">HFMD Case Reporting system</a>
        <a href="/" class="navbar-brand d-none d-sm-inline ml-auto">HFMD Real-time Case Reporting System</a>

    <!-- Topbar Navbar -->
    <div class="collapse navbar-collapse" id="Navbar">
    <ul class="navbar-nav ml-auto">
        <div class="row">
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
            <a class="nav-link " href="{{ url('symptoms') }}" role="button" aria-haspopup="true" aria-expanded="false">
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
            <a class="nav-link " href="{{ url('hospitals') }}" role="button" aria-haspopup="true" aria-expanded="false">
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
        <div class="topbar ml-auto">
            @if(Auth::guest())
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link " href="{{ url('/login') }}" role="button" aria-haspopup="true" aria-expanded="false">Login
                <img class="img-profile rounded-circle" height="50" width="50" src="{{asset('images/person-circle-outline.svg')}}">
                </a>
            </li>
        @else
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                <img class="img-profile rounded-circle" height="50" width="50" src="{{asset('images/person-circle-outline.svg')}}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                @if(Auth::user()->isAdmin())
                    <a href="{{route('admin.report.index')}}" class="dropdown-item">
                        <i class="fas fa-users-cog fa-sm fa-fw mr-2 text-gray-400"></i>
                        Go to Admin
                    </a>
                @endif
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
        </div>

        </div>

    </ul>
    </div>
</nav>
<!-- End of Topbar -->
