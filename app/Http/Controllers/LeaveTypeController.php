<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\OfficeMgmt;
use App\Models\User;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leavetype_datas = OfficeMgmt::join('leave_types', 'leave_types.office_id','=','office_mgmts.id')->orderBy('leave_types.id', 'asc')->get();
        $office_datas = OfficeMgmt::orderBy('id', 'asc')->get();
        $leavetype_cnt = LeaveType::all();
        $leavetype_cnt=count($leavetype_cnt);
        $userId = Auth::id();
        $mydets = User::where('users.id', $userId)->first();
        $office_id = $mydets->office_id;
        $offdets = OfficeMgmt::where('office_mgmts.id', $office_id)->first();
        return view("admin-leavetype-pg", ['mydets'=>$mydets, 'office_datas'=>$office_datas, 'offdets'=>$offdets, 'leavetype_datas'=>$leavetype_datas, 'leavetype_cnt'=>$leavetype_cnt, 'userId'=>$userId]);

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
        $leavetype_data = new LeaveType();
        $leavetype_data->office_id = $request->officename;
        $leavetype_data->leave_name = $request->leavetype;
        $leavetype_data->leave_entitle = $request->leave_entitle;
        $leavetype_data->leave_desc = $request->leave_desc;
        $leavetype_data->save();
        return redirect()->route('master-leavetype.index')->with('success', 'New Leave Type successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveType $leaveType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveType $leaveType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeaveType $leaveType)
    {
        $reqd_id = $request->master_leavetype;
        $office_upd_id = $request->officename_upd;
        $leavetype_upd = $request->leavetype_upd;
        $leave_entitle_upd = $request->leave_entitle_upd;
        $leave_desc_upd = $request->leave_desc_upd;
        LeaveType::where('id',$reqd_id)->update(array('office_id'=>$office_upd_id, 'leave_name'=>$leavetype_upd, 'leave_entitle'=>$leave_entitle_upd, 'leave_desc'=>$leave_desc_upd));
        return redirect()->route('master-leavetype.index')->with('success', 'Department updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeaveType  $leaveType
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeaveType $leaveType, Request $request)
    {
        $reqd_id = $request->master_leavetype;

        $leave_data = LeaveType::where('id', $reqd_id)->first();

            //$fdat->fetch($request->f_dat)->delete();
        $leave_data->delete();
        return redirect()->route('master-leavetype.index')->with('success', 'Leave Type deleted successfully');
    }
}
