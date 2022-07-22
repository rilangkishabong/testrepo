@extends('layouts.main-head')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Tour Reports</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Manage Tour Reports</li>
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
                            <h3>{{ $countnewdat }}</h3>

                            <p>Number of Tour Report</p>
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
                    <button class="btn btn-block btn-warning btntr_rept" href="#" data-toggle="modal"
                        data-target="#modal-tour_report">File Report</button>
                </div>
            </div> --}}
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
                            <div class="container">
                                <form target="_blank" [....] class="form-inline" id="genform" method="post" action="{{ route('GenForm') }}">
                                    @csrf
                                    <label for="">Username:</label>
                                    <select name="selusrrep" id="selusrrep" class="form-control" required>
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="">Quarter:</label>
                                    <select name="selmonthrep" id="selmonthrep" class="form-control" required>
                                        <option value="">Select Quarter</option>
                                        <option value="1">1st Quarter</option>
                                        <option value="2">2nd Quarter</option>
                                        <option value="3">3rd Quarter</option>
                                        <option value="4">4th Quarter</option>
                                    </select>
                                    <button type="submit" name="submitbtnn" value="tba" class="btn btn-danger">
                                        Generate Report
                                    </button>
                                    <button type="submit" name="submitbtnn" value="ac" class="btn btn-danger">
                                        Approved Claims
                                    </button>
                                </form>
                            </div>
                            <br>
                            <div style="height: 100%; width: 100%; overflow-x:scroll">
                                <table id="tableID" class="display" style="width:100%; ">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Designation</th>
                                            <th>Department</th>
                                            <th>Tour Programme</th>
                                            <th>Journey Type</th>
                                            <th>Reason</th>
                                            <th>Location</th>
                                            <th>Departure Date</th>
                                            <th>Arrival Date</th>
                                            <th>No Of Days</th>
                                            <th>Point of origin(Start Journey)</th>
                                            <th>Point of destination(Start Journey)</th>
                                            <th>Point of origin(Return Journey)</th>
                                            <th>Point of destination(Return Journey)</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($newdat as $newdat)
                                        <tr class="mytr">
                                            <td>{{ $newdat->name }}</td>
                                            <td>{{ $newdat->desg }}</td>
                                            <td>{{ $newdat->dept_name }}</td>
                                            <td>{{ $newdat->tour_prog }}</td>
                                            <td>{{ $newdat->jr_type }}</td>
                                            <td>{{ $newdat->dep_reason }}</td>
                                            <td>{{ $newdat->dep_locatn }}</td>
                                            <td>{{ $newdat->dep_date_from }}</td>
                                            <td>{{ $newdat->dep_date_to }}</td>
                                            <td>{{ $newdat->dep_no_of_days }}</td>
                                            <td>{{ $newdat->tr_pt_of_origin1 }}</td>
                                            <td>{{ $newdat->tr_pt_of_destination1 }}</td>
                                            <td>{{ $newdat->tr_pt_of_origin2 }}</td>
                                            <td>{{ $newdat->tr_pt_of_destination2 }}</td>
                                            <td>{{ $newdat->ta_da_date }}</td>
                                            <td>{{ $newdat->tada_stat }}</td>
                                            <td>
                                                <button class="btn btn-block btn-warning F btntr_view_rept" href="#"
                                                    data-id="{{ $newdat->tid }}" data-toggle="modal"
                                                    data-target="#modal-btntr_view_rept">View Reports</button>
                                                @if ($newdat->tada_stat!="Approved")
                                                <button class="btn btn-block btn-warning btntr_rept_stat" href="#"
                                                    data-id="{{ $newdat->id }}" data-toggle="modal"
                                                    data-target="#modal-btntr_rept_stat">Change Status</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="modal fade" id="modal-btntr_rept_stat">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Tour Attachments</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" id="edit_rept_stat" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="dep_id_upd"
                                                                        id="dep_id_upd">
                                                                    <label for="">TA / DA Status</label>
                                                                    <input type="hidden" name="depid" id="depid">
                                                                    <select id="seltadastat" name="seltadastat"
                                                                        class="form-control">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            Status</button>
                                                    </div>
                                                    <!-- /.card-body -->
                                                </form>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div class="modal fade" id="modal-btntr_view_rept">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Tour Attachments</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" id="" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" value="" name="tid" id="tid">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Allowance in Advance</label>
                                                                    <input type="text" class="form-control"
                                                                        name="adv_expend" id="adv_expend" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Total DA</label>
                                                                    <input type="text" class="form-control"
                                                                        name="da_exp" id="da_exp" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Travel Fare & amount</label>
                                                                    <div id="tr_att1_amt" class="form-control row" style="display:none">
                                                                    </div>
                                                                    <div id="tr_att1" class="form-control row">
                                                                        Click To View Attachments & amount
                                                                    </div>
                                                                    <div class="row" id="tr_att1_dwn" style="display:none">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Lodging Fare</label>
                                                                    <div id="tr_att2_amt" class="form-control row" style="display:none">

                                                                    </div>
                                                                    <div id="tr_att2" class="form-control row">
                                                                        Click To View Attachments
                                                                    </div>
                                                                    <div class="row" id="tr_att2_dwn" style="display:none">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Tour Report</label>
                                                                    <div id="tr_att3" class="form-control row">
                                                                        Click To View Attachments
                                                                    </div>
                                                                    <div class="row" id="tr_att3_dwn" style="display:none">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">Other Fares</label>
                                                                    <div id="tr_att4_amt" class="form-control row" style="display:none">

                                                                    </div>
                                                                    <div id="tr_att4" class="form-control row">
                                                                        Click To View Attachments
                                                                    </div>
                                                                    <div class="row" id="tr_att4_dwn" style="display:none">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <!-- /.card-body -->
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <div class="modal fade" id="modal-">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Tour Attachments</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" id="edit_attch_form" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    {{-- <input type="hidden" name="dep_id_upd"
                                                                        id="dep_id_upd"> --}}
                                                                    <label for="">Travel Fare</label>
                                                                    <div id="trfare_upds_link" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Lodging Expenses & Attachments</label>
                                                                    <div id="lodgfare_upds_link" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Tour Report</label>
                                                                    <div id="tourrept_upds_link" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Other Expenses & Attachments</label>
                                                                    <div id="other_exp_upds_link" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Travel Fare</label>
                                                                    <input id="taamt" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Lodging Fare</label>
                                                                    <input id="lamt" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Total Daily Allowance</label>
                                                                    <input id="daamt" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Other Expenses</label>
                                                                    <input id="oeamt" class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="">Total</label>
                                                                <input id="totamt" class="form-control" readonly>
                                                            </div>
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
                            {{-- --}}
                        </div>
                    </div>
            </div>
    </section>
</div>
</div>
</section>
</div>

<script src="{{ asset('js/manage-employee-tours.js') }}"></script>

@endsection
