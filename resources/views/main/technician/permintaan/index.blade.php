@extends('main.layouts.app')

@section('content')
<main>
    <div class="px-4 container-fluid">
        <h1 class="mt-4">Permintaan Barang</h1>
        <div class="mb-4 card">
            <div class="card-header">
                <i class="fa-solid fa-fw fa-table"></i> Data Permintaan Barang
            </div>
            <div class="card-body px-lg-4">
                <div class="row justify-content-end">
                    <div class="col-6 col-md-4 col-lg-3">
                        <form action="{{ route('technicians.create') }}" method="get" id="searchForm">
                            <div class="mb-2 d-flex">
                                <label for="search" class="my-auto me-2">Cari</label>
                                <input type="text" name="search" id="search" class="form-control form-control-sm" value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th class="col-1">ID Tiket</th>
                                <th class="col-2">Merk</th>
                                <th class="col-2">Jenis</th>
                                <th class="col-1">Qty</th>
                                <th class="col-2">Status</th>
                                <th class="col-4">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permintaan as $permin)
                            <tr class="text-center">
                                <td>{{ $permin->ticket_id }}</td>
                                <td>{{ $permin->merk }}</td>
                                <td>{{ $permin->jenis }}</td>
                                <td>{{ $permin->quantity }}</td>
                                @empty($permin->pengadaan_status_id)
                                <td>Menunggu Diproses</td>
                                @else
                                <td>{{ $permin->pengadaan_status->status }}</td>
                                @endempty
                                @empty ($permin->description)
                                <td>-</td>
                                @else
                                <td>{{ $permin->description }}</td>
                                @endempty
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="6">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="float-end">
                    {{ $permintaan->links() }}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection