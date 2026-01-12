@extends('layouts.hrd')

@section('title','Edit Soal Uraian')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold">
        <i class="fas fa-pen text-warning mr-2"></i>
        Edit Soal Uraian
    </h4>

    <a href="{{ route('hrd.questions.index',$question->category_id) }}"
       class="btn btn-light btn-sm">
        ← Kembali
    </a>
</div>

<form method="POST"
      action="{{ route('hrd.questions.update',$question->id) }}"
      enctype="multipart/form-data">
@csrf
@method('PUT')

<input type="hidden" name="type" value="essay">

{{-- PERTANYAAN --}}
<div class="form-group">
    <label>Pertanyaan <span class="text-danger">*</span></label>
    <textarea name="question_text"
              class="form-control @error('question_text') is-invalid @enderror"
              rows="4"
              required>{{ old('question_text',$question->question_text) }}</textarea>
    @error('question_text')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- GAMBAR --}}
<div class="form-group">
    <label>Gambar Soal (Opsional)</label>

    @if($question->question_image)
        <div class="mb-2">
            <img src="{{ asset('storage/'.$question->question_image) }}"
                 class="img-fluid rounded border"
                 style="max-height:180px">
        </div>
    @endif

    <input type="file"
           name="question_image"
           class="form-control-file @error('question_image') is-invalid @enderror"
           accept="image/*">

    <small class="text-muted">
        JPG / PNG, maksimal 2MB
    </small>

    @error('question_image')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<hr>

{{-- KUNCI URAIAN --}}
<div class="form-group">
    <label>Jawaban Acuan (Opsional)</label>
    <textarea name="correct_answer"
              class="form-control"
              rows="3">{{ old('correct_answer',$question->correct_answer) }}</textarea>
</div>

<hr>

<div class="d-flex justify-content-between">
    <a href="{{ route('hrd.questions.index',$question->category_id) }}"
       class="btn btn-light">
        ← Kembali
    </a>

    <button class="btn btn-warning">
        <i class="fas fa-save mr-1"></i> Update Soal
    </button>
</div>

</form>
@endsection
