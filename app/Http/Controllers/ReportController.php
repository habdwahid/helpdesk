<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($start, $end, $status = null)
    {
        $tickets = Ticket::with(['category', 'employee', 'technician', 'ticket_status']);

        if ($status === null) {
            $tickets = $tickets->whereBetween('created_at', [$start, $end]);
        } else {
            $tickets = $tickets->where('ticket_status_id', $status)
                ->whereBetween('created_at', [$start, $end]);
        }

        $tickets = $tickets->cursor();

        $title = date('ymd') . '_helpdesk_report.pdf';

        $pdf = Pdf::loadView('main.pdf.ticket-pdf', compact('title', 'tickets'))
            ->setPaper('legal', 'landscape');

        return $pdf->stream($title);
    }

    public function technician($start, $end, $technician = null, $status = null)
    {
        $tickets = Ticket::with(['category', 'employee', 'technician', 'ticket_status']);

        if ($technician === null) {
            $tickets = $tickets->whereBetween('created_at', [$start, $end]);
        } else {
            $tickets = $tickets->whereBetween('created_at', [$start, $end])
                ->where('technician_id', $technician);
        }

        if ($status === null) {
            $tickets = $tickets->whereBetween('created_at', [$start, $end]);
        } else {
            $tickets = $tickets->where('ticket_status_id', $status)
                ->whereBetween('created_at', [$start, $end]);
        }

        $tickets = $tickets->cursor();

        $title = date('ymd') . '_helpdesk_report.pdf';

        $pdf = Pdf::loadView('main.pdf.ticket-pdf', compact('title', 'tickets'))
            ->setPaper('legal', 'landscape');

        return $pdf->stream($title);
    }
}
