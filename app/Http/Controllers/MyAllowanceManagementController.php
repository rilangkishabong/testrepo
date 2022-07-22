<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\DeputeStaff;
use App\Models\MyAllowanceManagement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAllowanceManagementController extends Controller
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
        $mydets = User::where('id', $userId)->first();
        $all_allw = Allowance::all();
        $allw_datas = DeputeStaff::join('my_allowance_management', 'my_allowance_management.allw_id', '=', 'depute_staff.id')
        ->join('users', 'depute_staff.dep_emp_name_id', '=', 'users.id')
        ->join('tour_programmes', 'depute_staff.dep_tour_id', '=', 'tour_programmes.id')
        ->join('department_mgmts', 'depute_staff.dep_emp_depm_id', '=', 'department_mgmts.id')
        ->join('tour_report_attches', 'depute_staff.attch_id', '=', 'tour_report_attches.id')
        ->join('tada_statuses', 'tada_statuses.id', '=', 'tour_report_attches.tadastat_id')
        ->where('depute_staff.dep_status', 1)
        ->get([
            'my_allowance_management.id as mid', 'my_allowance_management.allw_amt'
        , 'users.name', 'users.desg', 'department_mgmts.dept_name', 'tour_programmes.tour_prog'
        , 'depute_staff.dep_reason', 'depute_staff.dep_locatn', 'depute_staff.dep_date_from'
        , 'depute_staff.dep_date_to', 'tour_report_attches.tr_pt_of_origin'
        , 'tour_report_attches.tr_pt_of_destination', 'tada_statuses.tada_stat'
            ]);
        //dd($allw_datas);
        return view("my-ta-da-claims", ['mydets'=>$mydets, 'all_allw'=>$all_allw, 'allw_datas'=>$allw_datas]);
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
     * @param  \App\Models\MyAllowanceManagement  $myAllowanceManagement
     * @return \Illuminate\Http\Response
     */
    public function show(MyAllowanceManagement $myAllowanceManagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MyAllowanceManagement  $myAllowanceManagement
     * @return \Illuminate\Http\Response
     */
    public function edit(MyAllowanceManagement $myAllowanceManagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MyAllowanceManagement  $myAllowanceManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MyAllowanceManagement $myAllowanceManagement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MyAllowanceManagement  $myAllowanceManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(MyAllowanceManagement $myAllowanceManagement)
    {
        //
    }
}
