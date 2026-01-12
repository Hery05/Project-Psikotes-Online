@extends('layouts.hrd')

@section('title','Edit Soal Pilihan Ganda')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold mb-0">
        <i class="fas fa-list-ul text-primary mr-2"></i>
        Edit Soal Pilihan Ganda
    </h4>

    <a href="{{ route('hrd.questions.index', $question->category_id) }}"
       class="btn btn-light btn-sm">
        ← Kembali
    </a>
</div>

<form method="POST"
      action="{{ route('hrd.questions.update', $question->id) }}">
    @csrf
    @method('PUT')

    <input type="hidden" name="type" value="choice">

    {{-- SOAL --}}
    <div class="form-group">
        <label>Pertanyaan <span class="text-danger">*</span></label>
        <textarea name="question_text"
                  class="form-control @error('question_text') is-invalid @enderror"
                  rows="3"
                  required>{{ old('question_text', $question->question_text) }}</textarea>
        @error('question_text')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <hr>

    {{-- PILIHAN --}}
    @foreach(['A','B','C','D','E'] as $opt)
    <div class="form-group">
        <label>Opsi {{ $opt }} <span class="text-danger">*</span></label>
        <input type="text"
               name="option_{{ strtolower($opt) }}"
               class="form-control @error('option_'.strtolower($opt)) is-invalid @enderror"
               value="{{ old('option_'.strtolower($opt), $question->options[$opt] ?? '') }}"
               required>

        @error('option_'.strtolower($opt))
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @endforeach

    <hr>

    {{-- KUNCI JAWABAN --}}
    <div class="form-group">
        <label>Kunci Jawaban <span class="text-danger">*</span></label>
        <select name="correct_answer"
                class="form-control @error('correct_answer') is-invalid @enderror"
                required>
            <option value="">-- Pilih --</option>
            @foreach(['A','B','C','D','E'] as $opt)
                <option value="{{ $opt }}"
                    {{ old('correct_answer', $question->correct_answer) === $opt ? 'selected' : '' }}>
                    {{ $opt }}
                </option>
            @endforeach
        </select>

        @error('correct_answer')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- ACTION --}}
    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('hrd.questions.index', $question->category_id) }}"
           class="btn btn-light">
            ← Kembali
        </a>

        <button class="btn btn-primary">
            <i class="fas fa-save mr-1"></i>
            Update Soal
        </button>
    </div>

</form>

@endsection
