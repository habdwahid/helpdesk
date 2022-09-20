<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title }}</title>
    <style>
        html {
            margin: 0px;
        }

        body {
            font-size: 12pt;
            line-height: 1.5;
        }

        table {
            border-spacing: 0;
            margin: auto;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10 5;
        }
    </style>
</head>

<body style="margin: 2.54cm;">
    <div style="margin-bottom: 2rem;">
        <div style="text-align: center;">
            <p style="font-size: 14pt; font-weight: bold;">LAPORAN KELUHAN SISTEM INFORMASI HELPDESK</p>
            <p style="font-size: 14pt; font-weight: bold;">TEKNISI</p>
        </div>
        <div style="text-align: right; line-height: 1pt;">
            <p>{{ now()->isoFormat('dddd, DD MMMM Y') }}</p>
            <p>Printed by : {{ auth()->user()->name }}</p>
        </div>
        <p style="font-weight: bold;">Data Keluhan</p>
        <table>
            <thead>
                <tr style="text-align: center;">
                    <th>No</th>
                    <th>ID</th>
                    <th>Pelapor</th>
                    <th>Jabatan</th>
                    <th>Bidang</th>
                    <th>Sub Bidang</th>
                    <th>Kategori</th>
                    <th>Tanggal Pelaporan</th>
                    <th>Tanggal Selesai</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tickets as $ticket)
                <tr style="text-align: center; vertical-align: middle;">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ticket->id }}</td>
                    <td style="text-align: left;">{{ $ticket->employee->user->name }}</td>
                    <td>{{ $ticket->employee->position->position }}</td>
                    <td>{{ ((empty($ticket->employee->sub_department_id)) ? '-' : $ticket->employee->sub_department->department->department) }}</td>
                    <td>{{ ((empty($ticket->employee->sub_department_id)) ? '-' : $ticket->employee->sub_department->sub_department) }}</td>
                    <td>{{ $ticket->category->category }}</td>
                    <td>{{ $ticket->created_at }}</td>
                    <td>{{ $ticket->ticket_status->status }}</td>
                    <td>{!! nl2br($ticket->description) !!}</td>
                </tr>
                @empty
                <tr style="text-align: center;">
                    <td colspan="10">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>