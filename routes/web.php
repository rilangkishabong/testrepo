<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::resource('/master-department', 'App\Http\Controllers\DepartmentMgmtController');
Route::resource('/master-office', 'App\Http\Controllers\OfficeMgmtController');
Route::resource('/master-leavetype', 'App\Http\Controllers\LeaveTypeMgmtController');
Route::resource('/master-user', 'App\Http\Controllers\UserMgmtController');
Route::resource('/master-user-infos', 'App\Http\Controllers\ManageUserInfosController');
Route::resource('/master-leave-applist', 'App\Http\Controllers\LeaveApplicatnListController');
Route::resource('/master-leave-stat', 'App\Http\Controllers\LeaveStatusController');
Route::resource('/master-leave-type', 'App\Http\Controllers\LeaveTypeMasterController');
Route::resource('/depute-staff', 'App\Http\Controllers\DeputeStaffController');
Route::resource('/tour-management', 'App\Http\Controllers\TourProgrammeController');
Route::resource('/allowance-management', 'App\Http\Controllers\AllowanceController');
Route::resource('/my-allowance-management', 'App\Http\Controllers\MyAllowanceManagementController');
Route::resource('/request-tour', 'App\Http\Controllers\TourListController');
Route::resource('/tour-report', 'App\Http\Controllers\TourReportAttchController');
Route::resource('/tour-report-attch', 'App\Http\Controllers\FileAttchController');
Route::resource('/employees-tour', 'App\Http\Controllers\ManageTourRequestController');
Route::resource('/my-daily-activities', 'App\Http\Controllers\DailyActivityController');
Route::resource('/view-daily-activities', 'App\Http\Controllers\ActivityStatusController');

Route::get('/UserTypes', [App\Http\Controllers\HomeController::class, 'UserTypes'])->name('UserTypes');
Route::get('/list-of-employee-leave', [App\Http\Controllers\LeaveApplicatnListController::class, 'EmployeeLeaveList'])->name('list-of-employee-leave');
Route::get('/accepted-leave-stat', [App\Http\Controllers\LeaveApplicatnListController::class, 'AccLeaveStat'])->name('accepted-leave-stat');
Route::get('/rejected-leave-stat', [App\Http\Controllers\LeaveApplicatnListController::class, 'RejLeaveStat'])->name('rejected-leave-stat');
Route::get('/ApplyLeave', [App\Http\Controllers\LeaveApplicatnListController::class, 'ApplyLeave'])->name('ApplyLeave');
Route::get('/EmployeeLeaveSummary', [App\Http\Controllers\EmployeeLeaveSummaryController::class, 'EmployeeLeaveSummary'])->name('EmployeeLeaveSummary');
Route::get('/AppliedLeave', [App\Http\Controllers\LeaveApplicatnListController::class, 'AppliedLeave'])->name('AppliedLeave');
Route::get('/AcceptedAppliedLeave', [App\Http\Controllers\LeaveApplicatnListController::class, 'AcceptedAppliedLeave'])->name('AcceptedAppliedLeave');
Route::get('/CancelledAppliedLeave', [App\Http\Controllers\LeaveApplicatnListController::class, 'CancelledAppliedLeave'])->name('CancelledAppliedLeave');
Route::get('/RejectedAppliedLeave', [App\Http\Controllers\LeaveApplicatnListController::class, 'RejectedAppliedLeave'])->name('RejectedAppliedLeave');
Route::get('/deput-duties', [App\Http\Controllers\DeputeStaffController::class, 'AcceptDeputeStaff'])->name('deput-duties');
Route::get('/manage-tour', [App\Http\Controllers\TourListController::class, 'ManageTours'])->name('manage-tour');
Route::get('/approved-tour', [App\Http\Controllers\TourListController::class, 'ApprovedTours'])->name('approved-tour');
Route::get('/rejected-tour', [App\Http\Controllers\TourListController::class, 'RejectedTours'])->name('rejected-tour');

