@extends('layouts.main-head')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage My Applied Leaves</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Manage My Applied Leaves</li>
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
                            <p>Number of My Applied Leaves</p>
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
                                View My Applied Leaves
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
                            <div style="height: 100%; width: 100%;overflow-x: scroll">
                                {!! $tbl !!}
                                <div class="modal fade" id="modal-leave">
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
                                                <form method="POST" id="updleavform">
                                                    @csrf
                                                    <input type="hidden" name="leavid" id="leavid">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="">Reason</label>
                                                            <input type="text" class="form-control"
                                                                name="reason_upd" id="reason_upd"
                                                                placeholder=""
                                                                value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">From</label>
                                                            <input type="date" class="form-control"
                                                                name="from_upd" id="from_upd"
                                                                value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Till</label>
                                                            <input type="date" class="form-control"
                                                                name="till_upd" id="till_upd"
                                                                value="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">No Of Days</label>
                                                            <input type="text" class="form-control"
                                                                name="nod" id="nod"
                                                                value="" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Shift Time</label>
                                                            <select type="text" class="form-control" id="shift_upd" name="shift_upd" required>
                                                                <option value="">Select Shift</option>
                                                                <option value="Half day">Half Day</option>
                                                                <option value="Full day">Full Day</option>
                                                            </select>
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

<script src="{{ asset('js/applied-leave.js') }}"></script>

@endsection
