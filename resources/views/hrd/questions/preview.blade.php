@extends('layouts.hrd')

@section('title','Preview Soal')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold">
        <i class="fas fa-eye text-info mr-2"></i>
        Preview Soal
    </h4>

    <a href="{{ route('hrd.questions.index', $question->category_id) }}"
       class="btn btn-light btn-sm">
        ← Kembali
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        {{-- TIPE --}}
        <span class="badge badge-{{ $question->type === 'choice' ? 'primary' : 'warning' }}">
            {{ $question->type === 'choice' ? 'Pilihan Ganda' : 'Uraian' }}
        </span>

        <hr>

        {{-- PERTANYAAN --}}
        <div class="mb-3">
            <h5 class="font-weight-semibold">Pertanyaan</h5>
            <p class="mb-0">{{ $question->question_text }}</p>
        </div>

        {{-- GAMBAR --}}
        @if($question->question_image)
            <div class="mb-4">
                <img src="{{ asset('storage/'.$question->question_image) }}"
                     class="img-fluid rounded border"
                     style="max-height:300px">
            </div>
        @endif

        {{-- PILIHAN GANDA --}}
        @if($question->type === 'choice' && is_array($question->options))
            <h6 class="font-weight-bold mb-2">Pilihan Jawaban</h6>

            <ul class="list-group mb-3">
                @foreach($question->options as $key => $value)
                    <li class="list-group-item
                        {{ $question->correct_answer === $key ? 'list-group-item-success' : '' }}">
                        <strong>{{ $key }}.</strong> {{ $value }}

                        @if($question->correct_answer === $key)
                            <span class="badge badge-success float-right">
                                Kunci
                            </span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- URAIAN --}}
        @if($question->type === 'essay')
            <h6 class="font-weight-bold mb-2">Jawaban Kandidat</h6>
            <textarea class="form-control" rows="4" disabled
                placeholder="Jawaban kandidat akan diisi di sini..."></textarea>

            @if($question->correct_answer)
                <div class="alert alert-warning mt-3">
                    <strong>Kunci Jawaban:</strong><br>
                    {{ $question->correct_answer }}
                </div>
            @endif
        @endif

    </div>
</div>

@endsection
