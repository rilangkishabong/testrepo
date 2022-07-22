@extends('layouts.main-head')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Leave Applications</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Manage Leave Applications</li>
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
                            <h3>{{ $leavetype_apps_cnt }}</h3>

                            <p>Number of Leave Applications</p>
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
                                View Leave Applications
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
                                <table id="tableID" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Employee Id</th>
                                            <th>Employee Name</th>
                                            <th>Designation</th>
                                            <th>Date From</th>
                                            <th>Date To</th>
                                            <th>No of days</th>
                                            <th>Shift Time</th>
                                            <th>Leave Type</th>
                                            <th>Reason</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                            <th>Date Posted</th>
                                            <th style="width: 40px">Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leavetype_apps as $leavetype_apps)
                                            <tr class="mytr">
                                                <td>{{ $mydets->emp_id }}</td>
                                                <td>{{ $leavetype_apps->name }}</td>
                                                <td>{{ $leavetype_apps->desg }}</td>
                                                <td>{{ $leavetype_apps->date_from }}</td>
                                                <td>{{ $leavetype_apps->date_to }}.</td>
                                                <td>{{ $leavetype_apps->no_of_days }}</td>
                                                <td>{{ $leavetype_apps->shift_time }}</td>
                                                <td>{{ $leavetype_apps->leavename }}</td>
                                                <td>{{ $leavetype_apps->reason }}</td>
                                                <td>{{ $leavetype_apps->leave_status }}</td>
                                                <td>{{ $leavetype_apps->remks }}</td>
                                                <td>{{ $leavetype_apps->date_posted }}</td>
                                                <td>
                                                    @php
                                                    $timestamp1 = strtotime($leavetype_apps->date_from);
                                                        $day1 = date('d', $timestamp1);
                                                        $timestamp2 = strtotime(date("Y-m-d"));
                                                        $day2 = date('d', $timestamp2);
                                                        $dtdiff = $day1 - $day2;
                                                        if($dtdiff>0)
                                                        {
                                                            echo '<button class="btn btn-block btn-warning btnlvls" href="#" data-id='."$leavetype_apps->id".' data-toggle="modal" data-target="#modal-leavelist">Edit</button>';
                                                        }
                                                        else
                                                        {
                                                            echo 'Date already passed';
                                                        }
                                                    @endphp
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="modal fade" id="modal-leavelist">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Change Leave Status</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" id="leavestatsform">
                                                    @csrf
                                                    <input type="text" name="empnameid" id="empnameid" hidden>
                                                    <input type="text" name="leavid" id="leavid" hidden>
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="">Leave Status</label>
                                                            <select class="form-control" name="lvstat" id="lvstat" required>
                                                                <option value="">Change Leave Status</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Remarks</label>
                                                            <input type="text" class="form-control"
                                                                name="remk" id="remk"
                                                                placeholder="Remarks"
                                                                value="" required>
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
                                {{-- --}}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/approv-auth-leave-applist.js') }}"></script>

@endsection
