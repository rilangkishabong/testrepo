@extends('layouts.main-head')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                            <h3></h3>

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

                                View Offices
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
                            <div id="world-map" style="height: 100%; width: 100%;">
                                <table id="tableID" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>User Name</th>
                                            <th>User Type</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($userdets as $userdet)
                                            <tr class="mytr">
                                                <td>{{ $userdet->id }}</td>
                                                <td>{{ $userdet->name }} </td>
                                                <td>{{ $userdet->account_type }} </td>
                                                <td>
                                                    <button class="btn btn-block btn-warning" href="#" data-toggle="modal"
                                                        data-target="#modal-default2{{ $userdet->id }}">Edit</button>
                                                </td>
                                                <td>
                                                    <form method="post" class="btn btn-block btn-danger"
                                                        action="{{ route('user-management.destroy', [$userdet->id]) }}">
                                                        {{ csrf_field() }}
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')">DELETE</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="modal-default2{{ $userdet->id }}">
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
                                                                action="{{ route('user-management.update', [$userdet->id]) }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label for="user_name">User Name</label>
                                                                        <input type="text" class="form-control"
                                                                            name="user_name" id="user_name"
                                                                            placeholder="User Name"
                                                                            value="{{ $userdet->name }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="user_acc">User Type</label>
                                                                        <select class="form-control" name="user_acc" id="user_acc">
                                                                            <option value="">Select Permission</option>
                                                                            <option value="officeassistant">Office Assistant</option>
                                                                            <option value="teacher">Teacher</option>
                                                                            <option value="denied">Denied</option>
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
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- --}}
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">

                    <!-- Map card -->
                    <div class="card ">
                        <div class="card-header border-0">
                            <h3 class="card-title">

                                View Offices
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
                            <div id="world-map" style="height: 100%; width: 100%;">
                                <table id="tableID" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>User Name</th>
                                            <th>User Type</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($userdets as $userdet)
                                            <tr class="mytr">
                                                <td>{{ $userdet->id }}</td>
                                                <td>{{ $userdet->name }} </td>
                                                <td>{{ $userdet->account_type }} </td>
                                                <td>
                                                    <button class="btn btn-block btn-warning" href="#" data-toggle="modal"
                                                        data-target="#modal-default2{{ $userdet->id }}">Edit</button>
                                                </td>
                                                <td>
                                                    <form method="post" class="btn btn-block btn-danger"
                                                        action="{{ route('user-management.destroy', [$userdet->id]) }}">
                                                        {{ csrf_field() }}
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')">DELETE</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="modal-default2{{ $userdet->id }}">
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
                                                                action="{{ route('user-management.update', [$userdet->id]) }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label for="user_name">User Name</label>
                                                                        <input type="text" class="form-control"
                                                                            name="user_name" id="user_name"
                                                                            placeholder="User Name"
                                                                            value="{{ $userdet->name }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="user_acc">User Type</label>
                                                                        <select class="form-control" name="user_acc" id="user_acc">
                                                                            <option value="">Select Permission</option>
                                                                            <option value="officeassistant">Office Assistant</option>
                                                                            <option value="teacher">Teacher</option>
                                                                            <option value="denied">Denied</option>
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
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- --}}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>
@endsection
