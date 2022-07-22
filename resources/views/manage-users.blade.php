@extends('layouts.main-head')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Users</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <p>Number of Users</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->

                <!-- ./col -->

                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->

                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-6 connectedSortable">

                    <!-- Map card -->
                    <div class="card ">
                        <div class="card-header border-0">
                            <h3 class="card-title">

                                Add User
                            </h3>
                            <!-- card tools -->
                            <div class="card-tools">

                                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse"
                                    title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <div class="card-body">
                            <div style="height: 100%; width: 100%;">
                                {{-- <form method="POST" action="{{ route('master-prof.store') }}"> --}}
                                    <form method="POST" action="{{ route('master-user.store') }}">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail Address') }}</label>
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="gendx" id="gendx" required>
                                                <option value="">Select Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"> --}}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Designation') }}</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control"
                                            name="desgx" id="desgx"
                                            placeholder="Designation"
                                            value="" required>
                                            {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"> --}}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Employee Id') }}</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control"
                                            name="empidx" id="empidx"
                                            placeholder="Employee Id"
                                            value="" required>
                                            {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"> --}}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Office Name') }}</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="officenamex" id="officenamex" required>
                                                <option value="">Select Office</option>
                                                @foreach ($officedets as $officedets)
                                                    <option value="{{ $officedets->id }}">{{ $officedets->office_name }}</option>
                                                @endforeach
                                            </select>
                                            {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"> --}}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Department Name') }}</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="depnamex" id="depnamex" required>
                                                <option value="">Select Department</option>
                                            </select>
                                            {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"> --}}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Account Type') }}</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="acctype" id="acctype" required>
                                                <option value="">Select Account Type</option>
                                                <option value="user">User</option>
                                                <option value="approvauth">Approving Authority</option>
                                                <option value="account">Accounts</option>
                                            </select>
                                            {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"> --}}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Register') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-body-->

                    </div>
                    <!-- /.card -->

                    <!-- solid sales graph -->

                    <!-- /.card -->

                    <!-- Calendar -->

                    <!-- /.card -->
                </section>
                <section class="col-lg-6 connectedSortable">

                    <!-- Map card -->
                    <div class="card ">
                        <div class="card-header border-0">
                            <h3 class="card-title">

                                View Users
                            </h3>
                            <!-- card tools -->
                            <div class="card-tools">

                                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse"
                                    title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <div class="card-body">
                            <div style="height: 100%; width: 100%; overflow-x:scroll" >
                                <table id="tableID" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            {{-- <th style="width: 10px">#</th> --}}
                                            <th>User Name</th>
                                            <th>Email Id</th>
                                            <th>Office Name</th>
                                            <th>Department Name</th>
                                            <th>User Type</th>
                                            <th>Edit Permission</th>
                                            <th>Edit User Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($userdets as $userdet)
                                            <tr class="mytr">
                                                {{-- <td>{{ $userdet->id }}</td> --}}
                                                <td>{{ $userdet->name }} </td>
                                                <td>{{ $userdet->email }} </td>
                                                <td>{{ $userdet->office_name }} </td>
                                                <td>{{ $userdet->dept_name }} </td>
                                                <td>{{ $userdet->account_type }} </td>
                                                <td>
                                                    <button class="btn btn-block btn-warning editacc" href="#" data-toggle="modal"
                                                        data-target="#modal-default2x" data-id="{{ $userdet->id }}">Edit User type</button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-block btn-warning editusrdata" href="#" data-toggle="modal"
                                                        data-target="#modal-editusrdata" data-id="{{ $userdet->id }}">Edit User Data</button>
                                                </td>
                                            </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="modal fade" id="modal-editusrdata">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">My Details</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="UpdUserDataFormx" method="POST">
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="">User Name</label>
                                                            <input type="hidden" name="f1" id="f1" value="2">
                                                            <input type="text" class="form-control"
                                                                name="usr_uname" id="usr_uname"
                                                                placeholder="User Name"
                                                                value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Gender</label>
                                                            <select class="form-control" name="usr_gend" id="usr_gend" required>
                                                                <option value="">Select Gender</option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Designation</label>
                                                            <input type="text" class="form-control"
                                                                name="usr_desg" id="usr_desg"
                                                                placeholder="User Name"
                                                                value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Employee Id</label>
                                                            <input type="text" class="form-control"
                                                                name="usr_empid" id="usr_empid"
                                                                placeholder="Employee Id"
                                                                value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Office Name</label>
                                                            <select class="form-control" name="usr_officename" id="usr_officename" required>
                                                                <option value="">Select Office</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Department Name</label>
                                                            <select class="form-control" name="usr_depname" id="usr_depname" required>
                                                                <option value="">Select Department</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">User Email Id</label>
                                                            <input type="email" class="form-control"
                                                                name="usr_umail" id="usr_umail"
                                                                placeholder="User Email Id"
                                                                value="" required>
                                                        </div>
                                                        </div>
                                                            <div class="registrationFormAlert" id="divCheckPasswordMatch">
                                                            </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                        <!-- /.card-body -->
                                                </form>
                                            </div>

                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div class="modal fade" id="modal-default2x">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">My Details</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    id="updateuserinfos">
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <input type="hidden" name="usridd" id="usridd">
                                                            <label for="user_acc">User Type</label>
                                                            <select class="form-control" name="user_acc_upd" id="user_acc_upd" required>
                                                                <option value="">Select Permission</option>
                                                                <option value="user">User</option>
                                                                <option value="approvauth">Approving Authority</option>
                                                                <option value="account">Accounts</option>
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Update</button>
                                                        </div>
                                                        <!-- /.card-body -->
                                                </form>
                                            </div>

                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                {{-- --}}
                            </div>
                        </div>
                    </div>
                    <script src="{{ asset('js/manage-users.js') }}"></script>
                </section>
            </div>
        </div>
    </section>
</div>



@endsection
