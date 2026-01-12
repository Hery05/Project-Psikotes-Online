@extends('layouts.hrd')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3">Update Skor Essay: {{ $candidate->name }}</h3>
    <p>Kategori: <strong>{{ $category->name }}</strong></p>
    <hr>

    <form action="{{ route('hrd.reports.updateEssayScores', $candidate->id) }}" method="POST">
        @csrf
        @foreach($answers as $answer)
            @if($answer->question->type === 'essay')
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <p><strong>{{ $answer->question->question_text }}</strong></p>
                        @if($answer->question->question_image)
                            <img src="{{ asset('storage/' . $answer->question->question_image) }}" 
                                 class="img-fluid mb-2" style="max-width:200px;">
                        @endif
                        <p>Jawaban Kandidat:</p>
                        <textarea class="form-control mb-2" rows="3" readonly>{{ $answer->answer }}</textarea>
                        <label>Skor Essay (0-5)</label>
                        <input type="number" class="form-control w-25" name="scores[{{ $answer->id }}]" 
                               value="{{ $answer->score ?? 0 }}" min="0" max="5">
                    </div>
                </div>
            @endif
        @endforeach

        <button type="submit" class="btn btn-success w-100 mb-3">Simpan Skor Essay</button>
        <a href="{{ route('hrd.reports.show', $candidate->id) }}" class="btn btn-secondary w-100">Kembali ke Hasil</a>
    </form>

</div>
@endsection
