<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\GetAttributeController;
use App\Http\Controllers\SubDepartmentController;

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

Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('admin/departments', DepartmentController::class);

    Route::resource('admin/employees', EmployeeController::class);

    Route::resource('admin/positions', PositionController::class);

    Route::resource('admin/sub-departments', SubDepartmentController::class);

    Route::controller(AdminController::class)->group(function () {
        Route::get('admin/technicians', 'index')
            ->name('admin.index');

        Route::post('admin/technicians', 'store')
            ->name('admin.store');

        Route::put('admin/technicians/{technician}', 'update')
            ->name('admin.update');

        Route::delete('admin/technicians/{technician}', 'destroy')
            ->name('admin.destroy');
    });

    Route::controller(TicketController::class)->group(function () {
        Route::get('admin/tickets', 'index')
            ->name('tickets.index');
    });
});

Route::middleware('auth')->group(function () {
    Route::controller(GetAttributeController::class)->group(function () {
        Route::get('get/category/{ticket}', 'getCategory');

        Route::get('get/permintaan/{ticket}', 'getPermintaan');

        Route::get('get/position/{user}', 'getPosition');

        Route::get('get/position/technician/{user}', 'getPositionTechnician');

        Route::get('get/selected/department/{user}', 'getSelectedDepartment');

        Route::get('get/selected/technician/department/{user}', 'getSelectedTechnicianDepartment');

        Route::get('get/selected/gender/{user}', 'getSelectedGender');

        Route::get('get/selected/technician/gender/{user}', 'getSelectedTechnicianGender');

        Route::get('get/selected/sub-department/{user}', 'getSelectedSubDepartment');

        Route::get('get/selected/technician/sub-department/{user}', 'getSelectedTechnicianSubDepartment');

        Route::get('get/sub-department/{department}', 'getSubDepartment');

        Route::get('get/ticket/{ticket}', 'getTicket');

        Route::get('get/user/{user}', 'getUser');
    });
});

Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('manager/dashboard', [DashboardController::class, 'index'])
        ->name('manager.dashboard');

    Route::get('manager/tickets/approval', [TicketController::class, 'approval'])
        ->name('tickets.approval');

    Route::get('manager/tickets', [TicketController::class, 'index'])
        ->name('manager.tickets.index');

    Route::post('admin/tickets/accept/{ticket}', [TicketController::class, 'accept'])
        ->name('tickets.accept');

    Route::post('admin/tickets/reject/{id}', [TicketController::class, 'reject'])
        ->name('tickets.reject');
});

Route::middleware('auth', 'role:technician')->group(function () {
    Route::controller(TechnicianController::class)->group(function () {
        Route::get('technician', 'index')
            ->name('technicians.index');

        Route::get('technician/request', 'create')
            ->name('technicians.create');

        Route::get('technician/tickets', 'show')
            ->name('technicians.show');

        Route::put('technician/{id}', 'update')
            ->name('technicians.update');

        Route::get('technician/report', 'report')
            ->name('technicians.report');

        Route::get('technician/report/{start?}/{end?}.pdf', 'pdf')
            ->name('technicians.pdf');
    });
});

Route::middleware('auth', 'role:user', 'can:employee')->group(function () {
    Route::get('/', [TicketController::class, 'create'])
        ->name('tickets.create');

    Route::post('/', [TicketController::class, 'store']);

    Route::get('tickets/my-ticket', [TicketController::class, 'show'])
        ->name('tickets.show');

    Route::get('faq', [FaqController::class, 'index'])
        ->name('faq.index');
});

Route::middleware(['auth', 'role:user', 'can:kepala'])->group(function () {
    Route::get('dashboard', [TicketController::class, 'dashboard'])
        ->name('user.dashboard');

    Route::get('tickets/report', [TicketController::class, 'report'])
        ->name('tickets.report');

    Route::get('reports/get/{start?}/{end?}/{technician?}/{status?}', [ReportController::class, 'technician'])
        ->name('reports.technician');

    Route::get('reports/{start?}/{end?}/{status?}', [ReportController::class, 'show'])
        ->name('reports.show');
});

require __DIR__ . '/auth.php';
