<?php

namespace App\Http\Controllers;

use App\Models\LeaveStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveStatusController extends Controller
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
        $leavestat_datas = LeaveStatus::all();
        $leavestat_cnt = count($leavestat_datas);
        $userId = Auth::id();
        $mydets = User::where('users.id', $userId)->first();
        return view("admin-leave-status", ['mydets' => $mydets, 'leavestat_datas' => $leavestat_datas, 'leavestat_cnt' => $leavestat_cnt, 'userId' => $userId]);
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

        if(!Auth::check())
        {
            return redirect()->route('login');
        }
        if(((auth()->user()->account_type == "denied"))||((auth()->user()->account_type == NULL)))
        {
            auth()->logout();
            return redirect()->route('login')->with('success', 'Your account will be able activated by the administrator.');
        }
        $leavestat_data = new LeaveStatus();
        $leavestat_data->leave_status = $request->leavestatus;
        $leavestat_data->save();
        return redirect()->route('master-leave-stat.index')->with('success', 'New Leave Status successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeaveStatus  $leaveStatus
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveStatus $leaveStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeaveStatus  $leaveStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveStatus $leaveStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeaveStatus  $leaveStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeaveStatus $leaveStatus)
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
        $reqd_id = $request->master_leave_stat;

        $data = $request->leavestatus_upd;


        LeaveStatus::where('id', $reqd_id)->update(array('leave_stat' => $data));
        //dd($roomdatas);
        return redirect()->route('master-leave-stat.index')->with('success', 'Leave Status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeaveStatus  $leaveStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, LeaveStatus $leaveStatus)
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
        $reqd_id = $request->master_leave_stat;

        $dept_data = LeaveStatus::where('id', $reqd_id)->first();

        //$fdat->fetch($request->f_dat)->delete();
        $dept_data->delete();
        return redirect()->route('master-leave-stat.index')->with('success', 'Leave Status deleted successfully');
    }
}
