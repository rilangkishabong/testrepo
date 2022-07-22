<?php

namespace App\Http\Controllers;

use App\Models\LeaveStatus;
use App\Models\TourProgramme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourProgrammeController extends Controller
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
        $tourdatas = TourProgramme::get([
        'tour_programmes.id as tid'
        , 'tour_programmes.tour_prog', 'tour_programmes.tour_desc']);

        $leavestat_datas = LeaveStatus::all();
        $leavestat_cnt = count($tourdatas);

        $officers = User::whereNotNull('account_type')->get(['id', 'name']);
        $userId = Auth::id();
        $mydets = User::where('users.id', $userId)->first();
        return view("admin-tour-programmes", ['mydets' => $mydets, 'tourdatas' => $tourdatas
        , 'leavestat_cnt' => $leavestat_cnt, 'userId' => $userId
        , 'officers' => $officers]);
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
        $tour = new TourProgramme();
        $tour->tour_prog = $request->tourprog;
        $tour->tour_desc = $request->tourdesc;
        $tour->save();
        return redirect()->route('tour-management.index')->with('success', 'Data Saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TourProgramme  $tourProgramme
     * @return \Illuminate\Http\Response
     */
    public function show(TourProgramme $tourProgramme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TourProgramme  $tourProgramme
     * @return \Illuminate\Http\Response
     */
    public function edit(TourProgramme $tourProgramme)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TourProgramme  $tourProgramme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TourProgramme $tourProgramme)
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
        $reqd_id = $request->tour_management;

        $tourprog_upd = $request->tourprog_upd;
        $tourdesc_upd = $request->tourdesc_upd;
        $seloff_upd = $request->seloff_upd;


        TourProgramme::where('id', $reqd_id)->update(array('tour_prog' => $tourprog_upd,'tour_desc' => $tourdesc_upd,'assn_to' => $seloff_upd));
        //dd($roomdatas);
        return redirect()->route('tour-management.index')->with('success', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TourProgramme  $tourProgramme
     * @return \Illuminate\Http\Response
     */
    public function destroy(TourProgramme $tourProgramme, Request $request)
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
        $reqd_id = $request->tour_management;

        TourProgramme::where('id', $reqd_id)->where('id', $reqd_id)->delete();
        //dd($roomdatas);
        return redirect()->route('tour-management.index')->with('success', 'Data updated successfully');
    }
}
