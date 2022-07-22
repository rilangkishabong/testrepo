<?php

namespace App\Http\Controllers;

use App\Models\DepartmentMgmt;
use App\Models\DeputeStaff;
use App\Models\ShiftTime;
use App\Models\TourProgramme;
use App\Models\TourStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourStatusController extends Controller
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
        $deptname = DepartmentMgmt::where('id', $mydets->dept_id)->get(['dept_name']);
        $depute_staf_upd = DeputeStaff::
        join('users', 'users.id', '=', 'depute_staff.dep_emp_name_id')
        ->join('tour_statuses', 'tour_statuses.id', '=', 'depute_staff.dep_status')
        ->join('tour_programmes', 'tour_programmes.id', '=', 'depute_staff.dep_tour_id')
        ->join('department_mgmts', 'department_mgmts.id', '=', 'depute_staff.dep_emp_depm_id')
        ->whereNotNull('users.account_type')
        ->where('depute_staff.dep_emp_name_id', $userId)
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
        return view('request-tour',[
            'userId' => $userId
            , 'mydets' => $mydets
            , 'allusers' => $allusers
            , 'depute_staf_cnt' => $depute_staf_cnt
            , 'tours' => $tours
            , 'stime' => $stime
            , 'depute_stafs' => $depute_staf_upd
            , 'department_name' => $deptname[0]->dept_name
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TourStatus  $tourStatus
     * @return \Illuminate\Http\Response
     */
    public function show(TourStatus $tourStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TourStatus  $tourStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TourStatus $tourStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TourStatus  $tourStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TourStatus $tourStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TourStatus  $tourStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(TourStatus $tourStatus)
    {
        //
    }
}
