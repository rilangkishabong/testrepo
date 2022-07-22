@extends('layouts.main-head')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Employee Leave Summary</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Employee Leave Summary</li>
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
                            <p>Employee Leave Summary</p>
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
                                Employee Leave Summary
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
                                <form method="POST" id="" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="selemp">All Employees</label>
                                                <select class="form-control" name="selemp" id="selemp" required>
                                                    <option value="">Select Employees</option>
                                                    @foreach ($employees as $employees)
                                                        <option value="{{ $employees->name }}">{{ $employees->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="selyr">Year</label>
                                                <select class="form-control" name="selyr" id="selyr" required>
                                                    <option value="">Select Year</option>
                                                    @foreach ($yeararr as $yeararr)
                                                        <option value="{{ $yeararr }}">{{ $yeararr }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Month</label>
                                                <select class="form-control" name="selmnt" id="selmnt" required>
                                                    <option value="">Select Month</option>
                                                    @foreach ($months as $months)
                                                        <option value="{{ $months }}">{{ $months }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="sellvtype">Leave Types</label>
                                                <select class="form-control" name="sellvtype" id="sellvtype" required>
                                                    <option value="">Select Leave Type</option>
                                                    @foreach ($leavetypes as $leavetypes)
                                                        <option value="{{ $leavetypes->leavename }}">{{ $leavetypes->leavename }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                </form>
                                <br>
                                {!! $tabl !!}
                            </div>
                        </div>
                        <!-- /.card-body-->
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>
<script src="{{ asset('js/employee-leave-summary.js') }}"></script>

@endsection
