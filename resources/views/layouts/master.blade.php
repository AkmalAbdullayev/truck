<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>TruckLoads</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i') }} "
          rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css')  }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('plugins/alertify/css/alertify.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/alertify/css/themes/default.min.css')}}">
    <link href="{{ asset('css/custom.css')  }}" rel="stylesheet">
    @stack('css')
</head>
<body id="page-top">
<div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa fa-truck"></i>
            </div>
            <div class="sidebar-brand-text mx-3"> TruckLoads</div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
            <a class="nav-link" href="{{route('home')}}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <hr class="sidebar-divider">
        @if (auth()->user()->roles->name != "dispatcher" && auth()->user()->roles->name != "director")
            <li class="nav-item">
                <a class="nav-link" href="{{ route("company.index") }}">
                    <i class="fas fa-building fa-building-area"></i>
                    <span>Companies</span>
                </a>
            </li>
        @endif
        @if (auth()->user()->roles->name != "dispatcher" && auth()->user()->roles->name != "director")
            <li class="nav-item">
                <a class="nav-link" href="{{ route("user.index") }}">
                    <i class="fas fa-user fa-user-area"></i>
                    <span>Users</span>
                </a>
            </li>
        @endif
        @if (auth()->user()->roles->name != "admin")
            <li class="nav-item">
                <a class="nav-link" href="{{ route("truck.index") }}">
                    <i class="fas fa-truck fa-truck-area"></i>
                    <span>Trucks</span>
                </a>
            </li>
        @endif
        @if (auth()->user()->roles->name != "admin")
            <li class="nav-item">
                <a class="nav-link" href="{{ route("truckdriver.index") }}">
                    <i class="fas fa-truck fa-truck-area"></i>
                    <span>Truck Drivers</span>
                </a>
            </li>
        @endif

        @if (auth()->user()->roles->name != "dispatcher" && auth()->user()->roles->name != "director")
            <li class="nav-item">
                <a class="nav-link" href="{{ route("drivertype.index") }}">
                    <i class="fas fa-user fa-user-area"></i>
                    <span>Driver Types</span>
                </a>
            </li>
        @endif

        @if (auth()->user()->roles->name != "admin")
            <li class="nav-item">
                <a class="nav-link" href="{{ route("driver.index") }}">
                    <i class="fas fa-user fa-user-area"></i>
                    <span>Driver</span>
                </a>
            </li>
        @endif

        @if (auth()->user()->roles->name != "dispatcher" && auth()->user()->roles->name != "director")
            <li class="nav-item">
                <a class="nav-link" href="{{ route("status.index") }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Status</span>
                </a>
            </li>
        @endif

        @if (auth()->user()->roles->name != "admin")
            <li class="nav-item">
                <a class="nav-link" href="{{ route("order.index") }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Order</span>
                </a>
            </li>
        @endif

        <hr class="sidebar-divider d-none d-md-block">
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                               aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                             aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                           placeholder="Search for..." aria-label="Search"
                                           aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                    <div class="topbar-divider d-none d-sm-block"></div>

                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                            <img class="img-profile rounded-circle" src={{ asset("img/truck.jpg") }}>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="m-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div id="app">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- End of Main Content -->

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="{{ route("logout") }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; TruckLoads {{date('Y')}}</span>
                </div>
            </div>
        </footer>
    </div>
</div>
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{asset('plugins/alertify/alertify.min.js')}}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
@stack('js')
@include('partials._notify')
</body>
</html>
