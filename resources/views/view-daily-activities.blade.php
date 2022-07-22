@extends('layouts.main-head')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daily Activities</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Daily Activities</li>
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
                            <h3>{{ $cntreqs }}</h3>

                            <p>Number of Daily Activities</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <!-- Map card -->
                    <div class="card ">
                        <div class="card-header border-0">
                            <h3 class="card-title">

                                View Daily Activities
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
                            <form class="container" method="POST" action="{{ route('GenExl') }}">
                                @csrf
                                <div class="form-inline">
                                    <label for="">Username:</label>
                                    <select name="usract" id="usract" class="form-control" required>
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="">From:</label>
                                    <input type="date" class="form-control" name="datepicker_from" id="datepicker_from" required>
                                    <label for="">Till:</label>
                                    <input type="date" class="form-control" name="datepicker_to" id="datepicker_to" required>
                                    <input type="submit">
                                </div>
                            </form>
                            <div style="height: 100%; width: 100%;">
                                <table id="table_acti" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Employee Name</th>
                                            <th>Date of Activity</th>
                                            <th>Activity Name</th>
                                            <th>Activity Status</th>
                                            <th>Time Taken</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reqdets as $reqdets)
                                        <tr class="mytr">
                                            <td>{{ $reqdets->id }}</td>
                                            <td>{{ $reqdets->name }}</td>
                                            <td>{{ $reqdets->actv_date }}</td>
                                            <td>{{ $reqdets->task }}</td>
                                            <td>{{ $reqdets->actv_stat }}</td>
                                            <td>{{ $reqdets->time_tkn }}</td>
                                        </tr>
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
{{-- <script src="{{ asset('js/view-daily-activity.js') }}"></script> --}}
@endsection
