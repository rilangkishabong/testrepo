<?php

namespace App\Http\Controllers;

use App\Models\DepartmentMgmt;
use App\Models\DeputeStaff;
use App\Models\ShiftTime;
use App\Models\TourList;
use App\Models\TourProgramme;
use App\Models\TourStatus;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class TourListController extends Controller
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
        $department_name = DepartmentMgmt::where('id', $mydets->dept_id)->get(['dept_name', 'id']);
        $stime = ShiftTime::get(['id', 'timename']);
        $tours = TourProgramme::get(['id', 'tour_prog']);
        $depute_stafs = DeputeStaff::
        join('users', 'users.id', '=', 'depute_staff.dep_emp_name_id')
        ->join('tour_programmes', 'tour_programmes.id', '=', 'depute_staff.dep_tour_id')
        ->join('tour_statuses', 'tour_statuses.id', '=', 'depute_staff.dep_status')
        ->join('department_mgmts', 'department_mgmts.id', '=', 'depute_staff.dep_emp_depm_id')
        ->whereNotNull('users.account_type')
        ->where('depute_staff.is_for', "tour")
        ->where('users.id', $userId)
        ->get(
            ['users.name', 'users.desg', 'users.emp_id', 'department_mgmts.dept_name'
            , 'depute_staff.dep_reason', 'depute_staff.dep_locatn', 'depute_staff.dep_date_from'
            , 'depute_staff.dep_date_to', 'depute_staff.shift_time', 'depute_staff.dep_no_of_days'
            , 'depute_staff.date_posted', 'tour_programmes.tour_prog', 'depute_staff.id'
            , 'tour_statuses.id as tourid', 'tour_statuses.tour_status']
        );
        //dd($depute_stafs);
        $depute_staf_cnt = count($depute_stafs);
        $curdate = date('Y-m-d');
        return view('request-tour', [
            'userId' => $userId
            , 'mydets' => $mydets
            , 'department_name' => $department_name[0]->dept_name
            , 'curdate' => $curdate
            , 'allusers' => $allusers
            , 'tours' => $tours
            , 'stime' => $stime
            , 'depute_stafs' => $depute_stafs
            , 'depute_staf_cnt' => $depute_staf_cnt
        ]);
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
        $chk_avl = DeputeStaff::where('dep_emp_name_id',$request->empidx)
        ->where('dep_date_from','<=', $request->empdatefr)
        ->where('dep_date_to','>=', $request->empdateto)
        ->count();
        if($chk_avl>0)
        {
            return redirect()->route('request-tour.index')->with('success', 'Your Request is not available on the given dates');
        }
        else
        {
            $deput = new DeputeStaff();
            $deput->dep_emp_name_id = $request->empidx;
            $deput->dep_emp_id = $request->empids;
            $deput->dep_emp_depm_id = $request->empdepid;
            $deput->dep_emp_desg_id = $request->empidx;
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
            $deput->is_for = "tour";
            $deput->date_posted = $request->emp_date;
            $deput->save();
            return redirect()->route('request-tour.index')->with('success', 'Data Saved Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TourList  $tourList
     * @return \Illuminate\Http\Response
     */
    public function show(TourList $tourList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TourList  $tourList
     * @return \Illuminate\Http\Response
     */
    public function edit(TourList $tourList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TourList  $tourList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TourList $tourList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TourList  $tourList
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
        return redirect()->route('request-tour.index')->with('success', 'Cancelled successfully');
    }
    public function GetTourDatas(Request $request)
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
        ->where('depute_staff.is_for', "tour")
        ->get(
            ['users.name', 'users.desg', 'users.emp_id', 'department_mgmts.dept_name'
            , 'department_mgmts.id as did', 'depute_staff.dep_desc', 'depute_staff.dep_emp_name_id'
            , 'depute_staff.dep_reason', 'depute_staff.dep_locatn', 'depute_staff.dep_date_from'
            , 'depute_staff.dep_date_to', 'depute_staff.shift_time', 'depute_staff.dep_no_of_days'
            , 'depute_staff.date_posted', 'tour_programmes.tour_prog', 'depute_staff.id'
            , 'depute_staff.dep_tour_id', 'users.id as uid', 'tour_statuses.id as tourid'
            , 'depute_staff.date_posted', 'tour_statuses.tour_status', 'depute_staff.is_for']
        );
        //dd($depute_staf_upd);
        return response()->json([
            'userId' => $userId
            , 'mydets' => $mydets
            , 'allusers' => $allusers
            , 'tours' => $tours
            , 'stime' => $stime
            , 'depute_staf_upd' => $depute_staf_upd
        ]);
    }
    public function GetTourStatus(Request $request)
    {
        $req_id = $request->btnid;
        $tourstat = TourStatus::get(['tour_status', 'id']);
        $seltour = DeputeStaff::where('id', $req_id)->get(['dep_status', 'dep_emp_name_id']);
        return response()->json(['tourstat'=>$tourstat, 'seltour'=>$seltour]);
    }
    public function UpdateTourStatus(Request $request)
    {
        $req_id = $request->tourid;
        $tourstat = $request->tourstat;
        $emp_date = $request->emp_date;
        //dd($req_id." ".$tourstat." ".$emp_date);
        DeputeStaff::where('id', $req_id)
        ->update(array('dep_status'=>$tourstat, 'date_posted'=>$emp_date));
        //
        return response()->json(['success', "Status Updated Successfully"]);
    }
    public function UpdateTourDatax(Request $request)
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
        $prid = $request->prid;
        $userId = Auth::id();
        $empname_upd = $userId;
        $empid_upd = $request->empid_upd;
        $empdesg_upd = $userId;
        $empdepid_upd = $userId;
        $emptours_upd = $request->emptours_upd;
        $empspectour_upd = $request->empspectour_upd;
        $empreason_upd = $request->empreason_upd;
        $emplocatn_upd = $request->emplocatn_upd;
        $empdatefr_upd = $request->empdatefr_upd;
        $empdateto_upd = $request->empdateto_upd;
        $emptime_upd = $request->emptime_upd;
        $empnod_upd = $request->empnod_upd;

        DeputeStaff::where('id', $prid)->update(array('dep_emp_id'=>$empid_upd, 'dep_emp_name_id'=>$empname_upd
        , 'dep_emp_depm_id'=>$empdepid_upd
        , 'dep_tour_id'=>$emptours_upd, 'dep_emp_desg_id'=>$empdesg_upd
        , 'dep_date_from'=>$empdatefr_upd, 'dep_date_to'=>$empdateto_upd, 'dep_no_of_days'=>$empnod_upd
        , 'shift_time'=>$emptime_upd
        , 'dep_desc'=>$empspectour_upd, 'dep_locatn'=>$emplocatn_upd, 'dep_reason'=>$empreason_upd
        ));

        return response()->json(['success', 'Data updated successfully']);
    }
//ApprovedTours
    public function ManageTours(Request $request)
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
        $department_name = DepartmentMgmt::where('id', $mydets->dept_id)->get(['dept_name']);
        $stime = ShiftTime::get(['id', 'timename']);
        $tours = TourProgramme::get(['id', 'tour_prog']);
        $curdate = date('Y-m-d');
        $depute_staf_upd = DeputeStaff::
        join('users', 'users.id', '=', 'depute_staff.dep_emp_name_id')
        ->join('tour_statuses', 'tour_statuses.id', '=', 'depute_staff.dep_status')
        ->join('tour_programmes', 'tour_programmes.id', '=', 'depute_staff.dep_tour_id')
        ->join('department_mgmts', 'department_mgmts.id', '=', 'depute_staff.dep_emp_depm_id')
        ->whereNotNull('users.account_type')
        ->where('depute_staff.is_for', "tour")
        ->where('depute_staff.dep_status', '!=', 1)
        ->where('depute_staff.dep_status', '!=', 2)
        ->where('depute_staff.dep_status', '!=', 3)
        ->get(
            ['users.name', 'users.desg', 'users.emp_id', 'department_mgmts.dept_name'
            , 'department_mgmts.id as did', 'depute_staff.dep_desc', 'depute_staff.dep_emp_name_id'
            , 'depute_staff.dep_reason', 'depute_staff.dep_locatn', 'depute_staff.dep_date_from'
            , 'depute_staff.dep_date_to', 'depute_staff.shift_time', 'depute_staff.dep_no_of_days'
            , 'depute_staff.date_posted', 'tour_programmes.tour_prog', 'depute_staff.id'
            , 'depute_staff.dep_tour_id', 'users.id as uid', 'tour_statuses.id as tourid'
            , 'tour_statuses.tour_status']
        );
        $depute_staf_cnt = count($depute_staf_upd);

        return view('manage-tour-request',[
            'userId' => $userId
            , 'mydets' => $mydets
            , 'allusers' => $allusers
            , 'depute_staf_cnt' => $depute_staf_cnt
            , 'tours' => $tours
            , 'stime' => $stime
            , 'curdate' => $curdate
            , 'department_name' => $department_name
            , 'depute_stafs' => $depute_staf_upd
        ]);
    }

    public function ApprovedTours(Request $request)
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
        $department_name = DepartmentMgmt::where('id', $mydets->dept_id)->get(['dept_name']);
        $stime = ShiftTime::get(['id', 'timename']);
        $tours = TourProgramme::get(['id', 'tour_prog']);
        $curdate = date('Y-m-d');
        $depute_staf_upd = DeputeStaff::
        join('users', 'users.id', '=', 'depute_staff.dep_emp_name_id')
        ->join('tour_statuses', 'tour_statuses.id', '=', 'depute_staff.dep_status')
        ->join('tour_programmes', 'tour_programmes.id', '=', 'depute_staff.dep_tour_id')
        ->join('department_mgmts', 'department_mgmts.id', '=', 'depute_staff.dep_emp_depm_id')
        ->whereNotNull('users.account_type')
        ->where('depute_staff.is_for', "tour")
        ->where('depute_staff.dep_status', 1)
        ->get(
            ['users.name', 'users.desg', 'users.emp_id', 'department_mgmts.dept_name'
            , 'department_mgmts.id as did', 'depute_staff.dep_desc', 'depute_staff.dep_emp_name_id'
            , 'depute_staff.dep_reason', 'depute_staff.dep_locatn', 'depute_staff.dep_date_from'
            , 'depute_staff.dep_date_to', 'depute_staff.shift_time', 'depute_staff.dep_no_of_days'
            , 'depute_staff.date_posted', 'tour_programmes.tour_prog', 'depute_staff.id'
            , 'depute_staff.dep_tour_id', 'users.id as uid', 'tour_statuses.id as tourid'
            , 'tour_statuses.tour_status']
        );
        $depute_staf_cnt = count($depute_staf_upd);
        //dd($depute_stafs);
        return view('accepted-tour-request-pg',[
            'userId' => $userId
            , 'mydets' => $mydets
            , 'allusers' => $allusers
            , 'depute_staf_cnt' => $depute_staf_cnt
            , 'tours' => $tours
            , 'stime' => $stime
            , 'curdate' => $curdate
            , 'department_name' => $department_name
            , 'depute_stafs' => $depute_staf_upd
        ]);
    }

    public function RejectedTours(Request $request)
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
        $department_name = DepartmentMgmt::where('id', $mydets->dept_id)->get(['dept_name']);
        $stime = ShiftTime::get(['id', 'timename']);
        $tours = TourProgramme::get(['id', 'tour_prog']);
        $curdate = date('Y-m-d');
        $depute_staf_upd = DeputeStaff::
        join('users', 'users.id', '=', 'depute_staff.dep_emp_name_id')
        ->join('tour_statuses', 'tour_statuses.id', '=', 'depute_staff.dep_status')
        ->join('tour_programmes', 'tour_programmes.id', '=', 'depute_staff.dep_tour_id')
        ->join('department_mgmts', 'department_mgmts.id', '=', 'depute_staff.dep_emp_depm_id')
        ->whereNotNull('users.account_type')
        //->where('depute_staff.dep_emp_name_id', $userId)
        ->where('depute_staff.dep_status', 2)
        ->get(
            ['users.name', 'users.desg', 'users.emp_id', 'department_mgmts.dept_name'
            , 'department_mgmts.id as did', 'depute_staff.dep_desc', 'depute_staff.dep_emp_name_id'
            , 'depute_staff.dep_reason', 'depute_staff.dep_locatn', 'depute_staff.dep_date_from'
            , 'depute_staff.dep_date_to', 'depute_staff.shift_time', 'depute_staff.dep_no_of_days'
            , 'depute_staff.date_posted', 'tour_programmes.tour_prog', 'depute_staff.id'
            , 'depute_staff.dep_tour_id', 'users.id as uid', 'tour_statuses.id as tourid'
            , 'tour_statuses.tour_status']
        );
        $depute_staf_cnt = count($depute_staf_upd);
        //dd($depute_stafs);
        return view('rejected-tour-request',[
            'userId' => $userId
            , 'mydets' => $mydets
            , 'allusers' => $allusers
            , 'depute_staf_cnt' => $depute_staf_cnt
            , 'tours' => $tours
            , 'stime' => $stime
            , 'curdate' => $curdate
            , 'department_name' => $department_name
            , 'depute_stafs' => $depute_staf_upd
        ]);
    }
}
