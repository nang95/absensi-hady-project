<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->

<head>
    <meta charset="utf-8" />
    <title>Aplikasi Absensi| Admin</title>

    <meta name="description" content="Dashboard" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">

    <!--Basic Styles-->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/weather-icons.min.css') }}" rel="stylesheet" />

    <!--Fonts-->
    <link
        href="../fonts.googleapis.com/css@family=open+sans_3a300italic,400italic,600italic,700italic,400,600,700,300.css"
        rel="stylesheet" type="text/css">
    <link href='../fonts.googleapis.com/css@family=roboto_3a400,300.css' rel='stylesheet' type='text/css'>
    <!--Beyond styles-->
    <link id="beyond-link" href="{{ asset('css/beyond.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/demo.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/typicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet" />
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/fontawesome-5.14.0/css/all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom-treeview.css') }}">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    {{-- IMPORTANT THINGS --}}
    <script src="{{ asset('js/skins.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>

    @yield('custom-style')
</head>
<!-- /Head -->
<!-- Body -->

<body>
    <!-- Loading Container -->
    <div class="loading-container">
        <div class="loader"></div>
    </div>
    <!--  /Loading Container -->
    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-inner">
            <div class="navbar-container">
                <!-- Navbar Barnd -->
                <div class="navbar-header pull-left">
                    <a href="#" class="navbar-brand">
                        <div style="display: flex">
                            <img src="{{ asset('img/logo.png') }}" style="width: 35px; height: 35px" alt="" />
                            <div style="padding-left: 5px; width: 100px; font-size: 14px">SMK SWASTA BUDI SETIA</div>
                        </div>
                    </a>
                </div>
                <!-- /Navbar Barnd -->
                <!-- Sidebar Collapse -->
                <div class="sidebar-collapse" id="sidebar-collapse">
                    <i class="collapse-icon fa fa-bars"></i>
                </div>
                <!-- /Sidebar Collapse -->
                <!-- Account Area and Settings --->
                <div class="navbar-header pull-right">`
                    <div class="navbar-account">
                        <ul class="account-area" style="right: 0px">
                            <li style="padding-top: 13px;color:white;font-weight:bold">Hallo,
                                {{ auth()->user()->name }}
                            </li>
                            <li>
                                <a class=" dropdown-toggle" data-toggle="dropdown" title="Notifications" href="#">
                                    <i class="icon glyphicon glyphicon-cog"></i>
                                </a>
                                <!--Notification Dropdown-->
                                <ul class="pull-right dropdown-menu dropdown-arrow dropdown-notifications">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();document.getElementById('logout-form').submit()">
                                            <div class="clearfix">
                                                <div class="notification-icon">
                                                    <i class="fa fa-user bg-themeprimary white"></i>
                                                </div>
                                                <div class="notification-body" style="padding-top: 8px">
                                                    <span class="title">
                                                        Keluar
                                                    </span>
                                                    <form id="logout-form" action="{{ route('logout') }}"
                                                        method="POST" style="display: none">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <!--/Notification Dropdown-->
                                </>
                        </ul>

                    </div>
                </div>
                <!-- /Account Area and Settings -->
            </div>
        </div>
    </div>
    <!-- /Navbar -->
    <!-- Main Container -->
    <div class="main-container container-fluid">
        <!-- Page Container -->
        <div class="page-container">

            <!-- Page Sidebar -->
            <div class="page-sidebar" id="sidebar">
                <!-- Sidebar Menu -->
                @if (auth()->user()->roles()->pluck('name')->first() == 'admin')
                    @include('partials.sidebar_admin')
                @elseif (auth()->user()->roles()->pluck('name')->first() == 'pegawai')
                    @include('partials.sidebar_pegawai')
                @endif
                <!-- /Sidebar Menu -->
            </div>
            <!-- /Page Sidebar -->

            <!-- /Chat Bar -->
            <!-- Page Content -->
            <div class="page-content">
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            @yield('title')
                        </h1>
                    </div>
                    <!--Header Buttons-->
                    <div class="header-buttons">
                        <a class="sidebar-toggler" href="#">
                            <i class="fa fa-arrows-h"></i>
                        </a>
                        <a class="refresh" id="refresh-toggler">
                            <i class="glyphicon glyphicon-refresh"></i>
                        </a>
                        <a class="fullscreen" id="fullscreen-toggler" href="#">
                            <i class="glyphicon glyphicon-fullscreen"></i>
                        </a>
                    </div>
                    <!--Header Buttons End-->
                </div>
                <!-- /Page Header -->
                <!-- Page Body -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            @yield('content')
                        </div>
                    </div>
                </div>
                <!-- /Page Body -->
            </div>
            <!-- /Page Content -->

        </div>
        <!-- /Page Container -->
        <!-- Main Container -->

    </div>

    <!--Basic Scripts-->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
    <!--Beyond Scripts-->
    <script src="{{ asset('js/beyond.js') }}"></script>
    @yield('footer-scripts')
</body>
<!--  /Body -->

</html>
