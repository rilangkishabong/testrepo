<?php

namespace App\Http\Controllers;

use App\Models\DeputeStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\OfficeMgmt;
use App\Models\DepartmentMgmt;
use App\Models\ShiftTime;
use App\Models\TourProgramme;
use Psy\Shell;

class DeputeStaffController extends Controller
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
        $allusers = User::get(['id', 'name']);
        $mydets = User::where('id', $userId)->first();
        $stime = ShiftTime::get(['id', 'timename']);
        $tours = TourProgramme::get(['id', 'tour_prog']);
        $depute_stafs = DeputeStaff::
        join('users', 'users.id', '=', 'depute_staff.dep_emp_name_id')
        ->join('tour_programmes', 'tour_programmes.id', '=', 'depute_staff.dep_tour_id')
        ->join('deput_statuses', 'deput_statuses.id', '=', 'depute_staff.dep_status')
        ->join('department_mgmts', 'department_mgmts.id', '=', 'depute_staff.dep_emp_depm_id')
        ->whereNotNull('users.account_type')
        ->where('depute_staff.is_for', "depute")
        ->get(
            ['users.name', 'users.desg', 'users.emp_id', 'department_mgmts.dept_name'
            , 'depute_staff.dep_reason', 'depute_staff.dep_locatn', 'depute_staff.dep_date_from'
            , 'depute_staff.dep_date_to', 'depute_staff.shift_time', 'depute_staff.dep_no_of_days'
            , 'depute_staff.date_posted', 'tour_programmes.tour_prog', 'depute_staff.id'
            , 'deput_statuses.id as tourid', 'deput_statuses.deput_status']
        );
        //dd($depute_stafs);
        $depute_staf_cnt = count($depute_stafs);
        $curdate = date('Y-m-d');
        return view('admin-depute-staff', [
            'userId' => $userId
            , 'mydets' => $mydets
            , 'curdate' => $curdate
            , 'allusers' => $allusers
            , 'tours' => $tours
            , 'stime' => $stime
            , 'depute_stafs' => $depute_stafs
            , 'depute_staf_cnt' => $depute_staf_cnt
        ]);
    }
