@extends('layouts.main-head')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Office</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Master Office</li>
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
                            <h3>{{ $office_cnt }}</h3>

                            <p>Number of offices</p>
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

                                Add Offices
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
                                <form method="POST" action="{{ route('master-office.store') }}">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Office Name</label>
                                            <input type="text" class="form-control" id="" name="officename"
                                                placeholder="Office Name" value="">
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
                                            <th>Edit</th>
                                            <th style="width: 40px">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($office_datas as $office_data)
                                            <tr class="mytr">
                                                <td>{{ $office_data->id }}.</td>
                                                <td>{{ $office_data->office_name }}</td>
                                                <td>
                                                    <button class="btn btn-block btn-warning" href="#" data-toggle="modal"
                                                        data-target="#modal-default2{{ $office_data->id }}">Edit</button>
                                                </td>
                                                <td>
                                                    <form method="post" class="btn btn-block btn-danger"
                                                        action="{{ route('master-office.destroy', [$office_data->id]) }}">
                                                        {{ csrf_field() }}
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')">DELETE</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="modal-default2{{ $office_data->id }}">
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
                                                                action="{{ route('master-office.update', [$office_data->id]) }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">Office Name</label>
                                                                        <input type="text" class="form-control"
                                                                            name="office_upd_name" id=""
                                                                            placeholder="Office Name"
                                                                            value="{{ $office_data->office_name }}">
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
