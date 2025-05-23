<?php


use App\Http\Controllers\ApiTestController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SeamlessSettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GroupMenuController;
use App\Http\Controllers\LogMonitorController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MonitorJobController;
use App\Http\Controllers\OutstandingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserAccessController;
use App\Http\Controllers\UserController;
use App\Jobs\createProductJob;
use Illuminate\Support\Facades\Route;

Route::get('/x0lex', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->Middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::middleware(['auth'])->group(function () { 
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/seamlesssetting', [SeamlessSettingController::class, 'index']);
    Route::get('/seamlesssetting/create', [SeamlessSettingController::class, 'create']);
    Route::get('/seamlesssetting/view/{company_id}', [SeamlessSettingController::class, 'view']);
    Route::post('/seamlesssetting/update-enable', [SeamlessSettingController::class, 'updateEnable']);

    Route::get('/member', [MemberController::class, 'index']);
    Route::get('/member/create', [MemberController::class, 'create']);
    Route::get('/member/edit/{id}', [MemberController::class, 'edit']);
    Route::post('/member/store', [MemberController::class, 'store']);
    Route::put('/member/update/{id}', [MemberController::class, 'update']);
    Route::delete('/member/delete/{id}', [MemberController::class, 'destroy']);

    Route::get('/company', [CompanyController::class, 'index']);
    Route::get('/company/create', [CompanyController::class, 'create']);
    Route::get('/company/edit/{id}', [CompanyController::class, 'edit']);
    Route::post('/company/store', [CompanyController::class, 'store']);
    Route::put('/company/update/{id}', [CompanyController::class, 'update']);
    Route::delete('/company/delete/{id}', [CompanyController::class, 'destroy']);

    Route::get('/game', [GameController::class, 'index']);
    Route::get('/game/create', [GameController::class, 'create']);
    Route::get('/game/edit/{id}', [GameController::class, 'edit']);
    Route::post('/game/store', [GameController::class, 'store']);
    Route::put('/game/update/{id}', [GameController::class, 'update']);
    Route::delete('/game/delete/{id}', [GameController::class, 'destroy']);

    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/create', [UserController::class, 'create']);
    Route::get('/user/edit/{id}', [UserController::class, 'edit']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::put('/user/update/{id}', [UserController::class, 'update']);
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy']);

    Route::get('/useraccess', [UserAccessController::class, 'index']);
    Route::get('/useraccess/create', [UserAccessController::class, 'create']);
    Route::get('/useraccess/edit/{id}', [UserAccessController::class, 'edit']);
    Route::post('/useraccess/store', [UserAccessController::class, 'store']);
    Route::put('/useraccess/update/{id}', [UserAccessController::class, 'update']);
    Route::delete('/useraccess/delete/{id}', [UserAccessController::class, 'destroy']);

    Route::get('/menu', [MenuController::class, 'index']);
    Route::get('/menu/create', [MenuController::class, 'create']);
    Route::get('/menu/edit/{id}', [MenuController::class, 'edit']);
    Route::post('/menu/store', [MenuController::class, 'store']);
    Route::put('/menu/update/{id}', [MenuController::class, 'update']);
    Route::delete('/menu/delete/{id}', [MenuController::class, 'destroy']);

    Route::get('/groupmenu', [GroupMenuController::class, 'index']);
    Route::get('/groupmenu/create', [GroupMenuController::class, 'create']);
    Route::get('/groupmenu/edit/{id}', [GroupMenuController::class, 'edit']);
    Route::post('/groupmenu/store', [GroupMenuController::class, 'store']);
    Route::put('/groupmenu/update/{id}', [GroupMenuController::class, 'update']);
    Route::delete('/groupmenu/delete/{id}', [GroupMenuController::class, 'destroy']);

    Route::get('/outstanding/{username?}', [OutstandingController::class, 'index']);
    Route::get('/outstanding/create', [OutstandingController::class, 'create']);
    Route::get('/outstanding/edit/{id}', [OutstandingController::class, 'edit']);
    Route::post('/outstanding/store', [OutstandingController::class, 'store']);
    Route::put('/outstanding/update/{id}', [OutstandingController::class, 'update']);
    Route::delete('/outstanding/delete/{id}', [OutstandingController::class, 'destroy']);

    Route::get('/winlose/{username?}', [ReportController::class, 'index']);
    Route::get('/wlmonthly/{username?}', [ReportController::class, 'indexmonthly']);
    Route::get('/wlyearly/{username?}', [ReportController::class, 'indexyearly']);

    Route::get('/transaction', [TransactionController::class, 'index']);
    Route::get('/period', [TransactionController::class, 'indexperiod']);

    Route::get('/monitorjob', [MonitorJobController::class, 'index']);
    Route::get('/failjob', [MonitorJobController::class, 'indexfailjob']);

    Route::get('/monitorlog', [LogMonitorController::class, 'index'])->name('log.index');
    Route::post('/monitorlog/clear', [LogMonitorController::class, 'clear'])->name('log.clear');
});

Route::post('/run-tests', [ApiTestController::class, 'runTests']);
Route::get('/docs', [ApiTestController::class, 'documentation']);
Route::get('/docs/test', [ApiTestController::class, 'docsTest']);

Route::get('/exportDailyWinlose', [ReportController::class, 'exportReportDaily']); 
Route::get('/exportMonthlyWinlose', [ReportController::class, 'exportReportMonthly']); 
Route::get('/exportYearlyWinlose', [ReportController::class, 'exportReportYearly']); 

Route::get('/test', function () {
    $data = ['copa' => 1, 'order_id' => 1];
    createProductJob::dispatch($data);
    return;
});


