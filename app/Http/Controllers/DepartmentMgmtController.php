<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\OfficeMgmt;
use App\Models\User;
use App\Models\DepartmentMgmt;
use Illuminate\Http\Request;

class DepartmentMgmtController extends Controller
{
    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {//('posts', 'posts.user_id', '=', 'users.id')
        if(!Auth::check())
        {
            return redirect()->route('login');
        }
        if(((auth()->user()->account_type == "denied"))||((auth()->user()->account_type == NULL)))
        {
            auth()->logout();
            return redirect()->route('login')->with('success', 'Your account will be able activated by the administrator.');
        }
        $department_datas = OfficeMgmt::join('department_mgmts', 'department_mgmts.office_id','=','office_mgmts.id')->orderBy('department_mgmts.id', 'asc')->get();

        $office_datas = OfficeMgmt::orderBy('id', 'asc')->get();
        $department_cnt = DepartmentMgmt::all();
        $department_cnt=count($department_cnt);
        $userId = Auth::id();
        $mydets = User::where('users.id', $userId)->first();
        $office_id = $mydets->office_id;

        $offdets = OfficeMgmt::where('office_mgmts.id', $office_id)->first();
        //dd($offdets);
        //$mydets = OfficeMgmt::join('users', 'users.office_id', '=', 'office_mgmts.id')->where('users.id', $userId)->first();
        return view("admin-departments-pg", ['mydets'=>$mydets, 'office_datas'=>$office_datas, 'offdets'=>$offdets, 'department_datas'=>$department_datas, 'department_cnt'=>$department_cnt, 'userId'=>$userId]);

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
        $department_data = new DepartmentMgmt();
        $department_data->office_id = $request->officename;
        $department_data->dept_name = $request->deptename;
        $department_data->dept_short_name = $request->deptename_short;
        $department_data->save();
        return redirect()->route('master-department.index')->with('success', 'New Department successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DepartmentMgmt  $departmentMgmt
     * @return \Illuminate\Http\Response
     */
    public function show(DepartmentMgmt $departmentMgmt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DepartmentMgmt  $departmentMgmt
     * @return \Illuminate\Http\Response
     */
    public function edit(DepartmentMgmt $departmentMgmt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DepartmentMgmt  $departmentMgmt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DepartmentMgmt $departmentMgmt)
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
        $reqd_id = $request->master_department;

$office_upd_id = $request->office_upd_id;
$dept_upd_name = $request->dept_upd_name;
$dept_upd_sname = $request->dept_upd_sname;

        DepartmentMgmt::where('id',$reqd_id)->update(array('office_id'=>$office_upd_id, 'dept_name'=>$dept_upd_name, 'dept_short_name'=>$dept_upd_sname));
                //dd($roomdatas);
                return redirect()->route('master-department.index')->with('success', 'Department updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DepartmentMgmt  $departmentMgmt
     * @return \Illuminate\Http\Response
     */
    public function destroy(DepartmentMgmt $departmentMgmt, Request $request)
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
        $reqd_id = $request->master_department;

        $dept_data = DepartmentMgmt::where('id', $reqd_id)->first();

            //$fdat->fetch($request->f_dat)->delete();
        $dept_data->delete();
        return redirect()->route('master-department.index')->with('success', 'Department deleted successfully');
    }
}
