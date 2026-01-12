@extends('layouts.hrd')

@section('title','Daftar Soal')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="font-weight-bold mb-1">
            <i class="fas fa-question-circle text-primary mr-2"></i>
            Daftar Soal
        </h4>
        <span class="text-muted">
            Kategori:
            <strong class="text-dark">{{ $category->name }}</strong>
        </span>
    </div>

    <a href="{{ route('hrd.questions.choose', $category->id) }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus mr-1"></i>
            Tambah Soal
    </a>

</div>

{{-- ================= CARD ================= --}}
<div class="card shadow-sm border-0">

    {{-- ================= TABLE ================= --}}
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th width="60">#</th>
                    <th>Soal</th>
                    <th width="120">Tipe</th>
                    <th width="160" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($questions as $q)
                    <tr>
                        <td>
                            {{ $questions->firstItem() + $loop->index }}
                        </td>

                        <td>
                            {{ Str::limit($q->question_text, 80) }}
                            @if($q->question_image)
                                <div>
                                    <small class="text-muted">
                                        <i class="far fa-image"></i> Soal bergambar
                                    </small>
                                </div>
                            @endif
                        </td>

                        <td>
                             <span class="badge badge-{{ $q->type === 'choice' ? 'info' : 'warning' }}">
                                {{ $q->type === 'choice' ? 'Pilihan Ganda' : 'Uraian' }}
                            </span>
                        </td>

                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('hrd.questions.edit', $q->id) }}"
                                    class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                </a>
                                
                                <a href="{{ route('hrd.questions.preview', $q->id) }}"
                                    class="btn btn-info btn-sm" title="Preview">
                                        <i class="fas fa-eye"></i>
                                </a>

                                <form action="{{ route('hrd.questions.destroy', $q->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Hapus soal ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                       <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            Belum ada soal pada kategori ini
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================= PAGINATION ================= --}}
    @if($questions->hasPages())
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Menampilkan {{ $questions->firstItem() }}
                - {{ $questions->lastItem() }}
                dari {{ $questions->total() }} soal
            </small>

            {{ $questions->links('pagination::bootstrap-4') }}
        </div>
    @endif

</div>

{{-- ================= FOOTER ================= --}}
<div class="mt-3">
    <a href="{{ route('hrd.categories.index') }}"
       class="btn btn-light btn-sm">
        ← Kembali ke Kategori
    </a>
</div>

@endsection
