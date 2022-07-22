@extends('layouts.main-head')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Apply Leave</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Apply Leave</li>
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
                            <p>Apply Leave</p>
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
                <!-- Left col -->

                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-12 connectedSortable">

                    <!-- Map card -->
                    <div class="card ">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                Apply Leave
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
                                <form method="POST" action="{{ route('master-leave-applist.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Employee Id</label>
                                            <input type="text" class="form-control" id="empid" name="empid"
                                                value="{{ $mydets->emp_id }}" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Employee Name</label>
                                            <input type="text" class="form-control" id="empname" name="empname"
                                                value="{{ $mydets->name }}" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Gender</label>
                                            <input type="text" class="form-control" id="gend" name="gend"
                                                value="{{ $mydets->sex }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">Department</label>
                                            <input type="text" class="form-control" id="" name=""
                                                value="{{ $department }}" readonly>
                                                <input type="hidden" class="form-control" id="deptname" name="deptname"
                                                value="{{ $mydets->dept_id }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Designation</label>
                                            <input type="text" class="form-control" id="desg" name="desg"
                                                value="{{ $mydets->desg }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="">Available Leave</label>
                                            {!! $tabl !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Date From</label>
                                            <input type="date" class="form-control" id="dtfrm" name="dtfrm"
                                                value="" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Date To</label>
                                            <input type="date" class="form-control" id="dtto" name="dtto"
                                                value="" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">No Of Days</label>
                                            <input type="text" class="form-control" id="nod" name="nod"
                                                value="" required readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">Shift Time</label>
                                            <select type="text" class="form-control" id="shftime" name="shftime">
                                                <option value="">Select Shift</option>
                                                <option value="Half day">Half Day</option>
                                                <option value="Full day">Full Day</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Leave Type</label>
                                            <select class="form-control" name="lvtype" id="lvtype" required>
                                                <option value="">Select Leave Type</option>
                                                @foreach ($leaveavl as $leaveavl)
                                                    <option value="{{ $leaveavl->id }}">{{ $leaveavl->leavename }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="">Reason</label>
                                            <textarea class="form-control" name="lvreason" id="lvreason" cols="30" rows="5" required></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input class="form-control" type="date" name="curdate" id="curdate" value="{{ $cur_date }}" readonly>
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
                </section>
            </div>
        </div>
    </section>
</div>
<script src="{{ asset('js/apply-leave.js') }}"></script>

@endsection
