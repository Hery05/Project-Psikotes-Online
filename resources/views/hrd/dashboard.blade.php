@extends('layouts.hrd')

@section('title','Dashboard HRD')

@section('content')
<div class="container-fluid">

    {{-- ===== RINGKASAN ===== --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Kandidat</h6>
                    <h3>{{ $totalCandidates }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Selesai Tes</h6>
                    <h3 class="text-success">{{ $finishedCandidates }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Belum Selesai</h6>
                    <h3 class="text-warning">{{ $ongoingCandidates }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== TABEL KANDIDAT ===== --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <strong>Daftar Kandidat</strong>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status Tes</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($candidates as $i => $c)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->email }}</td>
                        <td>
                            @if($c->is_finished)
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">Belum</span>
                            @endif
                        </td>
                        <td>
                            @if($c->is_finished)
                                <a href="{{ route('hrd.reports.show',$c->id) }}"
                                   class="btn btn-sm btn-primary">
                                    Lihat Hasil
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
