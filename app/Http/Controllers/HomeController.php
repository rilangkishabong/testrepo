<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\DailyActivity;
use App\Models\DeputeStaff;
use App\Models\LeaveApplicatnList;
use App\Models\LeaveTypeMaster;
use App\Models\LeaveTypeMgmt;
use App\Models\OfficeMgmt;
use App\Models\TourProgramme;
use App\Models\TourReportAttch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function UserTypes()
    {

    }
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
        $mydets = User::where('users.id', $userId)->first();
        if (auth()->user()->account_type=="admin") {
            $tourscnt = TourProgramme::count();
            $leavecnt = LeaveTypeMaster::count();
            $allwncnt = Allowance::count();
            $usercnt = User::count();
            return view('home',['mydets'=>$mydets
            , 'tourscnt'=>$tourscnt
            , 'leavecnt'=>$leavecnt
            , 'allwncnt'=>$allwncnt
            , 'usercnt'=>$usercnt]);
        } else if(auth()->user()->account_type=="approvauth") {
            $staffdeputcnt = DeputeStaff::where('depute_staff.is_for', "tour")->count();
            $apprvtourscnt = DeputeStaff::where('depute_staff.is_for', "tour")
            ->where('depute_staff.dep_status', 1)
            ->count();
            $unapprvtourscnt = DeputeStaff::where('depute_staff.is_for', "tour")
            ->where('depute_staff.dep_status', 4)
            ->count();
            $tottours = $apprvtourscnt + $unapprvtourscnt;

            $unapprleave = LeaveApplicatnList::where('leave_stats_id', 4)->count();//DeputeStaff::where('depute_staff.is_for', "tour")->count();
            $apprleave = LeaveApplicatnList::where('leave_stats_id', 1)->count();
            $totleave = $unapprleave + $apprleave;
            return view('home',['mydets'=>$mydets
            , 'unapprleave'=>$unapprleave
            , 'apprleave'=>$apprleave
            , 'totleave'=>$totleave
            , 'apprvtourscnt'=>$apprvtourscnt
            , 'unapprvtourscnt'=>$unapprvtourscnt
            , 'staffdeputcnt'=>$staffdeputcnt
            , 'tottours'=>$tottours]);
        }else if(auth()->user()->account_type=="account") {
            $apprvtoursrepcnt = TourReportAttch::where('tadastat_id', 1)->count();
            $unapprvtoursrepcnt = TourReportAttch::where('tadastat_id', 4)->count();
            $rejapprvtoursrepcnt = TourReportAttch::where('tadastat_id', 2)->count();
            $tottoursrep = $apprvtoursrepcnt + $unapprvtoursrepcnt + $rejapprvtoursrepcnt;

            $myappliedleave = LeaveApplicatnList::where('emp_name_id', $userId)->count();
            $allwncesavl = Allowance::count();
            $mytourreqs = DeputeStaff::where('dep_emp_name_id', $userId)
            ->where('is_for', "tour")
            ->count();
            $mydeputedut = DeputeStaff::where('dep_emp_name_id', $userId)
            ->where('is_for', "depute")
            ->count();
            return view('home',['mydets'=>$mydets
            , 'myappliedleave'=>$myappliedleave
            , 'allwncesavl'=>$allwncesavl
            , 'mytourreqs'=>$mytourreqs
            , 'mydeputedut'=>$mydeputedut

            , 'apprvtoursrepcnt'=>$apprvtoursrepcnt
            , 'unapprvtoursrepcnt'=>$unapprvtoursrepcnt
            , 'rejapprvtoursrepcnt'=>$rejapprvtoursrepcnt
            , 'tottoursrep'=>$tottoursrep
            ]);
        }else{//for normal user
            $apprvleavescnt = LeaveApplicatnList::where('leave_applicatn_lists.emp_name_id', $userId)
            ->where('leave_stats_id', 1)
            ->count();
            $allwn_cnt = Allowance::count();
            $tour_requests_cnt = DeputeStaff::where('depute_staff.is_for', "tour")
            ->where('depute_staff.dep_emp_name_id', $userId)
            ->count();
            $deput_duties_cnt = DeputeStaff::where('depute_staff.is_for', "tour")
            ->where('depute_staff.dep_emp_name_id', $userId)
            ->count();
            return view('home',['mydets'=>$mydets
            , 'apprvleavescnt'=>$apprvleavescnt
            , 'allwn_cnt'=>$allwn_cnt
            , 'tour_requests_cnt'=>$tour_requests_cnt
            , 'deput_duties_cnt'=>$deput_duties_cnt]);
        }

    }
    public function UpdateUserType(Request $request)
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }
        if(((auth()->user()->account_type == "denied"))||((auth()->user()->account_type == NULL)))
        {
            auth()->logout();

            return redirect()->back()->with('success', 'Your account will be able activated by the administrator.');
        }
        $usr = $request->usridd;
        $acctype = $request->user_acc_upd;
        User::where('id', $usr)->update(array('account_type'=>$acctype));
        return response()->json(['success'=>"Data Updated Successfully"]);
    }
}