//
    public function AcceptDeputeStaff(Request $request)
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
        $id = $request->depid;
        $userId = Auth::id();
        $allusers = User::get(['id', 'name']);
        $mydets = User::where('id', $userId)->first();
        $stime = ShiftTime::get(['id', 'timename']);
        $tours = TourProgramme::get(['id', 'tour_prog']);
        $depute_staf_upd = DeputeStaff::
        join('users', 'users.id', '=', 'depute_staff.dep_emp_name_id')
        ->join('deput_statuses', 'deput_statuses.id', '=', 'depute_staff.dep_status')
        ->join('tour_programmes', 'tour_programmes.id', '=', 'depute_staff.dep_tour_id')
        ->join('department_mgmts', 'department_mgmts.id', '=', 'depute_staff.dep_emp_depm_id')
        ->whereNotNull('users.account_type')
        ->where('depute_staff.dep_emp_name_id', $userId)
        ->where('is_for', "depute")
        ->get(
            ['users.name', 'users.desg', 'users.emp_id', 'department_mgmts.dept_name'
            , 'department_mgmts.id as did', 'depute_staff.dep_desc', 'depute_staff.dep_emp_name_id'
            , 'depute_staff.dep_reason', 'depute_staff.dep_locatn', 'depute_staff.dep_date_from'
            , 'depute_staff.dep_date_to', 'depute_staff.shift_time', 'depute_staff.dep_no_of_days'
            , 'depute_staff.date_posted', 'tour_programmes.tour_prog', 'depute_staff.id'
            , 'depute_staff.dep_tour_id', 'users.id as uid', 'deput_statuses.id as tourid'
            , 'deput_statuses.deput_status']
        );
        $depute_staf_cnt = count($depute_staf_upd);
        return view('depute-request',[
            'userId' => $userId
            , 'mydets' => $mydets
            , 'allusers' => $allusers
            , 'depute_staf_cnt' => $depute_staf_cnt
            , 'tours' => $tours
            , 'stime' => $stime
            , 'depute_stafs' => $depute_staf_upd
        ]);
    }//
    public function UpdateDeputeStatus(Request $request)
    {
        $req_id = $request->myid;
        DeputeStaff::where('id', $req_id)->update(array('dep_status'=>1));
        return response()->json(['success', "Status Updated Successfully"]);
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
    public function UpdateDeputeDatax(Request $request)
    {

        $prid = $request->prid;
        $empname_upd = $request->empname_upd;
        $empid_upd = $request->empid_upd;
        // $empdesg_upd = $request->usrid;
        // $empdepid_upd = $request->empdepid_upd;
        $emptours_upd = $request->emptours_upd;
        $empspectour_upd = $request->empspectour_upd;
        $empreason_upd = $request->empreason_upd;
        $emplocatn_upd = $request->emplocatn_upd;
        $empdatefr_upd = $request->empdatefr_upd;
        $empdateto_upd = $request->empdateto_upd;
        $emptime_upd = $request->emptime_upd;
        $empnod_upd = $request->empnod_upd;

        DeputeStaff::where('id', $prid)->update(array('dep_emp_id'=>$empid_upd, 'dep_emp_name_id'=>$empname_upd
        , 'dep_tour_id'=>$emptours_upd
        , 'dep_date_from'=>$empdatefr_upd, 'dep_date_to'=>$empdateto_upd, 'dep_no_of_days'=>$empnod_upd
        , 'shift_time'=>$emptime_upd
        , 'dep_desc'=>$empspectour_upd, 'dep_locatn'=>$emplocatn_upd, 'dep_reason'=>$empreason_upd
        ));

        return response()->json(['success', 'Data updated successfully']);
    }
    public function GetDeputDatas(Request $request)
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
        $id = $request->depid;
        $userId = Auth::id();
        $allusers = User::get(['id', 'name']);
        $mydets = User::where('id', $userId)->first();
        $stime = ShiftTime::get(['id', 'timename']);
        $tours = TourProgramme::get(['id', 'tour_prog']);
        $depute_staf_upd = DeputeStaff::
        join('users', 'users.id', '=', 'depute_staff.dep_emp_name_id')
        ->join('tour_statuses', 'tour_statuses.id', '=', 'depute_staff.dep_status')
        ->join('tour_programmes', 'tour_programmes.id', '=', 'depute_staff.dep_tour_id')
        ->join('department_mgmts', 'department_mgmts.id', '=', 'depute_staff.dep_emp_depm_id')
        ->whereNotNull('users.account_type')
        ->where('depute_staff.id', $id)
        ->where('depute_staff.is_for', "depute")
        ->get(
            ['users.name', 'users.desg', 'users.emp_id', 'department_mgmts.dept_name'
            , 'department_mgmts.id as did', 'depute_staff.dep_desc', 'depute_staff.dep_emp_name_id'
            , 'depute_staff.dep_reason', 'depute_staff.dep_locatn', 'depute_staff.dep_date_from'
            , 'depute_staff.dep_date_to', 'depute_staff.shift_time', 'depute_staff.dep_no_of_days'
            , 'depute_staff.date_posted', 'tour_programmes.tour_prog', 'depute_staff.id'
            , 'depute_staff.dep_tour_id', 'users.id as uid', 'tour_statuses.id as tourid'
            , 'depute_staff.date_posted', 'tour_statuses.tour_status']
        );
        //dd($depute_stafs);
        return response()->json([
            'userId' => $userId
            , 'mydets' => $mydets
            , 'allusers' => $allusers
            , 'tours' => $tours
            , 'stime' => $stime
            , 'depute_staf_upd' => $depute_staf_upd
        ]);
    }
    public function store(Request $request)
    {
        $deput = new DeputeStaff();
        $deput->dep_emp_name_id = $request->empname;
        $deput->dep_emp_id = $request->empids;
        $deput->dep_emp_depm_id = $request->empdepid;
        $deput->dep_emp_desg_id = $request->empname;
        $deput->dep_tour_id = $request->emptour;
        $deput->dep_desc = $request->empspectour;
        $deput->dep_reason = $request->empreason;
        $deput->dep_locatn = $request->emplocatn;
        $deput->dep_date_from = $request->empdatefr;
        $deput->dep_date_to = $request->empdateto;
        $deput->shift_time = $request->emptime;
        $deput->dep_no_of_days = $request->empnod;
        $deput->dep_status = 4;
        $deput->tada_status_id = 4;
        $deput->is_for = "depute";
        $deput->date_posted = $request->emp_date;
        $deput->save();
        return redirect()->route('depute-staff.index')->with('success', 'Data Saved Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeputeStaff  $deputeStaff
     * @return \Illuminate\Http\Response
     */
    public function show(DeputeStaff $deputeStaff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeputeStaff  $deputeStaff
     * @return \Illuminate\Http\Response
     */
    public function edit(DeputeStaff $deputeStaff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeputeStaff  $deputeStaff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeputeStaff $deputeStaff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeputeStaff  $deputeStaff
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
        $reqd_id = $request->depute_staff;
        DeputeStaff::where('id', $reqd_id)->update(array('dep_status'=>3));
        return redirect()->route('depute-staff.index')->with('success', 'Cancelled successfully');
    }
}
