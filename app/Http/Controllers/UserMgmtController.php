<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\DepartmentMgmt;
use App\Models\OfficeMgmt;
use App\Models\User;
use App\Models\UserMgmt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserMgmtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //ChangePwd
        if(!Auth::check())
        {
            return redirect()->route('login');
        }
        if(((auth()->user()->account_type == "denied"))||((auth()->user()->account_type == NULL)))
        {
            auth()->logout();

            return redirect()->back()->with('success', 'Your account will be able activated by the administrator.');
        }
        $userId = Auth::id();
        $mydets = User::where('users.id', $userId)->first();
        $officedets = OfficeMgmt::all();
        $userdets = User::join('office_mgmts', 'office_mgmts.id', '=', 'users.office_id')
        ->join('department_mgmts', 'department_mgmts.id', '=', 'users.dept_id')
        // ->where('account_type', NULL)
        // ->orWhere('account_type', 'admin')
        // ->orWhere('account_type', 'approving_auth')
        // ->orWhere('account_type', 'user')
        // ->orWhere('account_type', 'denied')
        ->get(['users.id', 'users.name', 'users.account_type'
        , 'users.email', 'users.desg'
        , 'office_mgmts.office_name', 'department_mgmts.dept_name'
        ]);
        return view('manage-users', [
            'mydets'=>$mydets
            , 'userdets'=>$userdets
            , 'officedets'=>$officedets
        ]);
    }
    public function ReqUserDatas(Request $request)
    {
        $idx = $request->idx;
        $offices = OfficeMgmt::all();
        $depts = DepartmentMgmt::all();
        $userdatas = User::join('office_mgmts', 'users.office_id', '=', 'office_mgmts.id')
        ->join('department_mgmts', 'users.dept_id', '=', 'department_mgmts.id')
        ->whereNotNull('users.account_type')
        ->where('users.id', $idx)
        ->get(['users.name', 'users.email', 'users.office_id', 'users.emp_id'
        , 'users.dept_id', 'users.desg', 'users.desg', 'office_mgmts.office_name'
        , 'department_mgmts.dept_name', 'users.sex']);
        return response()->json(['offices'=>$offices, 'depts'=>$depts, 'userdatas'=>$userdatas]);
    }
    public function GetOffice(Request $request)
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
        $reqid = $request->reqid;
        $officedatas = OfficeMgmt::all();

        $officeuser = User::where('users.id', $reqid)->get(['office_id', 'sex']);
        $depuser = User::where('users.id', $reqid)->get(['dept_id']);
        $depdatas = DepartmentMgmt::where('office_id', $officeuser[0]->office_id)->get(['id', 'dept_name']);
        return response()->json(['officedatas'=>$officedatas, 'officeuser'=>$officeuser
        , 'depdatas'=>$depdatas, 'depuser'=>$depuser]);
    }
    public function GetDepartment(Request $request)
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
        $officeid = $request->offid;
        $usrid = Auth::id();
        $depuser = User::where('users.id', $usrid)->get(['dept_id']);
        $depdatas = DepartmentMgmt::where('office_id', $officeid)->get(['id', 'dept_name']);
        return response()->json(['depdatas'=>$depdatas, 'depuser'=>$depuser]);
    }
    public function GetUserDatas(Request $request)
    {
        $usr = $request->usr;
        $usrs = User::where('id', $usr)->get(['emp_id', 'desg', 'dept_id']);
        $dept = DepartmentMgmt::where('id', $usrs[0]->dept_id)->get(['id', 'dept_name']);
        return response()->json(['usrs'=>$usrs, 'dept'=>$dept]);
    }
    public function UpdateUserDatax(Request $request)
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

        $reqid = Auth::id();
        $uname = $request->usr_uname;
        $umail = $request->usr_umail;
        $empid = $request->usr_empid;
        $depid = $request->usr_depname;
        $officename = $request->usr_officename;
        $desg = $request->usr_desg;
        $gend = $request->usr_gend;
        User::where('id', $reqid)->update(array('name' => $uname, 'email' => $umail,
        'emp_id' => $empid, 'office_id' => $officename, 'dept_id' => $depid
        , 'desg' => $desg, 'sex' => $gend));
        return response()->json(['success'=>'Status updated successfully!!!']);
    }
    public function UpdateUserData(Request $request)
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
        $fx = $request->f1;
        if($fx==1)
        {
            $reqid = Auth::id();
            $uname = $request->uname;
            $umail = $request->umail;
            $empid = $request->empid;
            $depid = $request->depname;
            $officename = $request->officename;
            $desg = $request->desg;
            $gend = $request->gend;
        }
        else
        {
            $reqid = Auth::id();
            $uname = $request->usr_uname;
            $umail = $request->usr_umail;
            $empid = $request->usr_empid;
            $depid = $request->usr_depname;
            $officename = $request->usr_officename;
            $desg = $request->usr_desg;
            $gend = $request->gend;
        }

        User::where('id', $reqid)->update(array('name' => $uname, 'email' => $umail,
        'emp_id' => $empid, 'office_id' => $officename, 'dept_id' => $depid
        , 'desg' => $desg, 'sex' => $gend));
        return response()->json(['success'=>'Status updated successfully!!!']);
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

            $userdata = new User();
            $userdata->name = $request->name;
            $userdata->email = $request->email;
            $userdata->emp_id = $request->empidx;
            $userdata->office_id = $request->officenamex;
            $userdata->dept_id= $request->depnamex;
            $userdata->sex= $request->gendx;
            $userdata->desg = $request->desgx;
            $userdata->account_type= $request->acctype;
            $userdata->password= Hash::make($request->password);
            $userdata->save();
            return redirect()->route('master-user.index')->with('success', 'New office successfully added');
            //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserMgmt  $userMgmt
     * @return \Illuminate\Http\Response
     */
    public function show(UserMgmt $userMgmt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserMgmt  $userMgmt
     * @return \Illuminate\Http\Response
     */
    public function edit(UserMgmt $userMgmt)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserMgmt  $userMgmt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserMgmt $userMgmt)
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
        $reqd_id = $request->master_user;
        $officedatas = User::where('id',$reqd_id)->update(array('name'=>$request->empname,'email'=>$request->empemail,'emp_id'=>$request->empid,'office_id'=>$request->empoffice,'dept_id'=>$request->empdept,'desg'=>$request->empdesg, 'sex'=>$request->empsex));
        return redirect()->back()->with('success', 'User data updated successfully');
    }
    public function myupdate(Request $request)
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
        //$mydets = OfficeMgmt::leftJoin('users', 'users.office_id', '=', 'office_mgmts.id')->where('users.id', $userId)->first();
        $cnt = OfficeMgmt::join('department_mgmts', 'department_mgmts.office_id', '=', 'office_mgmts.id')->get();
        $cnt = count($cnt);
        if($cnt==0)
        {
            $vals = null;
            return response()->json($vals);
        }
        else
        {
            $reqdId = $request->id;
            $vals = DepartmentMgmt::where('office_id', $reqdId)->get();
            return response()->json($vals);
        }

        //return response()->json($arrvals1, $arrvals2);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserMgmt  $userMgmt
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserMgmt $userMgmt)
    {
        //
    }
}
