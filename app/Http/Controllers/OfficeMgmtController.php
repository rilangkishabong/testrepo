<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\OfficeMgmt;
use App\Models\User;
use App\Models\UserMgmt;
use Illuminate\Http\Request;

class OfficeMgmtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
        $office_datas = OfficeMgmt::orderBy('id', 'asc')->get();
        $office_cnt = OfficeMgmt::all();
        $office_cnt=count($office_cnt);
        $userId = Auth::id();
        $mydets = User::where('users.id', $userId)->first();
        $office_id = $mydets->office_id;

        $offdets = OfficeMgmt::where('office_mgmts.id', $office_id)->first();
        //
        return view("admin-office-pg", ['mydets'=>$mydets, 'office_datas'=>$office_datas, 'offdets'=>$offdets, 'office_cnt'=>$office_cnt, 'userId'=>$userId]);
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
        //
        $officedata = $request->officename;
        $officenames = new OfficeMgmt();
        $officenames->office_name = $officedata;
        $officenames->save();
        $userId = Auth::id();
        $officenames->id;
        //UserMgmt::where('id',$userId)->update(array('user_id'=>$officenames->id));
        return redirect()->route('master-office.index')->with('success', 'New office successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OfficeMgmt  $officeMgmt
     * @return \Illuminate\Http\Response
     */
    public function show(OfficeMgmt $officeMgmt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfficeMgmt  $officeMgmt
     * @return \Illuminate\Http\Response
     */
    public function edit(OfficeMgmt $officeMgmt, Request $request)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OfficeMgmt  $officeMgmt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfficeMgmt $officeMgmt)
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
        $reqd_id = $request->master_office;

$data = $request->office_upd_name;
        $officedatas = OfficeMgmt::where('id',$reqd_id)->update(array('office_name'=>$data));
                //dd($roomdatas);
                return redirect()->route('master-office.index')->with('success', 'Office updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfficeMgmt  $officeMgmt
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfficeMgmt $officeMgmt, Request $request)
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

        $reqd_id = $request->master_office;

        $office_data = OfficeMgmt::where('id', $reqd_id)->first();

            //$fdat->fetch($request->f_dat)->delete();
        $office_data->delete();
        return redirect()->route('master-office.index')->with('success', 'Office deleted successfully');
    }
}
