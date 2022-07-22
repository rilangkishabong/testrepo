<?php

namespace App\Http\Controllers;

use App\Models\ActivityStatus;
use App\Models\DailyActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\BulkExport;
use Maatwebsite\Excel\Facades\Excel;

class ActivityStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }
        if(((auth()->user()->account_type == "denied"))||((auth()->user()->account_type == NULL)))
        {
            auth()->logout();
            return redirect()->route('login')->with('success', 'Your account will be able activated by the administrator.');
        }
        $userId = Auth::id();
        $users = User::get(['id', 'name']);
        $mydets = User::where('users.id', $userId)->first();
        $reqdets = DailyActivity::join('users', 'daily_activities.usrId', '=', 'users.id')
        ->get(['users.name', 'daily_activities.actv_date', 'daily_activities.task'
        , 'daily_activities.time_tkn', 'daily_activities.actv_stat', 'daily_activities.id']);
        $cntreqs = count($reqdets);
        $curdate = date('Y-m-d');

        return view('view-daily-activities', ['reqdets'=>$reqdets, 'mydets'=>$mydets
        , 'cntreqs'=>$cntreqs, 'curdate'=>$curdate, 'users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usract = $request->usract;
        $datepicker_from = $request->datepicker_from;
        $datepicker_to = $request->datepicker_to;
        return Excel::download(new BulkExport($usract, $datepicker_from, $datepicker_to), 'activity-from '.$datepicker_from.' till '.$datepicker_to.'.xlsx');
    }
    public function GenExl(Request $request)
    {
        $usract = $request->usract;
        $datepicker_from = $request->datepicker_from;
        $datepicker_to = $request->datepicker_to;

        $datepicker_from = date('Y-m-d', strtotime($datepicker_from));
        $datepicker_to = date('Y-m-d', strtotime($datepicker_to));
        return Excel::download(new BulkExport($usract, $datepicker_from, $datepicker_to), 'activity-from '.$datepicker_from.' till '.$datepicker_to.'.xlsx');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ActivityStatus  $activityStatus
     * @return \Illuminate\Http\Response
     */
    public function show(ActivityStatus $activityStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ActivityStatus  $activityStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivityStatus $activityStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivityStatus  $activityStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActivityStatus $activityStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ActivityStatus  $activityStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivityStatus $activityStatus)
    {
        //
    }
}
