<?php

namespace App\Http\Controllers;

use App\Models\ManageUserInfos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\DepartmentMgmt;
use App\Models\OfficeMgmt;
use App\Models\User;
use App\Models\UserMgmt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManageUserInfosController extends Controller
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
                $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'emp_id' => $data['empid'],
        //     'office_id' => $data['officenamex'],
        //     'dept_id' => $data['depnamex'],
        //     'desg' => $data['desg'],
        //     'sex' => $data['gend'],
        //     'account_type' => $data['acctype'],
        //     'password' => Hash::make($data['password']),
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ManageUserInfos  $manageUserInfos
     * @return \Illuminate\Http\Response
     */
    public function show(ManageUserInfos $manageUserInfos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ManageUserInfos  $manageUserInfos
     * @return \Illuminate\Http\Response
     */
    public function edit(ManageUserInfos $manageUserInfos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ManageUserInfos  $manageUserInfos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ManageUserInfos $manageUserInfos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ManageUserInfos  $manageUserInfos
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageUserInfos $manageUserInfos)
    {
        //
    }
}
