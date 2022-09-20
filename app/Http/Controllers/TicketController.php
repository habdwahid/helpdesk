<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Pengadaan;
use App\Models\Technician;
use App\Models\TicketStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TicketCreatedNotification;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('main.admin.ticket.index', [
            'title' => 'Tiket',
            'tickets' => Ticket::search(request('search'))
                ->whereIn('ticket_status_id', [2, 3, 4, 5])
                ->simplePaginate(10),
        ]);
    }

    public function approval()
    {
        return view('main.admin.ticket.approval', [
            'title' => 'Tiket Approval',
            'tickets' => Ticket::search(request('search'))
                ->where('ticket_status_id', 1)
                ->simplePaginate(10),
            'technicians' => Technician::where('technician_status_id', 1)
                ->cursor(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('main.user.ticket.create', [
            'title' => 'Buat Tiket',
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = IdGenerator::generate(['table' => 'tickets', 'length' => 9, 'prefix' => date('ymd'), 'reset_on_prefix_change' => true]);

        $ticket = Ticket::create([
            'id' => $id,
            'employee_id' => auth()->user()->employee->id,
            'category_id' => $request->category,
            'description' => str($request->description)->ucfirst(),
            'ticket_status_id' => 1,
            'solved_at' => $request->solved_at,
        ]);

        if ($request->category == 2) {
            Pengadaan::create([
                'employee_id' => auth()->id(),
                'ticket_id' => $ticket->id,
                'merk' => $request->merk,
                'jenis' => $request->jenis,
                'quantity' => $request->qty,
            ]);
        }

        Notification::send(auth()->user(), new TicketCreatedNotification($ticket));

        return to_route('tickets.show')->with('msg', 'Berhasil Buat Tiket!');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('main.user.ticket.show', [
            'title' => 'Tiket Saya',
            'tickets' => Ticket::search(request('search'))
                ->where('employee_id', auth()->user()->employee->id)
                ->simplePaginate(10),
        ]);
    }

    /**
     * Accept the ticket order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request, Ticket $ticket)
    {
        $ticket->where('id', $ticket->id)
            ->update([
                'ticket_status_id' => 2,
                'technician_id' => $request->technician,
            ]);

        Technician::where('id', $request->technician)
            ->update([
                'technician_status_id' => 2,
            ]);

        return back()->with('msg', 'Berhasil Terima Tiket Permintaan!');
    }

    /**
     * Reject the ticket order.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function reject($id)
    {
        Ticket::where('id', $id)
            ->update([
                'ticket_status_id' => 5,
            ]);

        return back()->with('msg', 'Berhasil Tolak Permintaan Tiket!');
    }

    public function report()
    {
        $tickets = Ticket::with(['category', 'employee', 'pengadaan', 'technician', 'ticket_status']);

        if (request()->only('date_start')) {
            if (request('date_start') != null) {
                $tickets = $tickets->where('updated_at', '>=', request('date_start'));
            }
        }

        if (request()->only('date_end')) {
            if (request('date_end') != null) {
                $tickets = $tickets->where('updated_at', '<=', request('date_end'));
            }
        }

        if (request()->only('technicians')) {
            if (request('technicians') != null) {
                $tickets = $tickets->where('technician_id', request('technicians'));
            }
        }

        if (request()->only('status')) {
            if (request('status') != null) {
                $tickets = $tickets->where('ticket_status_id', request('status'));
            }
        }

        return view('main.user.ticket.report', [
            'title' => 'Laporan Tiket',
            'statuses' => TicketStatus::with(['ticket'])->cursor(),
            'technicians' => Technician::latest()->cursor(),
            'tickets' => $tickets->latest()->simplePaginate(10),
        ]);
    }

    public function dashboard()
    {
        $data = Ticket::select(DB::raw('COUNT(*) as data'));
        $months = Ticket::select(DB::raw('MONTHNAME(created_at) as month'));
        $confirm = Ticket::where('ticket_status_id', 1);
        $process = Ticket::whereIn('ticket_status_id', [2, 3]);
        $solved = Ticket::where('ticket_status_id', 4);
        $rejected = Ticket::where('ticket_status_id', 5);

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
