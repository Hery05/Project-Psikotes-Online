@extends('layouts.hrd')

@section('title', 'Master Kandidat')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="fas fa-users"></i> Master Kandidat
        </h4>

        <a href="{{ route('hrd.candidates.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kandidat
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th width="15%">Status Tes</th>
                        <th width="15%">Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($candidates as $c)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $c->name }}</td>
                            <td>{{ $c->email }}</td>
                            <td>
                                @if($c->is_finished)
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum</span>
                                @endif
                            </td>
                            <td>{{ $c->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada kandidat
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
