<?php

namespace App\Http\Controllers;

use App\Models\DailyActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyActivityController extends Controller
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
        $mydets = User::where('users.id', $userId)->first();
        $reqdets = DailyActivity::join('users', 'daily_activities.usrId', '=', 'users.id')
        ->where('users.id', $userId)
        ->get(['users.name', 'daily_activities.actv_date', 'daily_activities.task'
        , 'daily_activities.time_tkn', 'daily_activities.actv_stat', 'daily_activities.id']);
        $cntreqs = count($reqdets);
        $curdate = date('Y-m-d');
        return view('my-daily-activities', ['reqdets'=>$reqdets, 'mydets'=>$mydets
        , 'cntreqs'=>$cntreqs, 'curdate'=>$curdate]);
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
        $userId = Auth::id();
        foreach ($request->act_name as $key => $value) {
            DailyActivity::create([
                'actv_date' => $request->act_date,
                'usrId' => $userId,
                'task' => $request->act_name[$key],
                'time_tkn' => $request->act_time[$key],
                'actv_stat' => $request->act_stat[$key],
            ]);
        }
        return redirect()->route('my-daily-activities.index')->with('success', 'Data saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DailyActivity  $dailyActivity
     * @return \Illuminate\Http\Response
     */
    public function show(DailyActivity $dailyActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DailyActivity  $dailyActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyActivity $dailyActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DailyActivity  $dailyActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyActivity $dailyActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyActivity  $dailyActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyActivity $dailyActivity)
    {
        //
    }
}
