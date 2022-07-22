<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MSSDS E OFFICE</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css.map') }}" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <!-- Datatable plugin CSS file -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link href="{{ asset('assets/home-page/img/favicon.ico.png') }}" rel="icon">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('build/scss/plugins/_jqvmap.scss') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js">
    </script>
    <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <script type="text/javascript" src="{{ asset('js/main-head.js') }}"></script>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->

                <!-- Messages Dropdown Menu -->
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">MSSDS E OFFICE</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="" id="mydetailss" class="d-block" data-toggle="modal" data-target="#modal-users"
                            data-id="{{ $mydets->id }}">
                            {{ $mydets->name }}
                        </a>
                    </div>
                </div>
                <!-- SidebarSearch Form -->
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @if((Auth::user()->account_type == "admin"))
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-check-square"></i>
                                <p>
                                    Master List
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('master-office.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-user-circle"></i>
                                        <p>
                                            Office
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('master-department.index') }}" class="nav-link">
                                        <i class="nav-icon far fa-image"></i>
                                        <p>
                                            Departments
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>
                                            Leave
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            {{-- <a href="{{ route('master-leavetype.index') }}" class="nav-link"> --}}
                                                <a href="{{ route('master-leave-type.index') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Leave Type</p>
                                                </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('master-leave-stat.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Leave Status</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('master-leavetype.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Assign Leave to Office</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('master-user.index') }}" class="nav-link">
                                        <i class="nav-icon far fa-image"></i>
                                        <p>
                                            Manage User Accounts
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if ((Auth::user()->account_type == "approvauth")||(Auth::user()->account_type == "admin"))
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    View Employee Leaves
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('master-leave-applist.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-user-circle"></i>
                                        <p>
                                            New Leave
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('accepted-leave-stat') }}" class="nav-link">
                                        <i class="nav-icon fas fa-user-circle"></i>
                                        <p>
                                            Approved Leaves
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('rejected-leave-stat') }}" class="nav-link">
                                        <i class="nav-icon fas fa-user-circle"></i>
                                        <p>
                                            Rejected Leaves
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if ((Auth::user()->account_type != "admin"))
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    View My Applied Leaves
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('AppliedLeave') }}" class="nav-link">
                                        <i class="nav-icon fas fa-user-circle"></i>
                                        <p>
                                            New Leave
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('AcceptedAppliedLeave') }}" class="nav-link">
                                        <i class="nav-icon fas fa-user-circle"></i>
                                        <p>
                                            Approved Leaves
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('CancelledAppliedLeave') }}" class="nav-link">
                                        <i class="nav-icon fas fa-user-circle"></i>
                                        <p>
                                            Cancelled Leaves
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('RejectedAppliedLeave') }}" class="nav-link">
                                        <i class="nav-icon fas fa-user-circle"></i>
                                        <p>
                                            Rejected Leaves
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if ((Auth::user()->account_type != "admin"))
                        <li class="nav-item">
                            <a href="{{ route('ApplyLeave') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>
                                    Apply Leave
                                </p>
                            </a>
                        </li>
                        @endif
                        @if((Auth::user()->account_type == "approvauth")||(Auth::user()->account_type == "admin"))
                        <li class="nav-item">
                            <a href="{{ route('list-of-employee-leave') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>
                                    List Of Employee Leaves
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('EmployeeLeaveSummary') }}" class="nav-link">
                                <i class="nav-icon far fa-image"></i>
                                <p>
                                    Employee leave summary
                                </p>
                            </a>
                        </li>
                        @endif
                        @if((Auth::user()->account_type == "admin")||(Auth::user()->account_type == "approvauth"))
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    Tour Programme
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if (Auth::user()->account_type == "admin")
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-check-square"></i>
                                        <p>
                                            Master List
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            {{-- <a href="{{ route('master-leavetype.index') }}" class="nav-link"> --}}
                                                <a href="{{ route('tour-management.index') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Tour Programme</p>
                                                </a>
                                        </li>
                                        <li class="nav-item">
                                            {{-- <a href="{{ route('master-leavetype.index') }}" class="nav-link"> --}}
                                                <a href="{{ route('allowance-management.index') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Allowance</p>
                                                </a>
                                        </li>
                                    </ul>
                                </li>
                                @endif
                                @if (Auth::user()->account_type == "approvauth")
                                <li class="nav-item">
                                    {{-- <a href="{{ route('master-leavetype.index') }}" class="nav-link"> --}}
                                        <a href="{{ route('depute-staff.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Depute Staff</p>
                                        </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if (Auth::user()->account_type != "admin")
                        <li class="nav-item">
                            {{-- <a href="{{ route('master-leavetype.index') }}" class="nav-link"> --}}
                                <a href="{{ route('deput-duties') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Depute Duties</p>
                                </a>
                        </li>
                        @endif
                        @if (Auth::user()->account_type != "admin")
                        <li class="nav-item">
                            {{-- <a href="{{ route('master-leavetype.index') }}" class="nav-link"> --}}
                                <a href="{{ route('request-tour.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>My Tour Request</p>
                                </a>
                        </li>
                        @endif
                        @if ((Auth::user()->account_type == "approvauth"))
                        <li class="nav-item">
                            {{-- <a href="{{ route('master-leavetype.index') }}" class="nav-link"> --}}
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-chart-pie"></i>
                                    <p>
                                        Manage Tour Request
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('manage-tour') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>New Tour Request</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('approved-tour') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Approved Tour Request</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('rejected-tour') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Rejected Tour Request</p>
                                        </a>
                                    </li>
                                </ul>
                        </li>
                        @endif
                        @if((Auth::user()->account_type == "account"))
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    View Tour Report
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('employees-tour.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-copy"></i>
                                        <p>
                                            New Tour Report
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (Auth::user()->account_type != "admin")
                        <li class="nav-item">
                            <a href="{{ route('tour-report.index') }}" class="nav-link">
                                <i class="far fa-copy nav-icon"></i>
                                <p>My Tour Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('my-daily-activities.index') }}" class="nav-link">
                                <i class="far fa-calendar nav-icon"></i>
                                <p>My Daily Activities</p>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->account_type == "approvauth")
                        <li class="nav-item">
                            <a href="{{ route('view-daily-activities.index') }}" class="nav-link">
                                <i class="far fa-calendar nav-icon"></i>
                                <p>Employees Daily Activities</p>
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        @yield('content')
        <!-- Content Wrapper. Contains page content -->

        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="#">MSSDS</a>.</strong> All rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <div class="modal fade" id="modal-users">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">My Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="UpdUserForm" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <input type="hidden" name="f1" id="f1" value="1">
                                <label for="">User Name</label>
                                <input type="text" class="form-control" name="uname" id="uname" placeholder="User Name"
                                value="{{$mydets->name }}" required>
                            </div>
                            {{-- <input id="timepicker1" type="text"
                                class="form-control bootstrap-timepicker timepicker input-small">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span> --}}

                            <div class="form-group">
                                <label for="">Gender</label>
                                <select class="form-control" name="gend" id="gend" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Designation</label>
                                <input type="text" class="form-control" name="desg" id="desg" placeholder="Designation"
                                    value="{{$mydets->desg }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Employee Id</label>
                                <input type="text" class="form-control" name="empid" id="empid"
                                    placeholder="Employee Id" value="{{$mydets->emp_id }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Office Name</label>
                                <select class="form-control" name="officename" id="officename" required>
                                    <option value="">Select Office</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Department Name</label>
                                <select class="form-control" name="depname" id="depname" required>
                                    <option value="">Select Department</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">User Email Id</label>
                                <input type="email" class="form-control" name="umail" id="umail"
                                    placeholder="User Email Id" value="{{$mydets->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">New Password</label>
                                <input type="password" class="form-control" name="upwd" id="upwd"
                                    placeholder="New Password" value="">
                            </div>
                            <div class="form-group">
                                <label for="">Confirm New Password</label>
                                <input type="password" class="form-control" name="ucpwd" id="ucpwd"
                                    placeholder="Confirm New Password" value="">
                            </div>
                        </div>
                        <div class="registrationFormAlert" id="divCheckPasswordMatch">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="usrbtn" class="btn btn-primary">Update</button>
                        </div>
                        <!-- /.card-body -->
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js">
    </script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
    </script>
    <script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
    {{-- <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script> --}}
    {{-- <script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script> --}}
    {{-- --}}
    <script src="{{ asset('js/file-validation.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    {{-- <script type="text/javascript">
        $('#timepicker1').timepicker();
    </script> --}}
    <script type="text/javascript">
        $('#arritime').timepicker();
    </script>
    <script type="text/javascript">
        $('#deptime').timepicker();
    </script>
</body>

</html>
