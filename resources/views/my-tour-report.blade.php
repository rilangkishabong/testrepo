@extends('layouts.main-head')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">My Tour Reports</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Manage Tour Report</li>
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

                            <p>Number of Tour Report</p>
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
                                View Tour Report
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
                                <table id="tableID" class="display" style="width:100%;">
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
                                            <th style="width: 40px">File Report</th>
                                            <th style="width: 40px">Edit Report</th>
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
                                            <td>{{ $depute_staf->tada_stat }}</td>
                                            <td>{{ $depute_staf->dep_reason }}</td>
                                            <td>{{ $depute_staf->date_posted }}</td>
                                            <td>
                                                <button class="btn btn-block btn-warning btntr_rept" href="#"
                                                    data-id="{{ $depute_staf->id }}"
                                                    data-target="#modal-tour_report">File Report</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-block btn-warning btntr_rept_edit" href="#"
                                                    data-id="{{ $depute_staf->id }}"
                                                    data-target="#modal-tour_report_edit">View Report</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="modal fade" id="modal-tour_report_edit">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">View Tour Report Form</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" id="edit_attch_form" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="tid" id="tid">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="">Journey Type</label>
                                                                <input type="text" name="jr_type_upd" id="jr_type_upd" class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            Start Journey
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="dep_id_upd" id="dep_id_upd">
                                                                    <label for="">Departure Date</label>
                                                                    <input type="date" class="form-control"
                                                                        name="depdate1_upd" id="depdate1_upd" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Departure Time</label>
                                                                    <input id="deptime1_upd" name="deptime1_upd" type="text"
                                                                        class="form-control input-group bootstrap-timepicker timepicker">
                                                                    <span class="input-group-addon"><i
                                                                            class="glyphicon glyphicon-time"></i></span>
                                                                    {{-- <input type="time" class="form-control"
                                                                        name="deptime" id="deptime" required> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Point Of Origin</label>
                                                                    <input type="text" class="form-control"
                                                                        name="originpt1_upd" id="originpt1_upd" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Point Of Destination</label>
                                                                    <input type="text" class="form-control"
                                                                        name="destinatnpt1_upd" id="destinatnpt1_upd" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            End Journey
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Arrival Date</label>
                                                                    <input type="date" class="form-control"
                                                                        name="arridate2_upd" id="arridate2_upd" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Arrival Time</label>
                                                                    {{-- <input type="time" class="form-control"
                                                                        name="arritime" id="arritime" required> --}}
                                                                    <input id="arritime2_upd" name="arritime2_upd" type="text"
                                                                        class="form-control input-group bootstrap-timepicker timepicker">
                                                                    <span class="input-group-addon"><i
                                                                            class="glyphicon glyphicon-time"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Point Of Origin</label>
                                                                    <input type="text" class="form-control"
                                                                        name="originpt2_upd" id="originpt2_upd" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Point Of Destination</label>
                                                                    <input type="text" class="form-control"
                                                                        name="destinatnpt2_upd" id="destinatnpt2_upd" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Number Of Days</label>
                                                                    <input type="number" class="form-control"
                                                                        name="nodays_upd" id="nodays_upd" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Mode Of Travel</label>
                                                                    <input name="travelmode_upd" id="travelmode_upd"
                                                                    type="text" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Mileage</label>
                                                                    <input type="text" class="form-control"
                                                                        name="mileage_upd" id="mileage_upd" readonly>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Distance(In Kms)</label>
                                                                    <input type="text" class="form-control"
                                                                        name="dist_upd" id="dist_upd" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Allowance in Advance</label>
                                                                    <input type="number" class="form-control"
                                                                        name="adv_exp_upd" id="adv_exp_upd" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Total DA</label>
                                                                    <input type="number" class="form-control"
                                                                        name="dallw_exp_upd" id="dallw_exp_upd"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Travel Expenses & Attachments </label>
                                                                    <div id="tr_att1_amt" class="form-control row"
                                                                        style="display:none">
                                                                    </div>
                                                                    <div id="tr_att1" class="form-control row">
                                                                        Click To View Expenses & Attachments
                                                                    </div>
                                                                    <div class="row" id="tr_att1_dwn"
                                                                        style="display:none">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Lodging Expenses & Attachments
                                                                    </label>
                                                                    <div id="tr_att2_amt" class="form-control row"
                                                                        style="display:none">
                                                                    </div>
                                                                    <div id="tr_att2" class="form-control row">
                                                                        Click To View Expenses & Attachments
                                                                    </div>
                                                                    <div class="row" id="tr_att2_dwn"
                                                                        style="display:none">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Tour Report</label>
                                                                    <div id="tr_att3_amt" class="form-control row"
                                                                        style="display:none">
                                                                    </div>
                                                                    <div id="tr_att3" class="form-control row">
                                                                        Click To View Attachments
                                                                    </div>
                                                                    <div class="row" id="tr_att3_dwn"
                                                                        style="display:none">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Other Expenses & Attachments </label>
                                                                    <div id="tr_att4_amt" class="form-control row"
                                                                        style="display:none">
                                                                    </div>
                                                                    <div id="tr_att4" class="form-control row">
                                                                        Click To View Expenses & Attachments
                                                                    </div>
                                                                    <div class="row" id="tr_att4_dwn"
                                                                        style="display:none">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="">Total</label>
                                                                <input type="text" class="form-control" name="tot_allw_upd" id="tot_allw_upd" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            {{-- @if($depute_staf->tada_stat=="No Action")
                                                            <button type="submit" class="btn btn-primary">Update Tour
                                                                Data</button>
                                                            @endif --}}
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
                                <div class="modal fade" id="modal-tour_report">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Fill Tour Report Form</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" class="form-videos"
                                                    action="{{ route('tour-report.store') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Journey Type</label>
                                                                    <select name="journeytype" id="journeytype"
                                                                        class="form-control" required>
                                                                        <option value="">Select Journey Type</option>
                                                                        <option value="Halt">Halt</option>
                                                                        <option value="To And Fro">To And Fro</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            Start Journey
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="dep_id" id="dep_id">
                                                                    <label for="">Departure Date</label>
                                                                    <input type="date" class="form-control"
                                                                        name="depdate" id="depdate" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Departure Time</label>
                                                                    <input id="deptime" name="deptime" type="text"
                                                                        class="form-control input-group bootstrap-timepicker timepicker">
                                                                    <span class="input-group-addon"><i
                                                                            class="glyphicon glyphicon-time"></i></span>
                                                                    {{-- <input type="time" class="form-control"
                                                                        name="deptime" id="deptime" required> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Point Of Origin</label>
                                                                    <input type="text" class="form-control"
                                                                        name="originpt1" id="originpt1" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Point Of Destination</label>
                                                                    <input type="text" class="form-control"
                                                                        name="destinatnpt1" id="destinatnpt1" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            End Journey
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Arrival Date</label>
                                                                    <input type="date" class="form-control"
                                                                        name="arridate" id="arridate" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Arrival Time</label>
                                                                    {{-- <input type="time" class="form-control"
                                                                        name="arritime" id="arritime" required> --}}
                                                                    <input id="arritime" name="arritime" type="text"
                                                                        class="form-control input-group bootstrap-timepicker timepicker">
                                                                    <span class="input-group-addon"><i
                                                                            class="glyphicon glyphicon-time"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Point Of Origin</label>
                                                                    <input type="text" class="form-control"
                                                                        name="originpt2" id="originpt2" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Point Of Destination</label>
                                                                    <input type="text" class="form-control"
                                                                        name="destinatnpt2" id="destinatnpt2" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Number Of Days</label>
                                                                    <input type="number" class="form-control"
                                                                        name="nodays" id="nodays" readonly required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Mode Of Travel</label>
                                                                    <select name="travelmode" id="travelmode"
                                                                        class="form-control" required>
                                                                        <option value="">Select Travel Mode</option>
                                                                        <option value="Road">Road</option>
                                                                        <option value="Air">Air</option>
                                                                        <option value="Rail">Rail</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Mileage</label>
                                                                    <select type="text" class="form-control"
                                                                        name="mileage" id="mileage" required>
                                                                        <option value="">Select Mileage</option>
                                                                        <option value="Alloted Vehicle">Alloted Vehicle
                                                                        </option>
                                                                        <option value="Own Conveyance">Own Conveyance
                                                                        </option>
                                                                        <option value="Public Transport">Public
                                                                            Transport</option>
                                                                        <option value="Hired Transport">Hired
                                                                            Transport</option>
                                                                        <option value="Shared Transport">Shared
                                                                            Transport</option>
                                                                        <option value="Pool Transport">Pool
                                                                                Transport</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Distance(In Kms)</label>
                                                                    <input type="text" class="form-control" name="dist"
                                                                        id="dist" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Allowance in Advance</label>
                                                                    <input type="number" class="form-control"
                                                                        name="adv_exp" id="adv_exp" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="fortrans">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Travel Fare</label>
                                                                    <input type="file" class="form-control"
                                                                        name="trfare[]" id="trfare" required multiple>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Travel Fare Expenses(TA)</label>
                                                                    <input type="number" class="form-control"
                                                                        name="trfare_exp" id="trfare_exp" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Lodging Fare</label>
                                                                    <input type="file" class="form-control"
                                                                        name="lodgfare[]" id="lodgfare" required
                                                                        multiple>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Lodging Fare Expenses</label>
                                                                    <input type="number" class="form-control"
                                                                        name="lodgfare_exp" id="lodgfare_exp" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Others</label>
                                                                    <input type="file" class="form-control"
                                                                        name="other_exp[]" id="other_exp" required
                                                                        multiple>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Other Expenses</label>
                                                                    <input type="number" class="form-control"
                                                                        name="other_exp_exp" id="other_exp_exp"
                                                                        required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Tour Reports</label>
                                                                    <input type="file" class="form-control"
                                                                        name="tourrept[]" id="tourrept" required
                                                                        multiple>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Total Daily Allowances(DA)</label>
                                                                    <input type="number" class="form-control"
                                                                        name="dallw_exp" id="dallw_exp" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="">Total</label>
                                                                <input type="text" id="allw_tot" name="allw_tot" placeholder="Click Here To Get Total" class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                Tour</button>
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

<script src="{{ asset('js/my-tour-report.js') }}"></script>

@endsection
