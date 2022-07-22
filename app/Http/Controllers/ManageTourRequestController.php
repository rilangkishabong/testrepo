<?php

namespace App\Http\Controllers;

use App\Models\DepartmentMgmt;
use App\Models\DeputeStaff;
use App\Models\FileAttch;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ManageTourRequest;
use App\Models\TadaStatus;
use App\Models\TourProgramme;
use App\Models\TourReportAttch;
use App\Models\TourStatus;
use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF;
use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Mail as FacadesMail;
class ManageTourRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendEmail(Request $request)
    {
        $data = array(
            'name'      =>  $request->input('name'),
            'phone'   =>   $request->input('phone'),
            'email' => $request->input('email'),
            'message' => $request->input('message')
        );
      FacadesMail::to('pynmaw@gmail.com')->send(new NotifyMail($data));

      if (FacadesMail::failures()) {
           //return response()->Fail('Sorry! Please try again latter');
           dd("Failed");
      }else{
           //return response()->success('Great! Successfully send in your mail');
           dd("Sent Successfully");
         }
    }

    public function GetAttchs2(Request $request)
    {
        $trid = $request->tr_id;
        $did = $request->did;
        $amts = TourReportAttch::where('dep_id', $trid)
        ->get(['tr_adv_allw','tr_travel_amt', 'tr_lodg_amt'
        , 'tr_other_amt', 'tr_da_amt', 'id']);

        $reqs = FileAttch::where('tr_att_id', $amts[0]->id)
        ->where('doc_id', $did)
        ->get(['doc_id', 'doc_name']);

        return response()->json(['reqs' => $reqs, 'amts' => $amts]);
    }
    //
    public function GetAdv(Request $request)
    {
        $trid = $request->rep_id;

        $resl = TourReportAttch::where('id', $trid)
        ->get(['tr_adv_allw','tr_travel_amt', 'tr_lodg_amt'
        , 'tr_other_amt', 'tr_da_amt']);
        return response()->json(['resl' => $resl]);
    }
    public function GetAttchs(Request $request)
    {
        $trid = $request->tr_id;
        $did = $request->did;
        $amts = TourReportAttch::where('id', $trid)
        ->get(['tr_adv_allw','tr_travel_amt', 'tr_lodg_amt'
        , 'tr_other_amt', 'tr_da_amt']);

        $reqs = FileAttch::where('tr_att_id', $trid)
        ->where('doc_id', $did)
        ->get(['doc_id', 'doc_name']);

        return response()->json(['reqs' => $reqs, 'amts' => $amts]);
    }
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (((auth()->user()->account_type == "denied")) || ((auth()->user()->account_type == NULL))) {
            auth()->logout();
            return redirect()->route('login')->with('success', 'Your account will be able activated by the administrator.');
        }
        $userId = Auth::id();
        $mydets = User::where('id', $userId)->first();
        $newdat = DeputeStaff::whereNotNull('users.account_type')
            ->join('users', 'depute_staff.dep_emp_name_id', '=', 'users.id')
            ->join('tour_statuses', 'depute_staff.dep_status', '=', 'tour_statuses.id')
            ->join('department_mgmts', 'depute_staff.dep_emp_depm_id', '=', 'department_mgmts.id')
            ->join('tour_programmes', 'depute_staff.dep_tour_id', '=', 'tour_programmes.id')
            ->join('tour_report_attches', 'depute_staff.attch_id', '=', 'tour_report_attches.id')
            ->join('tada_statuses', 'tada_statuses.id', '=', 'tour_report_attches.tadastat_id')
            //->where('depute_staff.dep_status', 1)
            ->get([
                'users.name', 'users.desg', 'department_mgmts.dept_name'
                , 'depute_staff.id', 'tada_statuses.tada_stat', 'tour_programmes.tour_prog'
                , 'depute_staff.dep_reason', 'depute_staff.dep_date_from', 'depute_staff.dep_date_to'
                , 'depute_staff.dep_no_of_days', 'depute_staff.dep_locatn', 'tour_report_attches.jr_type'
                , 'tour_report_attches.tr_departure_dt', 'tour_report_attches.tr_arrival_dt'
                , 'tour_report_attches.tr_pt_of_origin1', 'tour_report_attches.ta_da_date'
                , 'tour_report_attches.tr_pt_of_destination1', 'tour_report_attches.id as tid'
                , 'tour_report_attches.tr_pt_of_origin2', 'tour_report_attches.tr_pt_of_destination2'
                , 'tour_report_attches.jr_type'
            ]);
        $countnewdat = count($newdat);
        $users = User::get(['name', 'id']);
        $tourstats = TourStatus::all();
        $depts = DepartmentMgmt::all();
        $tourprogs = TourProgramme::all();
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
        ];
        $months_id = [
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'
        ];

        return view('manage-employee-tours', [
            'newdat' => $newdat, 'tourstats' => $tourstats,
            'depts' => $depts, 'tourprogs' => $tourprogs,
            'users' => $users, 'mydets' => $mydets,
            'countnewdat' => $countnewdat, 'months' => $months, 'months_id' => $months_id
        ]);
    } //
    public function GenForm(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (((auth()->user()->account_type == "denied")) || ((auth()->user()->account_type == NULL))) {
            auth()->logout();
            return redirect()->route('login')->with('success', 'Your account will be able activated by the administrator.');
        }
        $uname = $request->selusrrep;
        $mnt = $request->selmonthrep;
        $btnvalx = $request->submitbtnn;
        switch($btnvalx) {

            case 'tba':
                $mydets = User::join('office_mgmts', 'office_mgmts.id', '=', 'users.office_id')
                ->join('department_mgmts', 'department_mgmts.id', '=', 'users.dept_id')
                ->where('users.id', $uname)->get([
                    'users.name', 'users.desg', 'department_mgmts.dept_name', 'office_mgmts.office_name'
                ]);
            $newdat = DeputeStaff::whereNotNull('users.account_type')
                ->join('users', 'depute_staff.dep_emp_name_id', '=', 'users.id')
                ->join('tour_statuses', 'depute_staff.dep_status', '=', 'tour_statuses.id')
                ->join('department_mgmts', 'depute_staff.dep_emp_depm_id', '=', 'department_mgmts.id')
                ->join('tour_programmes', 'depute_staff.dep_tour_id', '=', 'tour_programmes.id')
                ->join('tour_report_attches', 'depute_staff.attch_id', '=', 'tour_report_attches.id')
                ->join('tada_statuses', 'tada_statuses.id', '=', 'tour_report_attches.tadastat_id')
                ->when($mnt == 1, function ($query) use ($request) {
                    $query->whereMonth('tour_report_attches.ta_da_date', '=', 1)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 2)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 3);
                })
                ->when($mnt == 2, function ($query) use ($request) {
                    $query->whereMonth('tour_report_attches.ta_da_date', '=', 4)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 5)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 6);
                })
                ->when($mnt == 3, function ($query) use ($request) {
                    $query->whereMonth('tour_report_attches.ta_da_date', '=', 7)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 8)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 9);
                })
                ->when($mnt == 4, function ($query) use ($request) {
                    $query->whereMonth('tour_report_attches.ta_da_date', '=', 10)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 11)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 12);
                })
                ->where('depute_staff.dep_status', 1)
                ->where('depute_staff.dep_emp_name_id', $uname)
                ->where('tour_report_attches.tadastat_id', 4)
                ->get([
                    'users.name', 'users.desg', 'department_mgmts.dept_name'
                    , 'depute_staff.id', 'tada_statuses.tada_stat', 'tour_programmes.tour_prog'
                    , 'depute_staff.dep_reason', 'depute_staff.dep_date_from'
                    , 'depute_staff.dep_date_to', 'depute_staff.dep_no_of_days', 'depute_staff.dep_locatn'
                    , 'tour_report_attches.tr_departure_dt', 'tour_report_attches.tr_arrival_dt'
                    , 'tour_report_attches.ta_da_date', 'tour_report_attches.tr_departure_dt'
                    , 'tour_report_attches.tr_departure_tm', 'tour_report_attches.tr_arrival_dt'
                    , 'tour_report_attches.tr_arrival_tm', 'tour_report_attches.tr_pt_of_origin1'
                    , 'tour_report_attches.tr_pt_of_destination1', 'tour_report_attches.tr_pt_of_origin2'
                    , 'tour_report_attches.tr_pt_of_destination2', 'tour_report_attches.tr_travel_mode'
                    , 'tour_report_attches.tr_da_amt', 'tour_report_attches.tr_lodg_amt'
                    , 'tour_report_attches.tr_mileage', 'tour_report_attches.tr_travel_amt'
                    , 'tour_report_attches.tr_adv_allw', 'tour_report_attches.tr_other_amt'
                    , 'tour_report_attches.jr_type'
                ]);
            if (count($newdat) == 0) {
                return redirect()->route('employees-tour.index')->with('success', 'No Data Available For Given Quater');
            } else {
                $gtot = 0;
                $sm = 0;
                $sm_amt = 0;
                $sm_adv = 0;
                $res_amt = 0;
                $bln_amt = 0;


                $tab = '';
                $tab .= '<table>';
                $tab .= '<tr>';
                $tab .= '<th colspan="6">Name Of Employee:' . $mydets[0]->name . '</th>';
                $tab .= '<th colspan="4">Designation:' . $mydets[0]->desg . '</th>';
                foreach ($newdat as $key) {
                    $sm_amt = $sm_amt + $key->tr_travel_amt;
                    $sm_adv = $sm_adv + $key->tr_adv_allw;
                    $res_amt = $sm_adv - $sm_amt;
                    $sm = $key->tr_da_amt + $key->tr_lodg_amt + $key->tr_other_amt;
                    $sm = $key->tr_da_amt + $key->tr_lodg_amt + $key->tr_other_amt;//all allowance excluding TA
                    $gtot = $sm + $gtot;
                    $bln_amt = ($gtot + $sm_amt) - $sm_adv;
                }

                $tab .= '<th colspan="6">Pays:'. $bln_amt .'</th>';
                $gtot = 0;
                $sm = 0;
                $sm_amt = 0;
                $sm_adv = 0;
                $res_amt = 0;
                $bln_amt = 0;
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td colspan="16">Department:' . $mydets[0]->dept_name . '</td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td colspan="9">Name Of Office:' . $mydets[0]->office_name . '</td>';
                $tab .= '<td colspan="7">Quater:' . $mnt . '</td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td colspan="16"></td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td rowspan="3">Journey Type</td>';
                $tab .= '<td colspan="8">Tour Programme</td>';
                $tab .= '<td rowspan="3">Travel(Road/Rly/Air)</td>';
                $tab .= '<td colspan="1">Mileage Allowance</td>';
                $tab .= '<td rowspan="3">DA</td>';
                $tab .= '<td rowspan="3">LA</td>';
                $tab .= '<td rowspan="3">Others</td>';
                $tab .= '<td rowspan="3">Totals</td>';
                $tab .= '<td rowspan="3">Remarks</td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td colspan="2">Departure</td>';
                $tab .= '<td colspan="2">Arrival</td>';
                $tab .= '<td colspan="2">(Pt of origin - destination)Start Journey</td>';
                $tab .= '<td colspan="2">(Pt of destination - origin)Return Journey</td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td>Date</td>';
                $tab .= '<td>Time</td>';
                $tab .= '<td>Date</td>';
                $tab .= '<td>Time</td>';
                $tab .= '<td>From</td>';
                $tab .= '<td>To</td>';
                $tab .= '<td>From</td>';
                $tab .= '<td>To</td>';
                $tab .= '</tr>';
                foreach ($newdat as $key) {
                    $tab .= '<tr>';
                    $tab .= '<td>' . $key->jr_type . '</td>';//$newdat[0]->jr_type
                    $tab .= '<td>' . date("d/m/Y", strtotime($key->tr_departure_dt)) . '</td>';
                    //$tab .= '<td>' . date("g:i A", strtotime($key->tr_departure_tm)) . '</td>';
                    $tab .= '<td>' . $key->tr_departure_tm . '</td>';
                    $tab .= '<td>' .  date("d/m/Y", strtotime($key->tr_arrival_dt)) . '</td>';
                    //$tab .= '<td>' . date("g:i A", strtotime($key->tr_arrival_tm)) . '</td>';
                    $tab .= '<td>' . $key->tr_arrival_tm . '</td>';
                    $tab .= '<td>' . $key->tr_pt_of_origin1 . '</td>';
                    $tab .= '<td>' . $key->tr_pt_of_destination1 . '</td>'; //tr_travel_mode
                    $tab .= '<td>' . $key->tr_pt_of_origin2 . '</td>';
                    $tab .= '<td>' . $key->tr_pt_of_destination2 . '</td>'; //tr_travel_mode
                    $tab .= '<td>' . $key->tr_travel_mode . '</td>';
                    $tab .= '<td>' . $key->tr_mileage . '</td>';
                    $sm_amt = $sm_amt + $key->tr_travel_amt;//sum of travel allowances
                    $sm_adv = $sm_adv + $key->tr_adv_allw;//sum of advanced travel allowances
                    //$res_amt = $sm_adv - $sm_amt;
                    $sm = $key->tr_da_amt + $key->tr_lodg_amt + $key->tr_other_amt;//all allowance excluding TA
                    $gtot = $sm + $gtot;
                    $bln_amt = ($gtot + $sm_amt) - $sm_adv;
                    $tab .= '<td>' . $key->tr_da_amt . '</td>';
                    $tab .= '<td>' . $key->tr_lodg_amt . '</td>';
                    $tab .= '<td>' . $key->tr_other_amt . '</td>';
                    $tab .= '<td>' . $sm . '</td>';
                    $tab .= '<td></td>';
                    $tab .= '</tr>';
                }

                $tab .= '<tr>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td colspan="2">Total TA Claim:</td>';
                $tab .= '<td>' . $sm_amt . '</td>';
                $tab .= '<td></td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td colspan="2">Grand Total:</td>';
                $gt = 0;
                $gt = $gtot  + $sm_amt;
                $tab .= '<td>' . $gt . '</td>';
                $tab .= '<td></td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td colspan="2">Total TA Advance Drawn</td>';
                $tab .= '<td>' . $sm_adv . '</td>';
                $tab .= '<td></td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                if ($bln_amt > 0) {
                    $tab .= '<td colspan="2">Amount To Be Refunded:</td>';
                    $tab .= '<td>' . $bln_amt . '</td>';
                } else {
                    $tab .= '<td colspan="2">Amount To Be Refunded:</td>';
                    $tab .= '<td>' . $bln_amt . '</td>';
                }
                $tab .= '<td></td>';
                $tab .= '</tr>';
                $tab .= '</table>';
                $tab .= '<br>';
                $tab .= '<br>';
                $tab .= '<br>';
                $tab .= '<br>';
                $tab .= '<table>';
                $tab .= '<tr>';
                $tab .= '<td colspan="5">Checked By:</td>';
                $tab .= '<td colspan="5">Recommended By:</td>';
                $tab .= '<td colspan="5">Approved By:</td>';
                $tab .= '</tr>';
                $tab .= '</table>';

                $view = \View('genform', ['tab' => $tab]);
                $html = $view->render();
                $pdf = new TCPDF('L', 'pt', ['format' => 'A4', 'Rotate' => 90]);
                $pdf::SetTitle('Tour Report');
                $pdf::AddPage('L');
                $pdf::writeHTML($html, true, false, true, false, '');
                $pdf::Output('TourReport.pdf');
            }
            break;

            case 'ac':
                $mydets = User::join('office_mgmts', 'office_mgmts.id', '=', 'users.office_id')
                ->join('department_mgmts', 'department_mgmts.id', '=', 'users.dept_id')
                ->where('users.id', $uname)->get([
                    'users.name', 'users.desg', 'department_mgmts.dept_name', 'office_mgmts.office_name'
                ]);
            $newdat = DeputeStaff::whereNotNull('users.account_type')
                ->join('users', 'depute_staff.dep_emp_name_id', '=', 'users.id')
                ->join('tour_statuses', 'depute_staff.dep_status', '=', 'tour_statuses.id')
                ->join('department_mgmts', 'depute_staff.dep_emp_depm_id', '=', 'department_mgmts.id')
                ->join('tour_programmes', 'depute_staff.dep_tour_id', '=', 'tour_programmes.id')
                ->join('tour_report_attches', 'depute_staff.attch_id', '=', 'tour_report_attches.id')
                ->join('tada_statuses', 'tada_statuses.id', '=', 'tour_report_attches.tadastat_id')
                ->when($mnt == 1, function ($query) use ($request) {
                    $query->whereMonth('tour_report_attches.ta_da_date', '=', 1)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 2)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 3);
                })
                ->when($mnt == 2, function ($query) use ($request) {
                    $query->whereMonth('tour_report_attches.ta_da_date', '=', 4)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 5)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 6);
                })
                ->when($mnt == 3, function ($query) use ($request) {
                    $query->whereMonth('tour_report_attches.ta_da_date', '=', 7)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 8)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 9);
                })
                ->when($mnt == 4, function ($query) use ($request) {
                    $query->whereMonth('tour_report_attches.ta_da_date', '=', 10)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 11)
                        ->orwhereMonth('tour_report_attches.ta_da_date', '=', 12);
                })
                ->where('depute_staff.dep_status', 1)
                ->where('depute_staff.dep_emp_name_id', $uname)
                ->where('tour_report_attches.tadastat_id', 1)
                ->get([
                    'users.name', 'users.desg', 'department_mgmts.dept_name'
                    , 'depute_staff.id', 'tada_statuses.tada_stat', 'tour_programmes.tour_prog'
                    , 'depute_staff.dep_reason', 'depute_staff.dep_date_from'
                    , 'depute_staff.dep_date_to', 'depute_staff.dep_no_of_days', 'depute_staff.dep_locatn'
                    , 'tour_report_attches.tr_departure_dt', 'tour_report_attches.tr_arrival_dt'
                    , 'tour_report_attches.tr_pt_of_origin1', 'tour_report_attches.ta_da_date'
                    , 'tour_report_attches.tr_pt_of_destination1', 'tour_report_attches.tr_departure_dt'
                    , 'tour_report_attches.tr_departure_tm', 'tour_report_attches.tr_arrival_dt'
                    , 'tour_report_attches.tr_arrival_tm', 'tour_report_attches.tr_pt_of_origin2'
                    , 'tour_report_attches.tr_pt_of_destination2', 'tour_report_attches.tr_travel_mode'
                    , 'tour_report_attches.tr_da_amt', 'tour_report_attches.tr_lodg_amt'
                    , 'tour_report_attches.tr_mileage', 'tour_report_attches.tr_travel_amt'
                    , 'tour_report_attches.tr_adv_allw', 'tour_report_attches.tr_other_amt'
                    , 'tour_report_attches.jr_type'
                ]);
            if (count($newdat) == 0) {
                return redirect()->route('employees-tour.index')->with('success', 'No Data Available For Given Quater');
            } else {
                $gtot = 0;
                $sm = 0;
                $sm_amt = 0;
                $sm_adv = 0;
                $res_amt = 0;
                $bln_amt = 0;


                $tab = '';
                $tab .= '<table>';
                $tab .= '<tr>';
                $tab .= '<th colspan="6">Name Of Employee:' . $mydets[0]->name . '</th>';
                $tab .= '<th colspan="4">Designation:' . $mydets[0]->desg . '</th>';
                foreach ($newdat as $key) {
                    $sm_amt = $sm_amt + $key->tr_travel_amt;
                    $sm_adv = $sm_adv + $key->tr_adv_allw;
                    $res_amt = $sm_adv - $sm_amt;
                    $sm = $key->tr_da_amt + $key->tr_lodg_amt + $key->tr_other_amt;
                    $sm = $key->tr_da_amt + $key->tr_lodg_amt + $key->tr_other_amt;//all allowance excluding TA
                    $gtot = $sm + $gtot;
                    $bln_amt = ($gtot + $sm_amt) - $sm_adv;
                }

                $tab .= '<th colspan="6">Pays:'. $bln_amt .'</th>';
                $gtot = 0;
                $sm = 0;
                $sm_amt = 0;
                $sm_adv = 0;
                $res_amt = 0;
                $bln_amt = 0;
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td colspan="16">Department:' . $mydets[0]->dept_name . '</td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td colspan="9">Name Of Office:' . $mydets[0]->office_name . '</td>';
                $tab .= '<td colspan="7">Quater:' . $mnt . '</td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td colspan="16"></td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td rowspan="3">Journey Type</td>';
                $tab .= '<td colspan="8">Tour Programme</td>';
                $tab .= '<td rowspan="3">Travel(Road/Rly/Air)</td>';
                $tab .= '<td colspan="1">Mileage Allowance</td>';
                $tab .= '<td rowspan="3">DA</td>';
                $tab .= '<td rowspan="3">LA</td>';
                $tab .= '<td rowspan="3">Others</td>';
                $tab .= '<td rowspan="3">Totals</td>';
                $tab .= '<td rowspan="3">Remarks</td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td colspan="2">Departure</td>';
                $tab .= '<td colspan="2">Arrival</td>';
                $tab .= '<td colspan="2">Start Journey</td>';
                $tab .= '<td colspan="2">Return Journey</td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td>Date</td>';
                $tab .= '<td>Time</td>';
                $tab .= '<td>Date</td>';
                $tab .= '<td>Time</td>';
                $tab .= '<td>From</td>';
                $tab .= '<td>To</td>';
                $tab .= '<td>From</td>';
                $tab .= '<td>To</td>';
                $tab .= '</tr>';
                foreach ($newdat as $key) {
                    $tab .= '<tr>';
                    $tab .= '<td>' . $key->jr_type . '</td>';//$newdat[0]->jr_type
                    $tab .= '<td>' . date("d/m/Y", strtotime($key->tr_departure_dt)) . '</td>';
                    //$tab .= '<td>' . date("g:i A", strtotime($key->tr_departure_tm)) . '</td>';
                    $tab .= '<td>' . $key->tr_departure_tm . '</td>';
                    $tab .= '<td>' .  date("d/m/Y", strtotime($key->tr_arrival_dt)) . '</td>';
                    //$tab .= '<td>' . date("g:i A", strtotime($key->tr_arrival_tm)) . '</td>';
                    $tab .= '<td>' . $key->tr_arrival_tm . '</td>';
                    $tab .= '<td>' . $key->tr_pt_of_origin1 . '</td>';
                    $tab .= '<td>' . $key->tr_pt_of_destination1 . '</td>'; //tr_travel_mode
                    $tab .= '<td>' . $key->tr_pt_of_origin2 . '</td>';
                    $tab .= '<td>' . $key->tr_pt_of_destination2 . '</td>'; //tr_travel_mode
                    $tab .= '<td>' . $key->tr_travel_mode . '</td>';
                    $tab .= '<td>' . $key->tr_mileage . '</td>';
                    $sm_amt = $sm_amt + $key->tr_travel_amt;//sum of travel allowances
                    $sm_adv = $sm_adv + $key->tr_adv_allw;//sum of advanced travel allowances
                    //$res_amt = $sm_adv - $sm_amt;
                    $sm = $key->tr_da_amt + $key->tr_lodg_amt + $key->tr_other_amt;//all allowance excluding TA
                    $gtot = $sm + $gtot;
                    $bln_amt = ($gtot + $sm_amt) - $sm_adv;
                    $tab .= '<td>' . $key->tr_da_amt . '</td>';
                    $tab .= '<td>' . $key->tr_lodg_amt . '</td>';
                    $tab .= '<td>' . $key->tr_other_amt . '</td>';
                    $tab .= '<td>' . $sm . '</td>';
                    $tab .= '<td></td>';
                    $tab .= '</tr>';
                }

                $tab .= '<tr>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td colspan="2">Total TA Claim:</td>';
                $tab .= '<td>' . $sm_amt . '</td>';
                $tab .= '<td></td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td colspan="2">Grand Total:</td>';
                $gt = 0;
                $gt = $gtot  + $sm_amt;
                $tab .= '<td>' . $gt . '</td>';
                $tab .= '<td></td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td colspan="2">Total TA Advance Drawn</td>';
                $tab .= '<td>' . $sm_adv . '</td>';
                $tab .= '<td></td>';
                $tab .= '</tr>';
                $tab .= '<tr>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                $tab .= '<td></td>';
                if ($bln_amt > 0) {
                    $tab .= '<td colspan="2">Amount To Be Refunded:</td>';
                    $tab .= '<td>' . $bln_amt . '</td>';
                } else {
                    $tab .= '<td colspan="2">Amount To Be Refunded:</td>';
                    $tab .= '<td>' . $bln_amt . '</td>';
                }
                $tab .= '<td></td>';
                $tab .= '</tr>';
                $tab .= '</table>';
                $tab .= '<br>';
                $tab .= '<br>';
                $tab .= '<br>';
                $tab .= '<br>';
                $tab .= '<table>';
                $tab .= '<tr>';
                $tab .= '<td colspan="5">Checked By:</td>';
                $tab .= '<td colspan="5">Recommended By:</td>';
                $tab .= '<td colspan="5">Approved By:</td>';
                $tab .= '</tr>';
                $tab .= '</table>';
                $tab .= '<br>';
                $tab .= '<br>';
                $tab .= '<br>';
                $tab .= '<br>';

                $view = \View('genform', ['tab' => $tab]);
                $html = $view->render();
                $pdf = new TCPDF('L', 'pt', ['format' => 'A4', 'Rotate' => 90]);
                $pdf::SetTitle('Tour Report');
                $pdf::AddPage('L');
                $pdf::writeHTML($html, true, false, true, false, '');
                $pdf::Output('TourReport.pdf');
            }
            break;
        }

    }
    public function UpdateTaDaStat(Request $request)
    {
        $depid = $request->depid;
        $rep_id = $request->seltadastat;
        $curdate = date('Y-m-d');
        TourReportAttch::where('dep_id', $depid)->update(array(
            'tadastat_id' => $rep_id, 'ta_da_date' => $curdate
        ));
        DeputeStaff::where('id', $depid)->update(array('tada_status_id' => $rep_id));
        return response()->json(['success' => "Successfully Updated Data"]);
    }

    public function EditReportStat(Request $request)
    {
        $rep_id = $request->rep_id;
        $tadas = TadaStatus::get(['tada_stat', 'id']);
        $reqdatas = TourReportAttch::join('tada_statuses', 'tour_report_attches.tadastat_id', '=', 'tada_statuses.id')
            ->where('tour_report_attches.dep_id', $rep_id)->get(['tour_report_attches.tadastat_id']);
        //$req_datas = TadaStatus::where('id', $reqdatas[0]->tadastat_id)->get(['tada_stat', 'id']);
        return response()->json(['req_datas' => $reqdatas, 'tadas' => $tadas]);
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
     * @param  \App\Models\ManageTourRequest  $manageTourRequest
     * @return \Illuminate\Http\Response
     */
    public function show(ManageTourRequest $manageTourRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ManageTourRequest  $manageTourRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(ManageTourRequest $manageTourRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ManageTourRequest  $manageTourRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ManageTourRequest $manageTourRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ManageTourRequest  $manageTourRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageTourRequest $manageTourRequest)
    {
        //
    }
}
