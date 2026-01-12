@extends('layouts.hrd')

@section('title','Tambah Soal Pilihan Ganda')

@section('content')

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold mb-0">
        <i class="fas fa-list-ul text-primary mr-2"></i>
        Soal Pilihan Ganda
    </h4>

    <a href="{{ route('hrd.questions.index',$category->id) }}"
       class="btn btn-light btn-sm">
        ← Kembali
    </a>
</div>

{{-- CARD --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">

        <form method="POST"
              action="{{ route('hrd.questions.store',$category->id) }}"
              enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="type" value="choice">

            {{-- PERTANYAAN --}}
            <div class="form-group">
                <label class="font-weight-semibold">
                    Pertanyaan <span class="text-danger">*</span>
                </label>
                <textarea name="question_text"
                          class="form-control @error('question_text') is-invalid @enderror"
                          rows="3"
                          placeholder="Tuliskan pertanyaan atau deskripsi gambar..."
                          required>{{ old('question_text') }}</textarea>

                @error('question_text')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- OPSI A–E --}}
            @foreach(['A','B','C','D','E'] as $opt)
            <div class="form-group">
                <label class="font-weight-semibold">
                    Opsi {{ $opt }} <span class="text-danger">*</span>
                </label>
                <input type="text"
                       name="option_{{ strtolower($opt) }}"
                       class="form-control @error('option_'.strtolower($opt)) is-invalid @enderror"
                       value="{{ old('option_'.strtolower($opt)) }}"
                       required>

                @error('option_'.strtolower($opt))
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @endforeach

            {{-- KUNCI JAWABAN --}}
            <div class="form-group">
                <label class="font-weight-semibold">
                    Kunci Jawaban <span class="text-danger">*</span>
                </label>
                <select name="correct_answer"
                        class="form-control @error('correct_answer') is-invalid @enderror"
                        required>
                    <option value="">-- Pilih Jawaban Benar --</option>
                    @foreach(['A','B','C','D','E'] as $k)
                        <option value="{{ $k }}"
                            {{ old('correct_answer') === $k ? 'selected' : '' }}>
                            {{ $k }}
                        </option>
                    @endforeach
                </select>

                @error('correct_answer')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- ACTION --}}
            <div class="text-right mt-4">
                <button class="btn btn-primary text-right">
                    <i class="fas fa-save mr-1"></i>
                    Simpan Soal
                </button>
            </div>

        </form>

    </div>
</div>

@endsection