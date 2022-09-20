<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use App\Models\Technician;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Notifications\TicketUpdatedNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('main.technician.dashboard.index', [
            'title' => 'Dashboard',
            'ticket' => Ticket::where('technician_id', auth()->user()->technician->id)
                ->count(),
            'ticket_solved' => Ticket::where('technician_id', auth()->user()->technician->id)
                ->where('ticket_status_id', 3)
                ->count(),
            'ticket_process' => Ticket::where('technician_id', auth()->user()->technician->id)
                ->where('ticket_status_id', 2)
                ->count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('main.technician.permintaan.index', [
            'title' => 'Permintaan Barang',
            'tickets' => Ticket::where('technician_id', auth()->user()->technician->id)
                ->where('ticket_status_id', 2)
                ->cursor(),
            'permintaan' => Pengadaan::search(request('search'))
                ->where('technician_id', auth()->user()->technician->id)
                ->simplePaginate(10),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('main.technician.ticket.show', [
            'title' => 'Tiket',
            'tickets' => Ticket::search(request('search'))
                ->where('technician_id', auth()->user()->technician->id)
                ->where('ticket_status_id', 2)
                ->simplePaginate(10),
            'statuses' => TicketStatus::where('id', 3)
                ->cursor(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        $ticket->update([
            'ticket_status_id' => $request->status,
        ]);

        Notification::send($ticket->employee->user, new TicketUpdatedNotification($ticket));

        Technician::where('id', auth()->user()->technician->id)->update([
            'technician_status_id' => 1,
        ]);

        return to_route('technicians.show')->with('msg', 'Status Tiket Berhasil Diperbarui!');
    }

    public function report()
    {
        $tickets = Ticket::with(['category', 'employee', 'technician', 'ticket_status'])
            ->where('technician_id', auth()->user()->technician->id)
            ->where('ticket_status_id', 3);

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

        return view('main.technician.report.index', [
            'title' => 'Laporan',
            'tickets' => $tickets->simplePaginate(10),
        ]);
    }

    /**
     * Handle the report in .pdf file
     * 
     * @param  $start
     * @param  $end
     * @return \Barryvdh\DomPDF\Facade\Pdf
     */
    public function pdf($start, $end)
    {
        $pdf = Pdf::loadView('main.technician.report.pdf', [
            'title' => date('ymd') . '_technician_report.pdf',
            'tickets' => Ticket::with(['category', 'employee', 'technician', 'ticket_status'])
                ->where('technician_id', auth()->user()->technician->id)
                ->where('ticket_status_id', 3)
                ->whereBetween('updated_at', [$start, $end])
                ->get(),
        ])->setPaper('legal', 'landscape');

        return $pdf->stream(date('ymd') . '_technician_report.pdf');
    }
}
