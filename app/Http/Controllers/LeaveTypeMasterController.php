<?php

namespace App\Http\Controllers;

use App\Models\LeaveTypeMaster;
use App\Models\OfficeMgmt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveTypeMasterController extends Controller
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
        //
        $leavetype_datas = LeaveTypeMaster::all();
        $office_datas = OfficeMgmt::orderBy('id', 'asc')->get();
        $leavetype_cnt = LeaveTypeMaster::all();
        $leavetype_cnt=count($leavetype_cnt);
        $userId = Auth::id();
        $mydets = User::where('users.id', $userId)->first();
        $office_id = $mydets->office_id;
        $offdets = OfficeMgmt::where('office_mgmts.id', $office_id)->first();
        return view("admin-leavetypes", ['mydets'=>$mydets, 'office_datas'=>$office_datas, 'offdets'=>$offdets
        , 'leavetype_datas'=>$leavetype_datas, 'leavetype_cnt'=>$leavetype_cnt, 'userId'=>$userId]);
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
        $leave = new LeaveTypeMaster();
        $leave->leavename = $request->leavename;
        $leave->save();
        return redirect()->route('master-leave-type.index')->with('success', 'New Data added successfully added');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeaveTypeMaster  $leaveTypeMaster
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveTypeMaster $leaveTypeMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeaveTypeMaster  $leaveTypeMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveTypeMaster $leaveTypeMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeaveTypeMaster  $leaveTypeMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeaveTypeMaster $leaveTypeMaster)
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
        //
        $leavename = $request->leavename_upd;
        $leaveid = $request->master_leave_type;
        LeaveTypeMaster::where('id', $leaveid)->update(array('leavename'=>$leavename));
        return redirect()->route('master-leave-type.index')->with('success', 'Data Updated added');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeaveTypeMaster  $leaveTypeMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
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
        //
        $reqd_id = $request->master_leave_type;

        $leave_data = LeaveTypeMaster::where('id', $reqd_id)->first();

            //$fdat->fetch($request->f_dat)->delete();
        $leave_data->delete();
        return redirect()->route('master-leave-type.index')->with('success', 'Office deleted successfully');
    }
}
