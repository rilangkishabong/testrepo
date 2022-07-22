<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\LeaveStatus;
use App\Models\TourProgramme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllowanceController extends Controller
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
        $allwndatas = Allowance::get([
            'allowances.id as aid'
            , 'allowances.allwn', 'allowances.allwn_desc'
        ]);

        $leavestat_datas = LeaveStatus::all();
        $leavestat_cnt = count($allwndatas);

        $officers = User::whereNotNull('account_type')->get(['id', 'name']);
        $userId = Auth::id();
        $mydets = User::where('users.id', $userId)->first();
        return view("admin-allowance", ['mydets' => $mydets, 'allwndatas' => $allwndatas
        , 'leavestat_cnt' => $leavestat_cnt, 'userId' => $userId
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
        $allwn = new Allowance();
        $allwn->allwn = $request->allwname;
        $allwn->allwn_desc = $request->allwdesc;
        $allwn->appl_to = $request->seloff;
        $allwn->save();
        return redirect()->route('allowance-management.index')->with('success', 'Saved Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function show(Allowance $allowance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function edit(Allowance $allowance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Allowance $allowance)
    {
        $id = $request->allowance_management;
        $allwname_upd = $request->allwname_upd;
        $seloff_upd = $request->seloff_upd;
        $allwdesc_upd = $request->allwdesc_upd;
        Allowance::where('id', $id)->update(array('allwn'=>$allwname_upd
        , 'allwn_desc'=>$allwdesc_upd, 'appl_to'=>$seloff_upd));
        return redirect()->route('allowance-management.index')->with('success', 'Saved Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->allowance_management;
        $allw = Allowance::where('id', $id)->first();
        $allw->delete();
        return redirect()->route('allowance-management.index')->with('success', 'Saved Successfully');
    }
}
