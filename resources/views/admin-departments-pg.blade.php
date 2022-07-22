@extends('layouts.main-head')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Department</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Master Department</li>
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
                            <h3>{{ $department_cnt }}</h3>

                            <p>Number of Departments</p>
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

                                Add Department
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
                                <form method="POST" action="{{ route('master-department.store') }}">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Office Name</label>
                                            <select type="text" class="form-control" id="inputEmail3" name="officename" required>
                                                <option value="">Select Office</option>
                                                @foreach ($office_datas as $office_data)
                                                    <option value="{{ $office_data->id }}">{{ $office_data->office_name }}</option>
                                                @endforeach
                                            </select>
                                                <label for="exampleInputEmail1">Department Name</label>
                                            <input type="text" class="form-control" id="inputEmail3" name="deptename"
                                                placeholder="Department Name" required>
                                                <label for="exampleInputEmail1">Department Short Name</label>
                                            <input type="text" class="form-control" id="inputEmail3" name="deptename_short"
                                                placeholder="Department Short Name" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-primary">Save changes</button>
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
                            <div style="height: 100%; width: 100%;">
                                <table id="tableID" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Office Name</th>
                                            <th>Department Name</th>
                                            <th>Edit</th>
                                            <th style="width: 40px">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($department_datas as $department_datas)
                                            <tr class="mytr">
                                                <td>{{ $department_datas->id }}.</td>
                                                <td>{{ $department_datas->office_name }}</td>
                                                <td>{{ $department_datas->dept_name }}</td>
                                                <td>
                                                    <button class="btn btn-block btn-warning" href="#" data-toggle="modal"
                                                        data-target="#modal-default2{{ $department_datas->id }}">Edit</button>
                                                </td>
                                                <td>
                                                    <form method="post" class="btn btn-block btn-danger"
                                                        action="{{ route('master-office.destroy', [$department_datas->id]) }}">
                                                        {{ csrf_field() }}
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')">DELETE</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="modal-default2{{ $department_datas->id }}">
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
                                                                action="{{ route('master-department.update', [$department_datas->id]) }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">Office Name</label>
                                                                        <select type="text" class="form-control" id="inputEmail3" name="office_upd_id" required>
                                                                            <option value="">Select Office</option>
                                                                            {{-- array_merge($office_datas,$department_datas) --}}
                                                                            @foreach ($office_datas as $office_data)
                                                                                <option value="{{ $office_data->id }}"{{ $office_data->id == $department_datas->office_id ? 'selected' : '' }}>{{ $office_data->office_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                            <label for="exampleInputEmail1">Department Name</label>
                                                                        <input type="text" class="form-control" id="inputEmail3" name="dept_upd_name"
                                                                            placeholder="Department Name" value="{{ $department_datas->dept_name }}" required>
                                                                            <label for="exampleInputEmail1">Department Short Name</label>
                                                                        <input type="text" class="form-control" id="inputEmail3" name="dept_upd_sname"
                                                                            placeholder="Department Short Name" value="{{ $department_datas->dept_short_name }}" required>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Update</button>
                                                                    </div>
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
