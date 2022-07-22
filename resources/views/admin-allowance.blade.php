@extends('layouts.main-head')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Allowance Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Master Allowance Management</li>
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
                            <h3>{{ $leavestat_cnt }}</h3>

                            <p>Number of Allowance</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <section class="col-lg-6 connectedSortable">

                    <!-- Map card -->
                    <div class="card ">
                        <div class="card-header border-0">
                            <h3 class="card-title">

                                Add Allowance
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
                                <form method="POST" action="{{ route('allowance-management.store') }}">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="">Allowance</label>
                                            <input type="text" class="form-control"
                                                id="allwname" name="allwname"
                                                placeholder="Allowance"
                                                value="" required>
                                            <label for="">Allowance Desciption</label>
                                            <input type="text" class="form-control"
                                                id="allwdesc" name="allwdesc"
                                                placeholder="Allowance Desciption"
                                                value="" required>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit"
                                                    class="btn btn-primary">Submit</button>
                                            </div>
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
                                View Leave Status
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
                                            <th>Allowance</th>
                                            <th>Allowance Description</th>
                                            <th>Applicable To</th>
                                            <th>Edit</th>
                                            <th style="width: 40px">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allwndatas as $allwndatas)
                                        <tr class="mytr">
                                            <td>{{ $allwndatas->aid }}</td>
                                            <td>{{ $allwndatas->allwn }}</td>
                                            <td>{{ $allwndatas->allwn_desc }}</td>
                                            <td>{{ $allwndatas->name }}</td>
                                            <td>
                                                <button class="btn btn-block btn-warning" href="#" data-toggle="modal"
                                                    data-target="#modal-default2{{ $allwndatas->aid }}">Edit</button>
                                            </td>
                                            <td>
                                                <form method="post" class="btn btn-block btn-danger"
                                                    action="{{ route('allowance-management.destroy', [$allwndatas->aid]) }}">
                                                    {{ csrf_field() }}
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">DELETE</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="modal-default2{{ $allwndatas->aid }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Tour Details</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('allowance-management.update', [$allwndatas->aid]) }}">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="">Allowance</label>
                                                                    <input type="text" class="form-control"
                                                                        id="allwname_upd" name="allwname_upd"
                                                                        placeholder="Allowance"
                                                                        value="{{ $allwndatas->allwn }}" required>
                                                                    <label for="">Allowance Desciption</label>
                                                                    <input type="text" class="form-control"
                                                                        id="allwdesc_upd" name="allwdesc_upd"
                                                                        placeholder="Allowance Desciption"
                                                                        value="{{ $allwndatas->allwn_desc }}" required>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Update</button>
                                                                    </div>
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

<script src="{{ asset('js/admin-allowance.js') }}"></script>

@endsection
