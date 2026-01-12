@extends('layouts.hrd')

@section('title','Tambah Soal Uraian')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-4 font-weight-bold">
        <i class="fas fa-pen text-warning mr-2"></i>
        Soal Uraian
    </h4>

    <a href="{{ route('hrd.questions.index',$category->id) }}"
       class="btn btn-light btn-sm">
        ← Kembali
    </a>
</div>

<form method="POST"
      action="{{ route('hrd.questions.store',$category->id) }}"
      enctype="multipart/form-data">

@csrf

<input type="hidden" name="type" value="essay">

<div class="form-group">
    <label>Pertanyaan <span class="text-danger">*</span></label>
    <textarea name="question_text"
              class="form-control"
              rows="4"
              required></textarea>
</div>

{{-- GAMBAR SOAL --}}
<div class="form-group">
    <label class="font-weight-semibold">
        Gambar Soal (Opsional)
    </label>
        <input type="file"
            name="question_image" class="form-control-file @error('question_image') is-invalid @enderror" accept="image/*">
                <small class="form-text text-muted">
                    Format JPG / PNG, maksimal 2MB
                </small>
                @error('question_image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
</div>
    <hr>
<div class="form-group">
    <label>Kunci Jawaban (opsional)</label>
    <textarea name="correct_answer"
              class="form-control"
              rows="3"></textarea>
</div>

<button class="btn btn-warning">
    <i class="fas fa-save mr-1"></i> Simpan
</button>

</form>
@endsection
