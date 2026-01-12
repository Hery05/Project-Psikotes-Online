@extends('layouts.hrd')

@section('title','Laporan Psikotes')

@section('content')
<div class="container-fluid">

    {{-- ================= HEADER ================= --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="mb-0">Laporan Hasil Psikotes</h5>
            <small class="text-muted">
                Daftar kandidat yang telah menyelesaikan tes
            </small>
        </div>
    </div>

    {{-- ================= TABEL LAPORAN ================= --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <strong>Daftar Kandidat</strong>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($candidates as $i => $c)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->email }}</td>
                        <td>
                            <span class="badge bg-success">
                                Selesai
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('hrd.reports.show', $c->id) }}"
                               class="btn btn-sm btn-primary">
                                Lihat Laporan
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Belum ada kandidat yang menyelesaikan tes
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
