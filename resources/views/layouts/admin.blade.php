<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Panel Happy Drugs :)</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/easy-autocomplete.min.css') }}" rel="stylesheet">
{{--    <link href="{{ asset('css/easy-autocomplete.min.themes.css') }}" rel="stylesheet">--}}

<!--  Material Dashboard CSS    -->
    <link href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet">

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
</head>

<body>

<div class="wrapper">

    <div class="sidebar" data-color="orange" data-image="../assets/img/sidebar-1.jpg">
        <!--
            Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

            Tip 2: you can also add an image using data-image tag
        -->

        <div class="logo">
            <a href="/" class="simple-text">
                Happy Drugs
            </a>
        </div>

        <div class="sidebar-wrapper">
            <ul class="nav">
                <li class="{{ Request::segment(2)==='home' ? 'active' : ''}}">
                    <a href="{{ url('admin/home') }}">
                        <i class="material-icons">dashboard</i>
                        <p>Tablica</p>
                    </a>
                </li>
                <li class="{{ Request::segment(2)==='users' ? 'active' : ''}}">
                    <a href="{{ url('admin/users') }}">
                        <i class="material-icons">group</i>
                        <p>Użytkownicy</p>
                    </a>
                </li>
                <li class="{{ Request::segment(2)==='cabinets' ? 'active' : ''}}">
                    <a href="{{ url('admin/cabinets') }}">
                        <i class="material-icons">local_hospital</i>
                        <p>Apteczki</p>
                    </a>
                </li>
                <li class="{{ Request::segment(2)==='drugs' ? 'active' : ''}}">
                    <a href="{{ url('admin/drugs') }}">
                        <i class="material-icons">local_pharmacy</i>
                        <p>Leki</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-transparent navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="material-icons">person</i>
                                Hello, {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">


            </div>
        </footer>
    </div>
</div>

</body>
@yield('modal')

<!--   Core JS Files   -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/material.min.js') }}"></script>
<script src="{{ asset('js/chartist.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-notify.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<script src="{{ asset('js/material-dashboard.js') }}"></script>


<script type="text/javascript">
    $(document).ready(function(){
        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

    });
</script>
@yield('scripts')
</html>
