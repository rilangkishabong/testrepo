<?php

namespace App\Http\Controllers;

use App\Models\LeaveTypeMaster;
use Illuminate\Support\Facades\Auth;
use App\Models\OfficeMgmt;
use App\Models\User;
use App\Models\LeaveTypeMgmt;
use Illuminate\Http\Request;

class LeaveTypeMgmtController extends Controller
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
        $leavetype_datas = LeaveTypeMgmt::join('office_mgmts', 'office_mgmts.id', '='
        , 'leave_type_mgmts.office_id')
        ->join('leave_type_masters', 'leave_type_masters.id', '=', 'leave_type_mgmts.leave_type_id')
        ->get(['leave_type_mgmts.id', 'office_mgmts.office_name', 'leave_type_masters.leavename'
        , 'leave_type_mgmts.leave_entitle', 'leave_type_mgmts.leave_desc', 'leave_type_mgmts.leave_type_id'
        , 'leave_type_mgmts.office_id']);
        $office_datas = OfficeMgmt::all();
        $leaves = LeaveTypeMaster::get(['id', 'leavename']);

        $leavetype_cnt = LeaveTypeMgmt::all();
        $leavetype_cnt=count($leavetype_cnt);
        $userId = Auth::id();
        $mydets = User::where('users.id', $userId)->first();
        $office_id = $mydets->office_id;
        $offdets = OfficeMgmt::where('office_mgmts.id', $office_id)->first();
        return view("admin-leavetype-pg", ['mydets'=>$mydets, 'leaves'=>$leaves
        , 'offdets'=>$offdets, 'leavetype_datas'=>$leavetype_datas
        , 'leavetype_cnt'=>$leavetype_cnt, 'userId'=>$userId, 'office_datas'=>$office_datas]);
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
        $leavetype_data = new LeaveTypeMgmt();
        $leavetype_data->office_id = $request->officename;
        $leavetype_data->leave_type_id = $request->leavetype;
        $leavetype_data->leave_entitle = $request->leave_entitle;
        $leavetype_data->leave_desc = $request->leave_desc;
        $leavetype_data->save();
        return redirect()->route('master-leavetype.index')->with('success', 'New Leave Type successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeaveTypeMgmt  $leaveTypeMgmt
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveTypeMgmt $leaveTypeMgmt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeaveTypeMgmt  $leaveTypeMgmt
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveTypeMgmt $leaveTypeMgmt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeaveTypeMgmt  $leaveTypeMgmt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeaveTypeMgmt $leaveTypeMgmt)
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
        $reqd_id = $request->master_leavetype;
        $office_upd_id = $request->officename_upd;
        $leavetype_upd = $request->leavetype_upd;
        $leave_entitle_upd = $request->leave_entitle_upd;
        $leave_desc_upd = $request->leave_desc_upd;
        LeaveTypeMgmt::where('id',$reqd_id)->update(array('office_id'=>$office_upd_id, 'leave_name'=>$leavetype_upd, 'leave_entitle'=>$leave_entitle_upd, 'leave_desc'=>$leave_desc_upd));
        return redirect()->route('master-leavetype.index')->with('success', 'Department updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeaveTypeMgmt  $leaveTypeMgmt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,LeaveTypeMgmt $leaveTypeMgmt)
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
        $reqd_id = $request->master_leavetype;

        $leave_data = LeaveTypeMgmt::where('id', $reqd_id)->first();

            //$fdat->fetch($request->f_dat)->delete();
        $leave_data->delete();
        return redirect()->route('master-leavetype.index')->with('success', 'Leave Type deleted successfully');
    }
}
