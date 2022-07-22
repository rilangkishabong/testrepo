@extends('layouts.main-head')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Accepted Tour Requests</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Accepted Tour Requests</li>
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
                            <h3>{{ $depute_staf_cnt }}</h3>

                            <p>Number of Accepted Tour Requests</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-sm-3">
                    <button class="btn btn-block btn-warning btnlvls" href="#" data-id="" data-toggle="modal"
                        data-target="#modal-add_deput">Request for a tour</button>
                </div>
            </div> --}}
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <!-- Map card -->
                    <div class="card ">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                View Accepted Tour Requests
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
                            <div style="height: 100%; width: 100%; overflow-x:scroll">
                                <table id="tableID" class="display" style="width:100%; ">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Designation</th>
                                            <th>Department</th>
                                            <th>Tour Programme</th>
                                            <th>Reason</th>
                                            <th>Location</th>
                                            <th>Date From</th>
                                            <th>Date To</th>
                                            <th>No of days</th>
                                            <th>Shift Time</th>
                                            <th>Status</th>
                                            <th>Reason</th>
                                            <th>Date Posted</th>
                                            <th style="width: 40px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($depute_stafs as $depute_staf)
                                            <tr class="mytr">
                                                <td>{{ $depute_staf->name }}</td>
                                                <td>{{ $depute_staf->desg }}</td>
                                                <td>{{ $depute_staf->dept_name }}</td>
                                                <td>{{ $depute_staf->tour_prog }}</td>
                                                <td>{{ $depute_staf->dep_reason }}</td>
                                                <td>{{ $depute_staf->dep_locatn }}</td>
                                                <td>{{ $depute_staf->dep_date_from }}</td>
                                                <td>{{ $depute_staf->dep_date_to }}.</td>
                                                <td>{{ $depute_staf->dep_no_of_days }}</td>
                                                <td>{{ $depute_staf->shift_time }}</td>
                                                <td>{{ $depute_staf->tour_status }}</td>
                                                <td>{{ $depute_staf->dep_reason }}</td>
                                                <td>{{ $depute_staf->date_posted }}</td>
                                                <td>
                                                    @if (Carbon\Carbon::parse($depute_staf->dep_date_from)->diffInDays(now(), false)!=0)
                                                    <button class="btn btn-block btn-warning btnchgstat" href="#" data-id="{{ $depute_staf->id }}" data-toggle="modal"
                                                    data-target="#modal-chg_tour_stat">Edit</button>
                                                    @else
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="modal fade" id="modal-chg_tour_stat">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Tour Request Form</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" id="TourStatForm">
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="">Tour Status</label>
                                                            <select class="form-control"
                                                                name="tourstat" id="tourstat" required>
                                                                <option value="">Change Status</option>
                                                            </select>
                                                            <input type="hidden" name="tourid" id="tourid">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Date</label>
                                                            <input type="hidden" name="empidx" id="empidx">
                                                            <input type="text" class="form-control"
                                                                name="emp_date" id="emp_date"
                                                                placeholder=""
                                                                value="{{ $curdate }}" readonly>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Save Tour</button>
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
                                {{-- --}}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/request-tour.js') }}"></script>

@endsection
