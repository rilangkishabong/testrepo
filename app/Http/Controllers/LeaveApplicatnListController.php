<?php

namespace App\Http\Controllers;

use App\Models\DepartmentMgmt;
use App\Models\LeaveApplicatnList;
use App\Models\LeaveStatus;
use App\Models\LeaveTypeMaster;
use App\Models\LeaveTypeMgmt;
use App\Models\OfficeMgmt;
use App\Models\User;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Auth;

class LeaveApplicatnListController extends Controller
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
        $curdt = date('d/m/Y');
        $userId = Auth::id();
        $mydets = User::where('id', $userId)->first();
        $leavetype_apps = LeaveApplicatnList::join('users', 'users.id', '=', 'leave_applicatn_lists.emp_name_id')
            ->join('leave_type_masters', 'leave_type_masters.id', '=', 'leave_applicatn_lists.leave_type_id')
            ->join('leave_statuses', 'leave_statuses.id', '=', 'leave_applicatn_lists.leave_stats_id')
            ->where('leave_applicatn_lists.leave_stats_id', 4)
            ->get([//date('d/m/Y', strtotime(leave_applicatn_lists.date_from)
                'leave_applicatn_lists.id', 'leave_applicatn_lists.id', 'users.name', 'users.desg'
                , 'leave_applicatn_lists.date_from', 'leave_applicatn_lists.date_to', 'users.emp_id'
                , 'leave_applicatn_lists.no_of_days', 'leave_applicatn_lists.shift_time'
                , 'leave_type_masters.leavename', 'leave_applicatn_lists.reason', 'leave_statuses.leave_status'
                , 'leave_applicatn_lists.remks', 'leave_applicatn_lists.date_posted'
            ]);

        $leavetype_apps_cnt = count($leavetype_apps);
        return view('approv-auth-leave-applist', [
                'userId' => $userId
            , 'mydets' => $mydets
            , 'curdt' => $curdt
            , 'leavetype_apps' => $leavetype_apps
            , 'leavetype_apps_cnt' => $leavetype_apps_cnt
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
    public function CancelAppliedLeave(Request $request)
    {
        $id = $request->req;
        LeaveApplicatnList::where('id', $id)->update(array('leave_stats_id'=>3));
        return response()->json(['success'=>"Cancelled Successfully"]);
    }

    public function EmployeeLeaveList(Request $request)
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
        $employees = User::whereNotNull('account_type')->get(['id', 'name']);
        $yeararr = ['2018', '2019', '2020', '2021', '2022'];
        $months = ['January', 'February', 'March', 'April', 'May', 'June'
        , 'July', 'August', 'September', 'October', 'November', 'December'];
        $leavetypes = LeaveTypeMaster::all();
        $firstday = date('Y-m-d', strtotime('first day of january this year'));
        $curmonth = date('F', strtotime($firstday));


        $mydets = User::where('id', $userId)->first();
        $leavetype_apps = LeaveApplicatnList::join('users', 'users.id', '=', 'leave_applicatn_lists.emp_name_id')
            ->join('leave_type_masters', 'leave_type_masters.id', '=', 'leave_applicatn_lists.leave_type_id')
            ->join('leave_statuses', 'leave_statuses.id', '=', 'leave_applicatn_lists.leave_stats_id')
            ->whereNotNull('leave_applicatn_lists.leave_stats_id')
            ->get([
                'leave_applicatn_lists.id', 'leave_applicatn_lists.leave_stats_id'
                , 'users.name', 'users.desg', 'leave_statuses.leave_status'
                , 'leave_applicatn_lists.date_from', 'leave_applicatn_lists.date_to'
                , 'leave_applicatn_lists.no_of_days', 'leave_applicatn_lists.shift_time'
                , 'leave_type_masters.leavename', 'leave_applicatn_lists.reason'
                , 'leave_applicatn_lists.remks', 'leave_applicatn_lists.date_posted'
            ]);

        $leavetype_apps_cnt = count($leavetype_apps);
        return view('list-of-employee-leave', [
                'userId' => $userId
            , 'employees' => $employees
            , 'yeararr' => $yeararr
            , 'months' => $months
            , 'leavetypes' => $leavetypes
            , 'mydets' => $mydets
            , 'leavetype_apps' => $leavetype_apps
            , 'leavetype_apps_cnt' => $leavetype_apps_cnt
        ]);
    }
    //
    public function AppliedLeave(Request $request)
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
        $leavetype_apps = LeaveApplicatnList::join('users', 'users.id', '=', 'leave_applicatn_lists.emp_name_id')
            ->join('leave_type_masters', 'leave_type_masters.id', '=', 'leave_applicatn_lists.leave_type_id')
            ->join('leave_statuses', 'leave_statuses.id', '=', 'leave_applicatn_lists.leave_stats_id')
            ->where('leave_applicatn_lists.emp_name_id', $userId)
            ->where('leave_stats_id', 4)
            ->get([
                'leave_applicatn_lists.id', 'users.name', 'users.desg'
                , 'leave_applicatn_lists.date_from', 'leave_applicatn_lists.date_to', 'users.emp_id'
                , 'leave_applicatn_lists.no_of_days', 'leave_applicatn_lists.shift_time'
                , 'leave_applicatn_lists.date_to', 'leave_applicatn_lists.date_from', 'leave_applicatn_lists.no_of_days'
                , 'leave_type_masters.leavename', 'leave_applicatn_lists.reason', 'leave_statuses.leave_status'
                , 'leave_applicatn_lists.remks', 'leave_applicatn_lists.date_posted'
            ]);
            $leavetype_apps_cnt = count($leavetype_apps);
            $firstday = date('Y-m-d', strtotime('first day of january this year'));
            $ldate = date('Y-m-d');
            $yeararr = ['2018', '2019', '2020', '2021', '2022'];
            $months = ['January', 'February', 'March', 'April', 'May', 'June'
            , 'July', 'August', 'September', 'October', 'November', 'December'];

            $tbl = '';
            $tbl .= '';
            $tbl = "<table class='table' id='tableID'>";
            $tbl .= "<thead>";
            $tbl .= "<tr>";
            $tbl .= "<th>Employee Id</th>";
            $tbl .= "<th>Leave Type</th>";
            $tbl .= "<th>Date From</th>";
            $tbl .= "<th>Date To</th>";
            $tbl .= "<th>No Of Days</th>";
            $tbl .= "<th>Shift Time</th>";
            $tbl .= "<th>Leave Reason</th>";
            $tbl .= "<th>Leave Status</th>";
            $tbl .= "<th>Leave Remarks</th>";
            $tbl .= "<th>Date Posted</th>";
            $tbl .= "<th>Action</th>";
            $tbl .= "</tr>";
            $tbl .= "</thead>";
            $tbl .= "<tbody>";
            foreach ($leavetype_apps as $leavetype_apps) {
                $tbl .= "<tr>";
                $tbl .= "<td>" . $leavetype_apps->emp_id . "</td>";
                $tbl .= "<td>" . $leavetype_apps->leavename . "</td>";
                $tbl .= "<td>" . $leavetype_apps->date_from . "</td>";
                $tbl .= "<td>" . $leavetype_apps->date_to . "</td>";
                $tbl .= "<td>" . $leavetype_apps->no_of_days . "</td>";
                $tbl .= "<td>" . $leavetype_apps->shift_time . "</td>";
                $tbl .= "<td>" . $leavetype_apps->reason . "</td>";
                $tbl .= "<td>" . $leavetype_apps->leave_status . "</td>";
                $tbl .= "<td>" . $leavetype_apps->remks . "</td>";
                $curdate = date('Y-m-d', strtotime($leavetype_apps->date_posted));
                $curmonth = date('F', strtotime($curdate));
                $curyear = date('Y', strtotime($curdate));
                $tbl .= "<td>" . $leavetype_apps->date_posted
                ."<span style='display:none'>".''.$curmonth.''.$curyear."</span>". "</td>";
                $timestamp1 = strtotime($leavetype_apps->date_from);
                $day1 = date('d', $timestamp1);
                $timestamp2 = strtotime(date("Y-m-d"));
                $day2 = date('d', $timestamp2);
                if(($leavetype_apps->leave_status=="Approved")||($leavetype_apps->leave_status=="Cancelled"))
                {
                    $tbl .= "<td></td>";
                }
                else if($day1 < $day2)
                {
                    $tbl .= "<td>Date Already Passed</td>";
                }
                else
                {
                    $tbl .= "<td><div class='row'><div class='col-sm-6'><button data-target='#modal-leave' data-id='".$leavetype_apps->id."' class='edtleav'>Edit</button></div>";
                    // <div class='col-sm-6'><button data-id='".$leavetype_apps->id."' class='cancleav'>Cancel</button></div>
                    // </div></td>";
                }
                $tbl .= "</tr>";
            }
            $tbl .= "</tbody>";
            $tbl .= "</table>";

        return view('applied-leave', [
                'userId' => $userId
            , 'mydets' => $mydets
            , 'tbl' => $tbl
            , 'leavetype_apps_cnt' => $leavetype_apps_cnt
        ]);
    }
    public function AcceptedAppliedLeave(Request $request)
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
        $leavetype_apps = LeaveApplicatnList::join('users', 'users.id', '=', 'leave_applicatn_lists.emp_name_id')
            ->join('leave_type_masters', 'leave_type_masters.id', '=', 'leave_applicatn_lists.leave_type_id')
            ->join('leave_statuses', 'leave_statuses.id', '=', 'leave_applicatn_lists.leave_stats_id')
            ->where('leave_applicatn_lists.emp_name_id', $userId)
            ->where('leave_stats_id', 1)
            ->get([
                'leave_applicatn_lists.id', 'users.name', 'users.desg'
                , 'leave_applicatn_lists.date_from', 'leave_applicatn_lists.date_to', 'users.emp_id'
                , 'leave_applicatn_lists.no_of_days', 'leave_applicatn_lists.shift_time'
                , 'leave_applicatn_lists.date_to', 'leave_applicatn_lists.date_from', 'leave_applicatn_lists.no_of_days'
                , 'leave_type_masters.leavename', 'leave_applicatn_lists.reason', 'leave_statuses.leave_status'
                , 'leave_applicatn_lists.remks', 'leave_applicatn_lists.date_posted'
            ]);
            $leavetype_apps_cnt = count($leavetype_apps);
            $firstday = date('Y-m-d', strtotime('first day of january this year'));
            $ldate = date('Y-m-d');
            $yeararr = ['2018', '2019', '2020', '2021', '2022'];
            $months = ['January', 'February', 'March', 'April', 'May', 'June'
            , 'July', 'August', 'September', 'October', 'November', 'December'];

            $tbl = '';
            $tbl .= '';
            $tbl = "<table class='table' id='tableID'>";
            $tbl .= "<thead>";
            $tbl .= "<tr>";
            $tbl .= "<th>Employee Id</th>";
            $tbl .= "<th>Leave Type</th>";
            $tbl .= "<th>Date From</th>";
            $tbl .= "<th>Date To</th>";
            $tbl .= "<th>No Of Days</th>";
            $tbl .= "<th>Shift Time</th>";
            $tbl .= "<th>Leave Reason</th>";
            $tbl .= "<th>Leave Status</th>";
            $tbl .= "<th>Leave Remarks</th>";
            $tbl .= "<th>Date Posted</th>";
            $tbl .= "<th>Action</th>";
            $tbl .= "</tr>";
            $tbl .= "</thead>";
            $tbl .= "<tbody>";
            foreach ($leavetype_apps as $leavetype_apps) {
                $tbl .= "<tr>";
                $tbl .= "<td>" . $leavetype_apps->emp_id . "</td>";
                $tbl .= "<td>" . $leavetype_apps->leavename . "</td>";
                $tbl .= "<td>" . $leavetype_apps->date_from . "</td>";
                $tbl .= "<td>" . $leavetype_apps->date_to . "</td>";
                $tbl .= "<td>" . $leavetype_apps->no_of_days . "</td>";
                $tbl .= "<td>" . $leavetype_apps->shift_time . "</td>";
                $tbl .= "<td>" . $leavetype_apps->reason . "</td>";
                $tbl .= "<td>" . $leavetype_apps->leave_status . "</td>";
                $tbl .= "<td>" . $leavetype_apps->remks . "</td>";
                $curdate = date('Y-m-d', strtotime($leavetype_apps->date_posted));
                $curmonth = date('F', strtotime($curdate));
                $curyear = date('Y', strtotime($curdate));
                $tbl .= "<td>" . $leavetype_apps->date_posted
                ."<span style='display:none'>".''.$curmonth.''.$curyear."</span>". "</td>";
                if(($leavetype_apps->leave_status=="Approved")||($leavetype_apps->leave_status=="Cancelled")){
                    $tbl .= "<td></td>";
                }
                else{
                    $tbl .= "<td><div class='row'><div class='col-sm-6'><button data-target='#modal-leave' data-id='".$leavetype_apps->id."' class='edtleav'>Edit</button></div>";
                    // <div class='col-sm-6'><button data-id='".$leavetype_apps->id."' class='cancleav'>Cancel</button></div>
                    // </div></td>";
                }
                $tbl .= "</tr>";
            }
            $tbl .= "</tbody>";
            $tbl .= "</table>";

        return view('applied-leave', [
                'userId' => $userId
            , 'mydets' => $mydets
            , 'tbl' => $tbl
            , 'leavetype_apps_cnt' => $leavetype_apps_cnt
        ]);
    }
    public function CancelledAppliedLeave(Request $request)
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
        $leavetype_apps = LeaveApplicatnList::join('users', 'users.id', '=', 'leave_applicatn_lists.emp_name_id')
            ->join('leave_type_masters', 'leave_type_masters.id', '=', 'leave_applicatn_lists.leave_type_id')
            ->join('leave_statuses', 'leave_statuses.id', '=', 'leave_applicatn_lists.leave_stats_id')
            ->where('leave_applicatn_lists.emp_name_id', $userId)
            ->where('leave_stats_id', 1)
            ->get([
                'leave_applicatn_lists.id', 'users.name', 'users.desg'
                , 'leave_applicatn_lists.date_from', 'leave_applicatn_lists.date_to', 'users.emp_id'
                , 'leave_applicatn_lists.no_of_days', 'leave_applicatn_lists.shift_time'
                , 'leave_applicatn_lists.date_to', 'leave_applicatn_lists.date_from', 'leave_applicatn_lists.no_of_days'
                , 'leave_type_masters.leavename', 'leave_applicatn_lists.reason', 'leave_statuses.leave_status'
                , 'leave_applicatn_lists.remks', 'leave_applicatn_lists.date_posted'
            ]);
            $leavetype_apps_cnt = count($leavetype_apps);
            $firstday = date('Y-m-d', strtotime('first day of january this year'));
            $ldate = date('Y-m-d');
            $yeararr = ['2018', '2019', '2020', '2021', '2022'];
            $months = ['January', 'February', 'March', 'April', 'May', 'June'
            , 'July', 'August', 'September', 'October', 'November', 'December'];

            $tbl = '';
            $tbl .= '';
            $tbl = "<table class='table' id='tableID'>";
            $tbl .= "<thead>";
            $tbl .= "<tr>";
            $tbl .= "<th>Employee Id</th>";
            $tbl .= "<th>Leave Type</th>";
            $tbl .= "<th>Date From</th>";
            $tbl .= "<th>Date To</th>";
            $tbl .= "<th>No Of Days</th>";
            $tbl .= "<th>Shift Time</th>";
            $tbl .= "<th>Leave Reason</th>";
            $tbl .= "<th>Leave Status</th>";
            $tbl .= "<th>Leave Remarks</th>";
            $tbl .= "<th>Date Posted</th>";
            $tbl .= "<th>Action</th>";
            $tbl .= "</tr>";
            $tbl .= "</thead>";
            $tbl .= "<tbody>";
            foreach ($leavetype_apps as $leavetype_apps) {
                $tbl .= "<tr>";
                $tbl .= "<td>" . $leavetype_apps->emp_id . "</td>";
                $tbl .= "<td>" . $leavetype_apps->leavename . "</td>";
                $tbl .= "<td>" . $leavetype_apps->date_from . "</td>";
                $tbl .= "<td>" . $leavetype_apps->date_to . "</td>";
                $tbl .= "<td>" . $leavetype_apps->no_of_days . "</td>";
                $tbl .= "<td>" . $leavetype_apps->shift_time . "</td>";
                $tbl .= "<td>" . $leavetype_apps->reason . "</td>";
                $tbl .= "<td>" . $leavetype_apps->leave_status . "</td>";
                $tbl .= "<td>" . $leavetype_apps->remks . "</td>";
                $curdate = date('Y-m-d', strtotime($leavetype_apps->date_posted));
                $curmonth = date('F', strtotime($curdate));
                $curyear = date('Y', strtotime($curdate));
                $tbl .= "<td>" . $leavetype_apps->date_posted
                ."<span style='display:none'>".''.$curmonth.''.$curyear."</span>". "</td>";
                if(($leavetype_apps->leave_status=="Approved")||($leavetype_apps->leave_status=="Cancelled")){
                    $tbl .= "<td></td>";
                }
                else{
                    $tbl .= "<td><div class='row'><div class='col-sm-6'><button data-target='#modal-leave' data-id='".$leavetype_apps->id."' class='edtleav'>Edit</button></div>";
                    // <div class='col-sm-6'><button data-id='".$leavetype_apps->id."' class='cancleav'>Cancel</button></div>
                    // </div></td>";
                }
                $tbl .= "</tr>";
            }
            $tbl .= "</tbody>";
            $tbl .= "</table>";

        return view('applied-leave', [
                'userId' => $userId
            , 'mydets' => $mydets
            , 'tbl' => $tbl
            , 'leavetype_apps_cnt' => $leavetype_apps_cnt
        ]);
    }
    public function RejectedAppliedLeave(Request $request)
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
        $leavetype_apps = LeaveApplicatnList::join('users', 'users.id', '=', 'leave_applicatn_lists.emp_name_id')
            ->join('leave_type_masters', 'leave_type_masters.id', '=', 'leave_applicatn_lists.leave_type_id')
            ->join('leave_statuses', 'leave_statuses.id', '=', 'leave_applicatn_lists.leave_stats_id')
            ->where('leave_applicatn_lists.emp_name_id', $userId)
            ->where('leave_stats_id', 2)
            ->get([
                'leave_applicatn_lists.id', 'users.name', 'users.desg'
                , 'leave_applicatn_lists.date_from', 'leave_applicatn_lists.date_to', 'users.emp_id'
                , 'leave_applicatn_lists.no_of_days', 'leave_applicatn_lists.shift_time'
                , 'leave_applicatn_lists.date_to', 'leave_applicatn_lists.date_from', 'leave_applicatn_lists.no_of_days'
                , 'leave_type_masters.leavename', 'leave_applicatn_lists.reason', 'leave_statuses.leave_status'
                , 'leave_applicatn_lists.remks', 'leave_applicatn_lists.date_posted'
            ]);
            $leavetype_apps_cnt = count($leavetype_apps);
            $firstday = date('Y-m-d', strtotime('first day of january this year'));
            $ldate = date('Y-m-d');
            $yeararr = ['2018', '2019', '2020', '2021', '2022'];
            $months = ['January', 'February', 'March', 'April', 'May', 'June'
            , 'July', 'August', 'September', 'October', 'November', 'December'];

            $tbl = '';
            $tbl .= '';
            $tbl = "<table class='table' id='tableID'>";
            $tbl .= "<thead>";
            $tbl .= "<tr>";
            $tbl .= "<th>Employee Id</th>";
            $tbl .= "<th>Leave Type</th>";
            $tbl .= "<th>Date From</th>";
            $tbl .= "<th>Date To</th>";
            $tbl .= "<th>No Of Days</th>";
            $tbl .= "<th>Shift Time</th>";
            $tbl .= "<th>Leave Reason</th>";
            $tbl .= "<th>Leave Status</th>";
            $tbl .= "<th>Leave Remarks</th>";
            $tbl .= "<th>Date Posted</th>";
            $tbl .= "<th>Action</th>";
            $tbl .= "</tr>";
            $tbl .= "</thead>";
            $tbl .= "<tbody>";
            foreach ($leavetype_apps as $leavetype_apps) {
                $tbl .= "<tr>";
                $tbl .= "<td>" . $leavetype_apps->emp_id . "</td>";
                $tbl .= "<td>" . $leavetype_apps->leavename . "</td>";
                $tbl .= "<td>" . $leavetype_apps->date_from . "</td>";
                $tbl .= "<td>" . $leavetype_apps->date_to . "</td>";
                $tbl .= "<td>" . $leavetype_apps->no_of_days . "</td>";
                $tbl .= "<td>" . $leavetype_apps->shift_time . "</td>";
                $tbl .= "<td>" . $leavetype_apps->reason . "</td>";
                $tbl .= "<td>" . $leavetype_apps->leave_status . "</td>";
                $tbl .= "<td>" . $leavetype_apps->remks . "</td>";
                $curdate = date('Y-m-d', strtotime($leavetype_apps->date_posted));
                $curmonth = date('F', strtotime($curdate));
                $curyear = date('Y', strtotime($curdate));
                $tbl .= "<td>" . $leavetype_apps->date_posted
                ."<span style='display:none'>".''.$curmonth.''.$curyear."</span>". "</td>";
                if(($leavetype_apps->leave_status!="No Action")){
                    $tbl .= "<td></td>";
                }
                else{
                    $tbl .= "<td><div class='row'><div class='col-sm-6'><button data-target='#modal-leave' data-id='".$leavetype_apps->id."' class='edtleav'>Edit</button></div>";
                    // <div class='col-sm-6'><button data-id='".$leavetype_apps->id."' class='cancleav'>Cancel</button></div>
                    // </div></td>";
                }
                $tbl .= "</tr>";
            }
            $tbl .= "</tbody>";
            $tbl .= "</table>";

        return view('applied-leave', [
                'userId' => $userId
            , 'mydets' => $mydets
            , 'tbl' => $tbl
            , 'leavetype_apps_cnt' => $leavetype_apps_cnt
        ]);
    }
    public function GetAppliedLeave(Request $request)
    {
        $ReqLv = LeaveApplicatnList::where('id', $request->req)->first();
        return response()->json(['ReqLv'=>$ReqLv]);
    }
    public function UpdateAppliedLeave(Request $request)
    {
        LeaveApplicatnList::where('id', $request->leavid)->update(array('shift_time'=>$request->shift_upd, 'no_of_days'=>$request->nod
        , 'date_to'=>$request->till_upd, 'date_from'=>$request->from_upd, 'reason'=>$request->reason_upd));
        return response()->json(['success'=>"Data updated successfully"]);
    }
    public function CancAppliedLeave(Request $request)
    {}
    public function ApplyLeave(Request $request)
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
        $firstday = date('Y-m-d', strtotime('first day of january this year'));
        $ldate = date('Y-m-d');
        $userId = Auth::id();
        $mydets = User::where('id', $userId)->first();
        $leaveavl = LeaveTypeMgmt::join('leave_type_masters', 'leave_type_masters.id', '=', 'leave_type_mgmts.leave_type_id')
        ->where('office_id', $mydets->office_id)
        ->get(['leave_type_mgmts.id', 'leave_type_masters.leavename', 'leave_type_mgmts.office_id', 'leave_type_mgmts.leave_entitle']);
        if (count($leaveavl) > 0) {
            $tbl = "<table class='table'>";
            $tbl .= "<tr>";
            $tbl .= "<th>Leave Type</th>";
            $tbl .= "<th>Leave Entitle</th>";
            $tbl .= "<th>Leave taken</th>";
            $tbl .= "<th>Leave Available</th>";
            $tbl .= "</tr>";
            for ($i = 0; $i < count($leaveavl); $i++) {
                $leaveleft = 0;
                $leavetkn = 0;
                $tbl .= "<tr>";
                $leavelist = LeaveApplicatnList::
                whereBetween('date_posted', [$firstday, $ldate])->
                    where('emp_name_id', $userId)->where('leave_stats_id', '1')
                    ->where('leave_type_id', $leaveavl[$i]->id)
                    ->get(['no_of_days']);

                if (count($leavelist) == 0) {
                    $leavetkn = 0;
                    $leaveleft = $leaveavl[$i]->leave_entitle;
                } else {
                    $leavetkn = LeaveApplicatnList::
                    whereBetween('date_posted', [$firstday, $ldate])->
                        where('emp_name_id', $userId)->where('leave_stats_id', '1')
                        ->where('leave_type_id', $leaveavl[$i]->id)
                        ->sum('no_of_days');
                    //$leavetkn = $leavelist[0]->no_of_days;
                    $leaveleft = $leaveavl[$i]->leave_entitle - $leavetkn;
                }
                $tbl .= "<td>" . $leaveavl[$i]->leavename . "</td>";
                $tbl .= "<td>" . $leaveavl[$i]->leave_entitle . "</td>";
                $tbl .= "<td>" . $leavetkn . "</td>";
                $tbl .= "<td>" . $leaveleft . "</td>";
                $tbl .= "</tr>";
            }
            $tbl .= "</table>";
        } else {
            $tbl = "<table class='table'>";
            $tbl .= "<tr>";
            $tbl .= "<th>Leave Type</th>";
            $tbl .= "<th>Leave Entitle</th>";
            $tbl .= "<th>Leave taken</th>";
            $tbl .= "<th>Leave Available</th>";
            $tbl .= "</tr>";
            $tbl .= "<tr>";
            $tbl .= "<td colspan = 3>No data available</td>";
            $tbl .= "<td></td>";
            $tbl .= "<td></td>";
            $tbl .= "<td></td>";
            $tbl .= "</tr>";
            $tbl = "</table>";
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
        return view('apply-leave', [
            'userId' => $userId, 'mydets' => $mydets, 'leaveavl' => $leaveavl, 'leavestatus' => $leavestatus
            , 'office' => $office, 'department' => $departmentname
            , 'cur_date' => $ldate, 'tabl' => $tbl, 'departmentid' => $departmentid
        ]);
    }
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
        $userId = Auth::id();
        $datetime1 = $request->dtfrm;
        $datetime2 = $request->dtto;
        $datetime1 = new DateTime($datetime1);
        $datetime2 = new DateTime($datetime2);
        $days = $datetime1->diff($datetime2)->days;
        $leaveapply = new LeaveApplicatnList();
        $leaveapply->emp_id = $request->empid;
        $leaveapply->emp_name_id = $userId;
        $leaveapply->emp_sex = $request->gend;
        $leaveapply->emp_depm_id = $request->deptname;
        $leaveapply->emp_desg_id =  $userId;
        $leaveapply->date_from = $request->dtfrm;
        $leaveapply->date_to = $request->dtto;
        $leaveapply->no_of_days = $days;
        $leaveapply->shift_time = $request->shftime;
        $leaveapply->leave_type_id = $request->lvtype;
        $leaveapply->reason = $request->lvreason;
        $leaveapply->leave_stats_id = 4;
        $leaveapply->date_posted = $request->curdate;
        //dd($leaveapply);
        $leaveapply->save();
        return redirect('/ApplyLeave')->with('success', 'Leave Applied Successfully');
    }
    public function ChgLeaveStat(Request $request)
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
        $reqid = $request->data;
        $lvstatus = LeaveStatus::get(['id', 'leave_status']);
        $reqdatas = LeaveApplicatnList::where('id', $reqid)->get(['leave_stats_id', 'remks', 'emp_name_id']);
        return response()->json(['lvstatus'=>$lvstatus, 'reqdatas'=>$reqdatas]);
    }
    public function UpdateLeaveData(Request $request)
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
        $empid = $request->empnameid;
        $lvstat = $request->lvstat;
        $remk = $request->remk;
        $leavid = $request->leavid;
        LeaveApplicatnList::where('emp_name_id',$empid)->where('id',$leavid)
        ->update(array('leave_stats_id'=>$lvstat, 'remks'=>$remk));
        return response()->json(['success'=>'Leave updated successfully']);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeaveApplicatnList  $leaveApplicatnList
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveApplicatnList $leaveApplicatnList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeaveApplicatnList  $leaveApplicatnList
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveApplicatnList $leaveApplicatnList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeaveApplicatnList  $leaveApplicatnList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeaveApplicatnList $leaveApplicatnList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeaveApplicatnList  $leaveApplicatnList
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeaveApplicatnList $leaveApplicatnList)
    {

    }
    public function AccLeaveStat(Request $request)
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
        $leavetype_apps = LeaveApplicatnList::join('users', 'users.id', '=', 'leave_applicatn_lists.emp_name_id')
        ->join('leave_type_masters', 'leave_type_masters.id', '=', 'leave_applicatn_lists.leave_type_id')
        ->join('leave_statuses', 'leave_statuses.id', '=', 'leave_applicatn_lists.leave_stats_id')
        ->where('leave_applicatn_lists.leave_stats_id', 1)
        ->get([
            'leave_applicatn_lists.id', 'leave_applicatn_lists.id', 'users.name', 'users.desg'
            , 'leave_applicatn_lists.date_from', 'leave_applicatn_lists.date_to', 'users.emp_id'
            , 'leave_applicatn_lists.no_of_days', 'leave_applicatn_lists.shift_time'
            , 'leave_type_masters.leavename', 'leave_applicatn_lists.reason', 'leave_statuses.leave_status'
            , 'leave_applicatn_lists.remks', 'leave_applicatn_lists.date_posted'
        ]);

        $leavetype_apps_cnt = count($leavetype_apps);
        return view('approv-auth-leave-applist', [
                'userId' => $userId
            , 'mydets' => $mydets
            , 'leavetype_apps' => $leavetype_apps
            , 'leavetype_apps_cnt' => $leavetype_apps_cnt
        ]);
    }
    public function RejLeaveStat(Request $request)
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
        $curdate = date('Y-m-d');
        $userId = Auth::id();
        $mydets = User::where('id', $userId)->first();
        $leavetype_apps = LeaveApplicatnList::join('users', 'users.id', '=', 'leave_applicatn_lists.emp_name_id')
            ->join('leave_type_masters', 'leave_type_masters.id', '=', 'leave_applicatn_lists.leave_type_id')
            ->join('leave_statuses', 'leave_statuses.id', '=', 'leave_applicatn_lists.leave_stats_id')
            ->where('leave_applicatn_lists.leave_stats_id', 2)
            ->get([
                'leave_applicatn_lists.id', 'leave_applicatn_lists.id', 'users.name', 'users.desg'
                , 'leave_applicatn_lists.date_from', 'leave_applicatn_lists.date_to'
                , 'leave_applicatn_lists.no_of_days', 'leave_applicatn_lists.shift_time'
                , 'leave_type_masters.leavename', 'leave_applicatn_lists.reason', 'leave_statuses.leave_status'
                , 'leave_applicatn_lists.remks', 'leave_applicatn_lists.date_posted'
            ]);

        $leavetype_apps_cnt = count($leavetype_apps);
        return view('rejected-leave-list', [
                'userId' => $userId
            , 'mydets' => $mydets
            , 'curdate' => $curdate
            , 'leavetype_apps' => $leavetype_apps
            , 'leavetype_apps_cnt' => $leavetype_apps_cnt
        ]);
    }
    public function CancLeaveStat(Request $request)
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
        $curdate = date('Y-m-d');
        $mydets = User::where('id', $userId)->first();
        $leavetype_apps = LeaveApplicatnList::join('users', 'users.id', '=', 'leave_applicatn_lists.emp_name_id')
            ->join('leave_type_masters', 'leave_type_masters.id', '=', 'leave_applicatn_lists.leave_type_id')
            ->where('leave_applicatn_lists.leave_stats_id', 3)
            ->get([
                'leave_applicatn_lists.id', 'leave_applicatn_lists.id', 'users.name', 'users.desg'
                , 'leave_applicatn_lists.date_from', 'leave_applicatn_lists.date_to'
                , 'leave_applicatn_lists.no_of_days', 'leave_applicatn_lists.shift_time'
                , 'leave_type_masters.leavename', 'leave_applicatn_lists.reason'
                , 'leave_applicatn_lists.remks', 'leave_applicatn_lists.date_posted'
            ]);

        $leavetype_apps_cnt = count($leavetype_apps);
        return view('approv-auth-leave-applist', [
                'userId' => $userId
            , 'curdate' => $curdate
            , 'mydets' => $mydets
            , 'leavetype_apps' => $leavetype_apps
            , 'leavetype_apps_cnt' => $leavetype_apps_cnt
        ]);
    }
}
