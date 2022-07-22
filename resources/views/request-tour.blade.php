@extends('layouts.main-head')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tour Requests</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Tour Requests</li>
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

                            <p>Number of Tour Requests</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <button class="btn btn-block btn-warning btnlvls" href="#" data-id="" data-toggle="modal"
                        data-target="#modal-add_deput">Request for a tour</button>
                </div>
            </div>
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <!-- Map card -->
                    <div class="card ">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                View Tour Requests
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
                                                    @if ($depute_staf->tourid == 4 )
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <button class="btndeput" href="#" data-id="{{ $depute_staf->id }}" data-toggle="modal"
                                                                    data-target="#modal-depulist">Edit</button>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <form method="post"
                                                                action="{{ route('request-tour.destroy', [$depute_staf->id]) }}">
                                                                {{ csrf_field() }}
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Are you sure?')">Cancel</button>
                                                            </form>
                                                            </div>
                                                        </div>
                                                    @else
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="modal fade" id="modal-add_deput">
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
                                                <form method="POST" action="{{ route('request-tour.store') }}">
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="">Employee Name</label>
                                                            <input type="text" class="form-control"
                                                            name="empname" id="empname"
                                                            placeholder=""
                                                            value="{{ $mydets->name }}" required readonly>
                                                            <input type="hidden" class="form-control"
                                                            name="empidx" id="empidx"
                                                            placeholder=""
                                                            value="{{ $mydets->id }}" >
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Employee Id</label>
                                                            <input type="text" class="form-control"
                                                            name="empids" id="empids"
                                                            placeholder=""
                                                            value="{{ $mydets->emp_id }}" required readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Employee Designation</label>
                                                            <input type="text" class="form-control"
                                                            name="empdesg" id="empdesg"
                                                            placeholder=""
                                                            value="{{ $mydets->desg }}" required readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Department</label>
                                                            <input type="text" class="form-control"
                                                            name="empdep" id="empdep"
                                                            placeholder=""
                                                            value="{{ $department_name }}" required readonly>
                                                            <input type="hidden" class="form-control"
                                                            name="empdepid" id="empdepid"
                                                            placeholder=""
                                                            value="{{ $mydets->dept_id }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <label for="">Tour Programme</label>
                                                                    <select class="form-control"
                                                                    name="emptour" id="emptour" required>
                                                                    <option value="">Select Tour</option>
                                                                    @foreach ($tours as $tour)
                                                                        <option value="{{ $tour->id }}">{{ $tour->tour_prog }}</option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label for="">Specify</label>
                                                                    <input type="text" class="form-control"
                                                                name="empspectour" id="empspectour"
                                                                placeholder=""
                                                                value="" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Reasons</label>
                                                            <input type="text" class="form-control"
                                                                name="empreason" id="empreason"
                                                                placeholder=""
                                                                value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Location</label>
                                                            <input type="text" class="form-control"
                                                                name="emplocatn" id="emplocatn"
                                                                placeholder=""
                                                                value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="">Date From</label>
                                                                    <input type="date" class="form-control"
                                                                    name="empdatefr" id="empdatefr"
                                                                    placeholder=""
                                                                    value="" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="">Date To</label>
                                                                    <input type="date" class="form-control"
                                                                    name="empdateto" id="empdateto"
                                                                    placeholder=""
                                                                    value="" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="">Shift Time</label>
                                                                    <select class="form-control"
                                                                    name="emptime" id="emptime" required>
                                                                    <option value="">Select Shift</option>
                                                                    @foreach($stime as $key)
                                                                        <option value="{{ $key->timename }}">{{ $key->timename }}</option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="">No Of Days</label>
                                                                    <input type="text" class="form-control"
                                                                    name="empnod" id="empnod"
                                                                    placeholder="Click Here"
                                                                    value="" required readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Date</label>
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
                                <div class="modal fade" id="modal-depulist">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Change Requested Tour Datas</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" id="request_tourupdateform">
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="">Employee Name</label>
                                                            <input type="hidden" name="prid" id="prid">
                                                            <input type="text" class="form-control"
                                                            name="empname_upd" id="empname_upd"
                                                            placeholder=""
                                                            value="" required readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Employee Id</label>
                                                            <input type="text" class="form-control"
                                                            name="empid_upd" id="empid_upd"
                                                            placeholder=""
                                                            value="" required readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Employee Designation</label>
                                                            <input type="text" class="form-control"
                                                            name="empdesg_upd" id="empdesg_upd"
                                                            placeholder=""
                                                            value="" required readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Department</label>
                                                            <input type="text" class="form-control"
                                                            name="empdep_upd" id="empdep_upd"
                                                            placeholder=""
                                                            value="" required readonly>
                                                            <input type="hidden" class="form-control"
                                                            name="empdepid_upd" id="empdepid_upd"
                                                            placeholder=""
                                                            value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <label for="">Tour Programme</label>
                                                                    <select name="emptours_upd" id="emptours_upd" class="form-control" required>
                                                                        <option value="">Select Employee</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label for="">Specify</label>
                                                                    <input type="text" class="form-control"
                                                                name="empspectour_upd" id="empspectour_upd"
                                                                placeholder=""
                                                                value="" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Reasons</label>
                                                            <input type="text" class="form-control"
                                                                name="empreason_upd" id="empreason_upd"
                                                                placeholder=""
                                                                value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Location</label>
                                                            <input type="text" class="form-control"
                                                                name="emplocatn_upd" id="emplocatn_upd"
                                                                placeholder=""
                                                                value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="">Date From</label>
                                                                    <input type="date" class="form-control"
                                                                    name="empdatefr_upd" id="empdatefr_upd"
                                                                    placeholder=""
                                                                    value="" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="">Date To</label>
                                                                    <input type="date" class="form-control"
                                                                    name="empdateto_upd" id="empdateto_upd"
                                                                    placeholder=""
                                                                    value="" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="">Shift Time</label>
                                                                    <select class="form-control"
                                                                    name="emptime_upd" id="emptime_upd" required>
                                                                    <option value="">Select Shift</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="">No Of Days</label>
                                                                    <input type="text" class="form-control"
                                                                    name="empnod_upd" id="empnod_upd"
                                                                    placeholder="Click Here"
                                                                    value="" required readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Update Tour</button>
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
