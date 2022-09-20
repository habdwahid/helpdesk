<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Technician;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data = Ticket::select(DB::raw('COUNT(*) as data'));
        $months = Ticket::select(DB::raw('MONTHNAME(created_at) as month'));
        $confirm = Ticket::where('ticket_status_id', 1);
        $process = Ticket::where('ticket_status_id', 2);
        $solved = Ticket::where('ticket_status_id', 3);
        $rejected = Ticket::where('ticket_status_id', 4);

        if (request()->only('month')) {
            if (request('month') != null) {
                $data = $data->whereMonth('created_at', str(request('month'))->after('-'))
                    ->whereYear('created_at', str(request('month'))->before('-'));
                $months = $months->whereMonth('created_at', str(request('month'))->after('-'))
                    ->whereYear('created_at', str(request('month'))->before('-'));
            } else {
                $data = $data->whereYear('created_at', date('Y'))
                    ->groupBy(DB::raw('MONTH(created_at)'));
                $months = $months->whereYear('created_at', date('Y'))
                    ->groupBy(DB::raw('month'));
            }
        }

        if (request()->only('month')) {
            if (request('month') != null) {
                $confirm = $confirm->whereMonth('created_at', str(request('month'))->after('-'))
                    ->whereYear('created_at', str(request('month'))->before('-'));
                $process = $process->whereMonth('created_at', str(request('month'))->after('-'))
                    ->whereYear('created_at', str(request('month'))->before('-'));
                $solved = $solved->whereMonth('created_at', str(request('month'))->after('-'))
                    ->whereYear('created_at', str(request('month'))->before('-'));
                $rejected = $rejected->whereMonth('created_at', str(request('month'))->after('-'))
                    ->whereYear('created_at', str(request('month'))->before('-'));
            }
        }

        return view('main.admin.dashboard.index', [
            'title' => 'Dashboard',
            'employees' => Employee::count('id'),
            'confirm' => $confirm->count('id'),
            'process' => $process->count(),
            'rejected' => $rejected->count(),
            'solved' => $solved->count(),
            'technicians' => Technician::count('id'),
            'tickets' => Ticket::count('id'),
            'x' => $months->pluck('month'),
            'y' => $data->pluck('data'),
        ]);
    }
}
