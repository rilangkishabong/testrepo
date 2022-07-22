<?php

namespace App\Http\Controllers;
use App\Models\DepartmentMgmt;
use App\Models\DeputeStaff;
use App\Models\FileAttch;
use App\Models\ShiftTime;
use App\Models\TourList;
use App\Models\TourProgramme;
use App\Models\TourStatus;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\TourReportAttch;
use Illuminate\Http\Request;

class TourReportAttchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //

    public function CheckIfTourIsFiled(Request $request)
    {
        $req = $request->reqid;
        $avl = TourReportAttch::where('dep_id', $req)->count();
        return response()->json(['avl'=>$avl]);
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
        $allusers = User::get(['id', 'name']);
        $mydets = User::where('id', $userId)->first();
        $department_name = DepartmentMgmt::where('id', $mydets->dept_id)->get(['dept_name']);
        $stime = ShiftTime::get(['id', 'timename']);
        $tours = TourProgramme::get(['id', 'tour_prog']);
        $curdate = date('Y-m-d');
        $depute_staf_upd = DeputeStaff::
        join('users', 'users.id', '=', 'depute_staff.dep_emp_name_id')
        ->join('tour_statuses', 'tour_statuses.id', '=', 'depute_staff.dep_status')
        ->join('department_mgmts', 'department_mgmts.id', '=', 'depute_staff.dep_emp_depm_id')
        ->join('tour_programmes', 'tour_programmes.id', '=', 'depute_staff.dep_tour_id')
        ->join('tada_statuses', 'tada_statuses.id', '=', 'depute_staff.tada_status_id')
        ->whereNotNull('users.account_type')
        ->where('depute_staff.dep_emp_name_id', $userId)
        ->where('depute_staff.dep_status', 1)
        ->get(
            ['users.name', 'users.desg', 'users.emp_id', 'department_mgmts.dept_name'
            , 'department_mgmts.id as did', 'depute_staff.dep_desc', 'depute_staff.dep_emp_name_id'
            , 'depute_staff.dep_reason', 'depute_staff.dep_locatn', 'depute_staff.dep_date_from'
            , 'depute_staff.dep_date_to', 'depute_staff.shift_time', 'depute_staff.dep_no_of_days'
            , 'depute_staff.date_posted', 'tour_programmes.tour_prog', 'depute_staff.id'
            , 'depute_staff.dep_tour_id', 'users.id as uid', 'tour_statuses.id as tourid'
            , 'depute_staff.dep_no_of_days', 'tada_statuses.tada_stat']
        );

        $depute_staf_cnt = count($depute_staf_upd);
        return view('my-tour-report',[
            'userId' => $userId
            , 'mydets' => $mydets
            , 'allusers' => $allusers
            , 'depute_staf_cnt' => $depute_staf_cnt
            , 'tours' => $tours
            , 'stime' => $stime
            , 'curdate' => $curdate
            , 'department_name' => $department_name
            , 'depute_stafs' => $depute_staf_upd
        ]);
    }//
    public function GetTourAttchs(Request $request)
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
        $id = $request->rep_id;
        $sms1 = TourReportAttch::where('dep_id', $id)->sum('tr_travel_amt')+
        TourReportAttch::where('dep_id', $id)->sum('tr_lodg_amt')+
        TourReportAttch::where('dep_id', $id)->sum('tr_other_amt')+
        TourReportAttch::where('dep_id', $id)->sum('tr_da_amt');

        //->sum('(tr_travel_amt + tr_lodg_amt + tr_other_amt + tr_da_amt)');

        $reqdetss = TourReportAttch::where('dep_id', $id)
        ->get([
        'tr_travel_fare', 'tr_lodg_fare'
        , 'tr_tour_report', 'tr_other_exp'
        , 'tr_travel_amt', 'tr_lodg_amt'
        , 'tr_other_amt', 'tr_da_amt'
        ]);
        return response()->json(['reqdetss'=>$reqdetss, 'sms'=>$sms1]);
    }
    public function GetDeputDates(Request $request)
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
        $id = $request->reqid;
        $reqdates = DeputeStaff::where('id', $id)->get([
            'dep_date_from', 'dep_date_to', 'dep_no_of_days'
        ]);
        return response()->json(['reqdates'=>$reqdates]);
    }
    public function EditMyTourReport(Request $request)
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
        //$depdets = DeputeStaff::where('id', $request->reqid)->get(['attch_id']);
        //$depdets = TourReportAttch::where('dep_id', $request->reqid)->get(['attch_id']);
        $reqdets = TourReportAttch::where('tour_report_attches.dep_id', $request->reqid)->first();
        return response()->json(['reqdets'=>$reqdets]);
    }
    public function UpdMyTourReportDets(Request $request)
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
        $dep_id = $request->dep_id_upd;
        $trid = Auth::id();
        $reqid = DeputeStaff::where('dep_status', 1)
        ->where('dep_emp_name_id', $trid)
        ->where('id', $dep_id)
        ->first();
        $f_trfare = $request->file('trfare');
        $f_lodgfare = $request->file('lodgfare');
        $f_tourrept = $request->file('tourrept');
        $f_other_exp = $request->file('other_exp');
        if($f_trfare==null||$f_lodgfare==null||$f_tourrept==null||$f_other_exp==null)
        {
            $tr_departure_dt = $request->depdate_upd;
            $tr_departure_tm = $request->deptime_upd;
            $tr_arrival_dt = $request->arridate_upd;
            $tr_arrival_tm = $request->arritime_upd;
            $tr_pt_of_origin = $request->originpt_upd;
            $tr_pt_of_destination = $request->destinatnpt_upd;
            $tr_no_of_days = $request->nodays_upd;
            $tr_travel_mode = $request->travelmode_upd;
            $tr_mileage = $request->mileage_upd;
            $tr_distance = $request->dist_upd;
            TourReportAttch::where('id', $reqid->attch_id)
            ->update(array('tr_departure_dt'=>$tr_departure_dt, 'tr_departure_tm'=>$tr_departure_tm
            , 'tr_arrival_dt'=>$tr_arrival_dt, 'tr_arrival_dt'=>$tr_arrival_dt
            , 'tr_arrival_tm'=>$tr_arrival_tm, 'tr_pt_of_origin'=>$tr_pt_of_origin
            , 'tr_pt_of_destination'=>$tr_pt_of_destination, 'tr_no_of_days'=>$tr_no_of_days
            , 'tr_travel_mode'=>$tr_travel_mode, 'tr_mileage'=>$tr_mileage
            , 'tr_distance'=>$tr_distance));
        }
        else
        {
            $tr_departure_dt = $request->depdate_upd;
            $tr_departure_tm = $request->deptime_upd;
            $tr_arrival_dt = $request->arridate_upd;
            $tr_arrival_tm = $request->arritime_upd;
            $tr_pt_of_origin = $request->originpt_upd;
            $tr_pt_of_destination = $request->destinatnpt_upd;
            $tr_no_of_days = $request->nodays_upd;
            $tr_travel_mode = $request->travelmode_upd;
            $tr_mileage = $request->mileage_upd;
            $tr_distance = $request->dist_upd;

            $f_trfare = $request->file('trfare_upd');
            $fileName1 = uniqid().$f_trfare->getClientOriginalName();
            $path2 = $path = public_path().'/myfiles/';
            $f_trfare->move($path, $fileName1);
            $path2 = str_replace('/',"'\'",$path2);
            $path2 = str_replace("'","",$path2);

            $f_lodgfare = $request->file('lodgfare_upd');
            $fileName2 = uniqid().$f_trfare->getClientOriginalName();
            $path2 = $path = public_path().'/myfiles/';
            $path2 = str_replace('/',"'\'",$path2);
            $path2 = str_replace("'","",$path2);
            $f_lodgfare->move($path, $fileName2);

            $f_tourrept = $request->file('tourrept_upd');
            $fileName3 = uniqid().$f_trfare->getClientOriginalName();
            $path2 = $path = public_path().'/myfiles/';
            $path2 = str_replace('/',"'\'",$path2);
            $path2 = str_replace("'","",$path2);
            $f_tourrept->move($path, $fileName3);

            $f_other_exp = $request->file('other_exp_upd');
            $fileName4 = uniqid().$f_trfare->getClientOriginalName();
            $path2 = $path = public_path().'/myfiles/';
            $path2 = str_replace('/',"'\'",$path2);
            $path2 = str_replace("'","",$path2);
            $f_other_exp->move($path, $fileName4);

            TourReportAttch::where('id', $reqid->attch_id)
            ->update(array('tr_departure_dt'=>$tr_departure_dt, 'tr_departure_tm'=>$tr_departure_tm
            , 'tr_arrival_dt'=>$tr_arrival_dt, 'tr_arrival_dt'=>$tr_arrival_dt
            , 'tr_arrival_tm'=>$tr_arrival_tm, 'tr_pt_of_origin'=>$tr_pt_of_origin
            , 'tr_pt_of_destination'=>$tr_pt_of_destination, 'tr_no_of_days'=>$tr_no_of_days
            , 'tr_travel_mode'=>$tr_travel_mode, 'tr_mileage'=>$tr_mileage
            , 'tr_travel_fare'=>$fileName1, 'tr_tour_report'=>$fileName3
            , 'tr_lodg_fare'=>$fileName2, 'tr_other_exp'=>$fileName4));
        }
        return response()->json(['success'=>"Data Updated Successfully"]);
    }
    public function MyTourReportDets(Request $request)
    {

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
        $curdate = date('Y-m-d');
        $fileName1 = "";
        $fileName2 = "";
        $fileName3 = "";
        $fileName4 = "";
        $t_rep = new TourReportAttch();
        $t_rep->dep_id = $request->dep_id;
        $t_rep->tr_departure_dt = $request->depdate;
        $t_rep->tr_departure_tm = $request->deptime;
        $t_rep->tr_arrival_dt = $request->arridate;
        $t_rep->tr_arrival_tm = $request->arritime;
        $t_rep->jr_type = $request->journeytype;
        $t_rep->tr_pt_of_origin1 = $request->originpt1;
        $t_rep->tr_pt_of_destination1 = $request->destinatnpt1;
        $t_rep->tr_pt_of_origin2 = $request->originpt2;
        $t_rep->tr_pt_of_destination2 = $request->destinatnpt2;
        $t_rep->tr_no_of_days = $request->nodays;
        $t_rep->tr_travel_mode = $request->travelmode;
        $t_rep->tr_mileage = $request->mileage;
        $t_rep->tr_distance = $request->dist;
        $t_rep->tadastat_id = 4;
        $t_rep->ta_da_date = $curdate;
        $t_rep->tr_adv_allw = $request->adv_exp;
        $t_rep->tr_lodg_amt = $request->lodgfare_exp;
        $t_rep->tr_travel_amt = $request->trfare_exp;
        $t_rep->tr_da_amt = $request->dallw_exp;
        $t_rep->tr_other_amt = $request->other_exp_exp;
        $t_rep->save();
        $trid = Auth::id();
        DeputeStaff::where('dep_status', 1)
        ->where('dep_emp_name_id', $trid)
        ->where('id', $request->dep_id)
        ->update(array('attch_id'=>$t_rep->id));
        $flg = 1;
        if($request->hasFile('trfare'))
        {
            foreach ($request->file('trfare') as $f_trfare)
            {
                $fileName1 = $f_trfare->getClientOriginalName();
                $path1 = $path = public_path().'/myfiles/';
                $path1 = str_replace('/',"'\'",$path1);
                $path1 = str_replace("'","",$path1);
                $f_trfare->move($path, $fileName1);

                $fta1 = new FileAttch();
                $fta1->tr_att_id = $t_rep->id;
                $fta1->doc_id = 1;
                $fta1->doc_name = $fileName1;

                $flg2 = $fta1->save();

                if($flg2==0){
                    $flg = 0;
                    break;
                }
            }
            if($flg==0)
            {
                dd("ERROR");
            }
        }

        foreach ($request->file('lodgfare') as $f_lodgfare)
        {
            $fileName2 = uniqid().$f_lodgfare->getClientOriginalName();
            $path2 = $path = public_path().'/myfiles/';
            $path2 = str_replace('/',"'\'",$path2);
            $path2 = str_replace("'","",$path2);
            $f_lodgfare->move($path, $fileName2);
            $t_rep->tr_lodg_fare = $fileName2;

            $fta2 = new FileAttch();
            $fta2->tr_att_id = $t_rep->id;
            $fta2->doc_id = 2;
            $fta2->doc_name = $fileName2;
            $fta2->save();
        }

        foreach ($request->file('tourrept') as $f_tourrept)
        {
            $fileName3 = uniqid().$f_tourrept->getClientOriginalName();
            $path3 = $path = public_path().'/myfiles/';
            $path3 = str_replace('/',"'\'",$path3);
            $path3 = str_replace("'","",$path3);
            $f_tourrept->move($path, $fileName3);
            $t_rep->tr_tour_report = $fileName3;

            $fta3 = new FileAttch();
            $fta3->tr_att_id = $t_rep->id;
            $fta3->doc_id = 3;
            $fta3->doc_name = $fileName3;
            $fta3->save();
        }

        foreach ($request->file('other_exp') as $f_other_exp)
        {
            $fileName4 = uniqid().$f_other_exp->getClientOriginalName();
            $path4 = $path = public_path().'/myfiles/';
            $path4 = str_replace('/',"'\'",$path4);
            $path4 = str_replace("'","",$path4);
            $f_other_exp->move($path, $fileName4);

            $fta4 = new FileAttch();
            $fta4->tr_att_id = $t_rep->id;
            $fta4->doc_id = 4;
            $fta4->doc_name = $fileName4;
            $fta4->save();
        }

        return redirect()->route('tour-report.index')->with('success', 'Saved Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TourReportAttch  $tourReportAttch
     * @return \Illuminate\Http\Response
     */
    public function show(TourReportAttch $tourReportAttch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TourReportAttch  $tourReportAttch
     * @return \Illuminate\Http\Response
     */
    public function edit(TourReportAttch $tourReportAttch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TourReportAttch  $tourReportAttch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TourReportAttch $tourReportAttch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TourReportAttch  $tourReportAttch
     * @return \Illuminate\Http\Response
     */
    public function destroy(TourReportAttch $tourReportAttch)
    {
        //
    }
}
