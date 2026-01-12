@extends('layouts.hrd')

@section('content')
<div class="container">
    <h2 class="mb-4">Laporan Kandidat: {{ $candidate->name }}</h2>
    <p>Email: {{ $candidate->email }}</p>
    <p>Tanggal Tes Selesai: {{ $candidate->updated_at->format('d M Y H:i') }}</p>

    <div class="mb-3">
        <a href="{{ route('hrd.reports.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('hrd.reports.pdf', $candidate->id) }}" class="btn btn-primary">Export PDF</a>
    </div>

    @foreach($results as $i => $r)
        @php
            $status = $r['progress']['status'] ?? 'not_started';
            $badge = match($status) {
                'finished' => 'bg-success',
                'pending' => 'bg-warning text-dark',
                'cheated' => 'bg-danger',
                'empty' => 'bg-secondary',
                default => 'bg-light text-dark',
            };
        @endphp

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center" 
                 data-bs-toggle="collapse" 
                 href="#category-{{ $r['category_id'] }}" 
                 style="cursor: pointer;">
                <div>
                    <strong>{{ $i+1 }}. {{ $r['category_name'] }}</strong>
                    <span class="badge {{ $badge }}">{{ ucfirst($status) }}</span>
                </div>
                <div>
                    Weighted Score: {{ $r['weighted_score'] }} | PG: {{ $r['pg_display'] }} | Essay: {{ $r['essay_display'] }}
                </div>
            </div>
            <div id="category-{{ $r['category_id'] }}" class="collapse">
                <div class="card-body p-0">
                    @if($r['answers']->count() > 0)
                        <table class="table table-bordered mb-0">
                            <thead class="table-secondary">
                                <tr>
                                    <th>#</th>
                                    <th>Pertanyaan</th>
                                    <th>Jawaban Kandidat</th>
                                    <th>Jawaban Benar</th>
                                    <th>Skor</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($r['answers'] as $ans)
                                    <tr @if($ans->question->type === 'choice') 
                                            class="{{ $ans->score ? 'table-success' : 'table-danger' }}" 
                                        @endif>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ans->question->question_text }}</td>
                                        <td>{{ $ans->answer ?? '-' }}</td>
                                        <td>{{ $ans->question->type === 'choice' ? $ans->question->correct_answer : '-' }}</td>
                                        <td>
                                            @if($ans->question->type === 'essay')
                                                <input type="number" min="0" max="1" value="{{ $ans->score ?? 0 }}" 
                                                       class="form-control form-control-sm essay-score" 
                                                       data-answer-id="{{ $ans->id }}">
                                            @else
                                                {{ $ans->score }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($ans->question->type === 'choice')
                                                <a href="{{ route('hrd.questions.preview', $ans->question->id) }}" 
                                                   class="btn btn-sm btn-info">Preview Soal</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="p-2">Belum ada jawaban.</p>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    <div class="card mt-3">
        <div class="card-body">
            <h5>Total Skor Bobot Akhir: {{ $finalScore }}</h5>
            <h5>Rekomendasi: <span class="fw-bold">{{ $recommendation }}</span></h5>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.essay-score').forEach(input => {
    input.addEventListener('change', function() {
        const answerId = this.dataset.answerId;
        const score = this.value;

        fetch("{{ route('hrd.reports.updateEssayScores', $candidate->id) }}", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ scores: { [answerId]: score } })
        }).then(res => res.json())
          .then(data => {
              if(data.status === 'success'){
                  alert('Skor essay berhasil diperbarui');
                  location.reload();
              }
          });
    });
});
</script>
@endsection