Route::post('/sendEmail', [App\Http\Controllers\ManageTourRequestController::class, 'sendEmail'])->name('sendEmail');
Route::post('/GetAttchs2', [App\Http\Controllers\ManageTourRequestController::class, 'GetAttchs2'])->name('GetAttchs2');
Route::post('/GetAttchs', [App\Http\Controllers\ManageTourRequestController::class, 'GetAttchs'])->name('GetAttchs');
Route::post('/GetAdv', [App\Http\Controllers\ManageTourRequestController::class, 'GetAdv'])->name('GetAdv');
Route::post('/GenExl', [App\Http\Controllers\ActivityStatusController::class, 'GenExl'])->name('GenExl');
Route::post('/GenForm', [App\Http\Controllers\ManageTourRequestController::class, 'GenForm'])->name('GenForm');
Route::post('/UpdateTaDaStat', [App\Http\Controllers\ManageTourRequestController::class, 'UpdateTaDaStat']);
Route::post('/EditReportStat', [App\Http\Controllers\ManageTourRequestController::class, 'EditReportStat']);
Route::post('/CheckIfTourIsFiled', [App\Http\Controllers\TourReportAttchController::class, 'CheckIfTourIsFiled']);
Route::post('/GetTourAttchs', [App\Http\Controllers\TourReportAttchController::class, 'GetTourAttchs']);
Route::post('/GetDeputDates', [App\Http\Controllers\TourReportAttchController::class, 'GetDeputDates']);
Route::post('/CancelAppliedLeave', [App\Http\Controllers\LeaveApplicatnListController::class, 'CancelAppliedLeave']);
Route::post('/ReqUserDatas', [App\Http\Controllers\UserMgmtController::class, 'ReqUserDatas']);
Route::post('/UpdateUserType', [App\Http\Controllers\HomeController::class, 'UpdateUserType']);
Route::post('/UpdMyTourReportDets', [App\Http\Controllers\TourReportAttchController::class, 'UpdMyTourReportDets']);
Route::post('/MyTourReportDets', [App\Http\Controllers\TourReportAttchController::class, 'MyTourReportDets']);
Route::post('/EditMyTourReport', [App\Http\Controllers\TourReportAttchController::class, 'EditMyTourReport']);
Route::post('/GetTourStatus', [App\Http\Controllers\TourListController::class, 'GetTourStatus']);
Route::post('/UpdateTourStatus', [App\Http\Controllers\TourListController::class, 'UpdateTourStatus']);
Route::post('/UpdateDeputeStatus', [App\Http\Controllers\DeputeStaffController::class, 'UpdateDeputeStatus']);
Route::post('/UpdateDeputeDatax', [App\Http\Controllers\DeputeStaffController::class, 'UpdateDeputeDatax']);
Route::post('/UpdateTourDatax', [App\Http\Controllers\TourListController::class, 'UpdateTourDatax']);
Route::post('/GetDeputDatas', [App\Http\Controllers\DeputeStaffController::class, 'GetDeputDatas']);
Route::post('/GetTourDatas', [App\Http\Controllers\TourListController::class, 'GetTourDatas']);
Route::post('/GetUserDatas', [App\Http\Controllers\UserMgmtController::class, 'GetUserDatas']);
Route::post('/UpdateAppliedLeave', [App\Http\Controllers\LeaveApplicatnListController::class, 'UpdateAppliedLeave']);
Route::post('/GetAppliedLeave', [App\Http\Controllers\LeaveApplicatnListController::class, 'GetAppliedLeave']);
Route::post('/ChgLeaveStat', [App\Http\Controllers\LeaveApplicatnListController::class, 'ChgLeaveStat']);
Route::post('/UpdateLeaveData', [App\Http\Controllers\LeaveApplicatnListController::class, 'UpdateLeaveData']);
Route::post('/GetOffice', [App\Http\Controllers\UserMgmtController::class, 'GetOffice']);
Route::post('/UpdateUserData', [App\Http\Controllers\UserMgmtController::class, 'UpdateUserData']);
Route::post('/GetDepartment', [App\Http\Controllers\UserMgmtController::class, 'GetDepartment']);
Route::post('/cancelled-leave-stat', [App\Http\Controllers\LeaveApplicatnListController::class, 'CancLeaveStat']);

//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/land', function () {
    return view('welcome');
})->name('land');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
