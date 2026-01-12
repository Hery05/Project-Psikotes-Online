@extends('layouts.hrd')

@section('title','Data Kategori')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 font-weight-bold">
        <i class="fas fa-list text-primary mr-2"></i>
        Data Kategori Soal
    </h4>

    <a href="{{ route('hrd.categories.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Kategori
    </a>
</div>

{{-- ================= CARD ================= --}}
<div class="card border-0 shadow-sm">

    {{-- SEARCH --}}
    <div class="card-header bg-white border-bottom">
        <form method="GET" class="form-inline">
            <div class="input-group input-group-sm" style="max-width:300px">
                <input type="text"
                       name="q"
                       value="{{ request('q') }}"
                       class="form-control"
                       placeholder="Cari kategori...">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th>Nama Kategori</th>
                    <th width="10%" class="text-center">Soal</th>
                    <th width="15%">Durasi</th>
                    <th width="20%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>

                @forelse($categories as $i => $c)
                <tr>
                    <td class="text-center text-muted">
                        {{ $categories->firstItem() + $i }}
                    </td>

                    <td class="font-weight-semibold">
                        {{ $c->name }}
                    </td>

                    <td class="text-center">
                        <span class="badge badge-info">
                            <i class="fas fa-question-circle mr-1"></i>
                            {{ $c->questions_count }}
                        </span>
                    </td>

                    <td>
                        <span class="badge badge-light border">
                            <i class="far fa-clock mr-1"></i>
                            {{ $c->duration }} menit
                        </span>
                    </td>

                    <td class="text-center">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('hrd.questions.index', $c->id) }}"
                               class="btn btn-primary" title="Kelola Soal">
                                <i class="fas fa-list-alt"></i>
                            </a>
                            
                            <a href="{{ route('hrd.categories.edit', $c->id) }}"
                               class="btn btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('hrd.categories.destroy', $c->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="fas fa-folder-open fa-2x mb-2"></i><br>
                        Belum ada kategori
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($categories->hasPages())
    <div class="card-footer bg-white border-top">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Menampilkan {{ $categories->firstItem() }}
                - {{ $categories->lastItem() }}
                dari {{ $categories->total() }} data
            </small>

            {{ $categories->links('pagination::bootstrap-4') }}
        </div>
    </div>
    @endif

</div>

@endsection
