<?php

namespace App\Http\Controllers;

use App\Models\DepartmentMgmt;
use App\Models\EmployeeLeaveSummary;
use App\Models\LeaveApplicatnList;
use App\Models\LeaveStatus;
use App\Models\LeaveTypeMaster;
use App\Models\LeaveTypeMgmt;
use App\Models\OfficeMgmt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeLeaveSummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function EmployeeLeaveSummary(Request $request)
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
        // $firstday = date('Y-m-d', strtotime('2020-03-03'));
        // $ldate = date('Y-m-d', strtotime('2020-03-04'));
        $curdate = "";
        $curmonth = "";
        $curyear = "";
        $yeararr = ['2018', '2019', '2020', '2021', '2022'];
        $months = ['January', 'February', 'March', 'April', 'May', 'June'
        , 'July', 'August', 'September', 'October', 'November', 'December'];
        $leavetypes = LeaveTypeMaster::all();
        $firstday = date('Y-m-d', strtotime('first day of january this year'));
        $ldate = date('Y-m-d');
        $userId = Auth::id();
        $mydets = User::where('id', $userId)->first();
        $allusers = User::whereNotNull('account_type')
        ->where('account_type', '!=', 'admin')
        ->get(['id', 'desg', 'name']);
        $leaveavl = LeaveTypeMgmt::join('leave_type_masters', 'leave_type_masters.id', '=', 'leave_type_mgmts.leave_type_id')
        //->where('office_id', $mydets->office_id)
        ->get(['leave_type_mgmts.id', 'leave_type_masters.leavename', 'leave_type_mgmts.office_id', 'leave_type_mgmts.leave_entitle']);

        if (count($leaveavl) > 0) {
            $tbl = "<table class='display' id='tableID'>";
            $tbl .= "<thead>";
            $tbl .= "<tr>";
            $tbl .= "<th>Employee Name</th>";
            $tbl .= "<th>Employee Designation</th>";
            $tbl .= "<th>Leave Type</th>";
            $tbl .= "<th>Leave Entitle</th>";
            $tbl .= "<th>Leave taken</th>";
            $tbl .= "<th>Leave Available</th>";
            $tbl .= "</tr>";
            $tbl .= "</thead>";
            $tbl .= "<tbody>";
            for ($i1 = 0; $i1 < count($allusers); $i1++) {
                for ($i = 0; $i < count($leaveavl); $i++) {
                    $leaveleft = 0;
                    $leavetkn = 0;
                    $leavelist = LeaveApplicatnList::
                    whereBetween('date_posted', [$firstday, $ldate])->
                        where('emp_name_id', $allusers[$i1]->id)->
                        where('leave_stats_id', 1)
                        ->where('leave_type_id', $leaveavl[$i]->id)
                        ->get(['no_of_days', 'date_posted']);
                    if (count($leavelist) == 0) {
                        $leavetkn = 0;
                        $leaveleft = $leaveavl[$i]->leave_entitle;
                    } else {
                        $curdate = date('Y-m-d', strtotime($leavelist[0]->date_posted));
                        $curmonth = date('F', strtotime($curdate));
                        $curyear = date('Y', strtotime($curdate));
                        $leavetkn = LeaveApplicatnList::
                        whereBetween('date_posted', [$firstday, $ldate])->
                            where('emp_name_id', $userId)->where('leave_stats_id', '1')
                            ->where('leave_type_id', $leaveavl[$i]->id)
                            ->sum('no_of_days');
                        $leavetkn = $leavelist[0]->no_of_days;
                        $leaveleft = $leaveavl[$i]->leave_entitle - $leavetkn;
                    }
                    $tbl .= "<tr>";
                    $tbl .= "<td>" . $allusers[$i1]->name . "</td>";
                    $tbl .= "<td>" . $allusers[$i1]->desg . "</td>";
                    $tbl .= "<td>" . $leaveavl[$i]->leavename . "<span style='display:none'>".$curmonth."</span>"
                    ."<span style='display:none'>".$curyear."</span>"."</td>";
                    $tbl .= "<td>" . $leaveavl[$i]->leave_entitle . "</td>";
                    $tbl .= "<td>" . $leavetkn . "</td>";
                    $tbl .= "<td>" . $leaveleft ."</td>";
                    $tbl .= "</tr>";
                }
            }
            $tbl .= "</tbody>";
            $tbl .= "</table>";
        } else {
            $tbl = "<table class='display' id='tableID'>";
            $tbl .= "<thead>";
            $tbl .= "<tr>";
            $tbl .= "<th>Employee Name</th>";
            $tbl .= "<th>Employee Designation</th>";
            $tbl .= "<th>Leave Type</th>";
            $tbl .= "<th>Leave Entitle</th>";
            $tbl .= "<th>Leave taken(After Approved)</th>";
            $tbl .= "<th>Leave Available</th>";
            $tbl .= "</tr>";
            $tbl .= "</thead>";
            $tbl .= "<tbody>";
            $tbl .= "<tr>";
            $tbl .= "<td>No data available</td>";
            $tbl .= "<td></td>";
            $tbl .= "<td></td>";
            $tbl .= "<td></td>";
            $tbl .= "<td></td>";
            $tbl .= "<td></td>";
            $tbl .= "</tr>";
            $tbl .= "</tbody>";
            $tbl .= "</table>";
        }
        $office = OfficeMgmt::where('id', $mydets->office_id)->get(['office_name']);
        $department = DepartmentMgmt::where('id', $mydets->dept_id)->get(['id', 'dept_name']);
        $departmentname = '';
        $departmentid = '';
        if(count($department)>0){
            $departmentname = $department[0]->dept_name;
            $departmentid = $department[0]->id;
        }
        else
        {
            $departmentname = '';
            $departmentid = 0;
        }
        $leavestatus = LeaveStatus::all();
        return view('employee-leave-summary', [
            'userId' => $userId
            , 'mydets' => $mydets
            , 'tabl' => $tbl
            , 'yeararr' => $yeararr
            , 'months' => $months
            , 'leavetypes' => $leavetypes
            , 'employees' => $allusers
        ]);
    }
    public function index()
    {
        //
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
     * @param  \App\Models\EmployeeLeaveSummary  $employeeLeaveSummary
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeLeaveSummary $employeeLeaveSummary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployeeLeaveSummary  $employeeLeaveSummary
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeLeaveSummary $employeeLeaveSummary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeLeaveSummary  $employeeLeaveSummary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeLeaveSummary $employeeLeaveSummary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeeLeaveSummary  $employeeLeaveSummary
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeLeaveSummary $employeeLeaveSummary)
    {
        //
    }
}
