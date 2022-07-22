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
                <!-- ./col -->

                <!-- ./col -->

                <!-- ./col -->

                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <section class="col-lg-6 connectedSortable">
                    <div class="card ">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                Add Daily Activities
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse"
                                    title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div style="height: 100%; width: 100%;">
                                <form method="POST" action="{{ route('my-daily-activities.store') }}">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                                <label for="">Date Of Activity</label>
                                                <input class="form-control" type="date" name="act_date" id="act_date" value="">
                                            <div id="inputFormRow" class="row">
                                                <div class="col-sm-4">
                                                    <label for="">Activity/Task Name</label>
                                                    <input type="text" class="form-control" id="act_name[]" name="act_name[]"
                                                        placeholder="Activity Name" required>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="">Activity Status</label>
                                                    <select class="form-control" name="act_stat[]" id="act_stat[]" required>
                                                        <option value="">Select Status</option>
                                                        <option value="Completed">Completed</option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="To Be Continued">To Be Continued</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="">Time Taken(in hrs)</label>
                                                    <input type="number" class="form-control" id="act_time[]" name="act_time[]"
                                                        placeholder="" required>
                                                </div>
                                            </div>
                                            <div id="newRow"></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                        <button type="button" id="addRow" class="btn btn-primary">Add Activity</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">

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
                            <div style="height: 100%; width: 100%;">
                                <table id="tableID" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Date</th>
                                            <th>Activity Name</th>
                                            <th>Activity Status</th>
                                            <th>Time Taken</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reqdets as $reqdets)
                                        <tr class="mytr">
                                            <td>{{ $reqdets->id }}</td>
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
    <script src="{{ asset('js/my-daily-activities.js') }}"></script>
</div>
@endsection
