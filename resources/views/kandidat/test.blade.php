@extends('layouts.kandidat')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h6>{{ $category->name }}</h6>
        <span class="badge bg-danger" id="timer">00:00</span>
    </div>

    <form method="POST" action="{{ route('candidate.test.submit', $category->id) }}">
        @csrf

        <p><b>Soal {{ $page }} / {{ $totalQuestions }}</b></p>
        <p>{{ $question->question_text }}</p>

        {{-- PILIHAN GANDA --}}
        @if($question->type === 'choice')
            @foreach($question->options as $key => $text)
                <div class="form-check">
                    <input class="form-check-input"
                        type="radio"
                        name="answers[{{ $question->id }}]"
                        value="{{ $key }}"
                        @checked($candidateAnswer?->answer === $key)
                        onchange="autosave('{{ $key }}')">
                    <label class="form-check-label">
                        {{ $key }}. {{ $text }}
                    </label>
                </div>
            @endforeach
        @else
        {{-- URAIAN --}}
            <textarea class="form-control"
                rows="4"
                onkeyup="autosave(this.value)">{{ $candidateAnswer->answer ?? '' }}</textarea>
        @endif

        <input type="hidden" name="current_page" value="{{ $page }}">

        <button class="btn btn-primary mt-3">
            {{ $page == $totalQuestions ? 'Selesai' : 'Lanjut' }}
        </button>
    </form>
</div>

<script>
/* ================= TIMER ================= */
let remaining = {{ $remainingSeconds }};
const timer = document.getElementById('timer');

setInterval(() => {
    if (remaining <= 0) {
        location.href = "{{ route('candidate.test.index') }}";
    }
    remaining--;
    timer.innerText =
        Math.floor(remaining / 60) + ':' + String(remaining % 60).padStart(2, '0');
}, 1000);

/* ================= AUTOSAVE ================= */
function autosave(answer) {
    fetch("{{ route('candidate.autosave') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            question_id: {{ $question->id }},
            category_id: {{ $category->id }},
            answer: answer
        })
    });
}

/* ================= DISABLE BACK ================= */
history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.pushState(null, null, location.href);
};
</script>
@endsection
