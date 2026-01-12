<?php

namespace App\Http\Controllers\Kandidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Question;
use App\Models\Candidate;
use App\Models\CandidateAnswer;
use App\Models\CandidateProgress;
use Carbon\Carbon;

class TestController extends Controller
{
    /* ================= ENTRY ================= */
    public function index()
    {
        $candidateId = session('candidate_id');
        $candidate = Candidate::findOrFail($candidateId);

        if ($candidate->is_finished) {
            return view('kandidat.finished');
        }

        $category = Category::whereDoesntHave('progress', function ($q) use ($candidateId) {
            $q->where('candidate_id', $candidateId)
              ->whereIn('status', ['finished', 'cheated']);
        })->orderBy('id')->first();

        if (!$category) {
            $candidate->update(['is_finished' => 1]);
            return view('kandidat.finished');
        }

        return view('kandidat.dashboard', compact('category'));
    }

    /* ================= START TEST ================= */
    public function start(Category $category)
    {
        $candidateId = session('candidate_id');

        $progress = CandidateProgress::firstOrCreate(
            [
                'candidate_id' => $candidateId,
                'category_id'  => $category->id,
            ],
            [
                'status'      => 'pending',
                'started_at'  => now(),
                'cheat_count' => 0,
            ]
        );

        // jika data lama & started_at kosong
        if (!$progress->started_at) {
            $progress->update(['started_at' => now()]);
        }

        return redirect()->route('candidate.test.show', [
            'category' => $category->id,
            'page' => 1
        ]);
    }

    /* ================= SHOW SOAL ================= */
    public function show(Category $category, $page)
    {
        $candidateId = session('candidate_id');

        $progress = CandidateProgress::where([
            'candidate_id' => $candidateId,
            'category_id'  => $category->id,
            'status'       => 'pending'
        ])->first();

        if (!$progress || !$progress->started_at) {
            return redirect()->route('candidate.test.index');
        }

        $endTime = Carbon::parse($progress->started_at)
            ->addMinutes($category->duration);

        $remainingSeconds = now()->diffInSeconds($endTime, false);

        if ($remainingSeconds <= 0) {
            $progress->update([
                'status' => 'finished',
                'ended_at' => now()
            ]);
            return redirect()->route('candidate.test.index');
        }

        $questions = $category->questions()->orderBy('id')->get();
        $totalQuestions = $questions->count();

        $page = max(1, min((int)$page, $totalQuestions));
        $question = $questions[$page - 1];

        $candidateAnswer = CandidateAnswer::where([
            'candidate_id' => $candidateId,
            'question_id'  => $question->id
        ])->first();

        return view('kandidat.test', compact(
            'category',
            'question',
            'candidateAnswer',
            'page',
            'totalQuestions',
            'remainingSeconds'
        ));
    }

    /* ================= SUBMIT ================= */
    public function submit(Request $request, Category $category)
    {
        $candidateId = session('candidate_id');

        foreach ($request->answers ?? [] as $questionId => $answer) {
            CandidateAnswer::updateOrCreate(
                [
                    'candidate_id' => $candidateId,
                    'question_id'  => $questionId
                ],
                [
                    'category_id' => $category->id,
                    'answer'      => $answer
                ]
            );
        }

        $currentPage = (int) $request->current_page;
        $nextPage = $currentPage + 1;
        $total = $category->questions()->count();

        if ($nextPage > $total) {
            CandidateProgress::where([
                'candidate_id' => $candidateId,
                'category_id'  => $category->id
            ])->update([
                'status' => 'finished',
                'ended_at' => now()
            ]);

            return redirect()->route('candidate.test.index');
        }

        return redirect()->route('candidate.test.show', [
            'category' => $category->id,
            'page' => $nextPage
        ]);
    }

    /* ================= AUTOSAVE ================= */
    public function autosave(Request $request)
    {
        CandidateAnswer::updateOrCreate(
            [
                'candidate_id' => session('candidate_id'),
                'question_id'  => $request->question_id
            ],
            [
                'category_id' => $request->category_id,
                'answer'      => $request->answer
            ]
        );

        return response()->json(['status' => 'saved']);
    }

    /* ================= CHEAT ================= */
    public function trackCheat(Request $request)
    {
        $progress = CandidateProgress::where([
            'candidate_id' => session('candidate_id'),
            'category_id'  => $request->category_id,
            'status'       => 'pending'
        ])->first();

        if (!$progress) {
            return response()->json(['status' => 'ignored']);
        }

        $progress->increment('cheat_count');

        if ($progress->cheat_count >= 3) {
            $progress->update([
                'status' => 'cheated',
                'ended_at' => now()
            ]);
            return response()->json(['status' => 'cheated']);
        }

        return response()->json(['status' => 'warning']);
    }
}
