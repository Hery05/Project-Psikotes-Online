<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Category;
use App\Models\CandidateAnswer;
use App\Models\CandidateProgress;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // ================= LIST LAPORAN =================
    public function index()
    {
        $candidates = Candidate::where('is_finished', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('hrd.reports.index', compact('candidates'));
    }

    // ================= DETAIL LAPORAN =================
    public function show($candidateId)
    {
        $candidate = Candidate::findOrFail($candidateId);
        $categories = Category::with('questions')->orderBy('id')->get();

        $results = [];
        $totalWeightedScore = 0;
        $totalWeight = 0;

        foreach ($categories as $category) {

            $progress = CandidateProgress::where([
                'candidate_id' => $candidate->id,
                'category_id'  => $category->id,
            ])->first();

            $answers = CandidateAnswer::where('candidate_id', $candidate->id)
                ->where('category_id', $category->id)
                ->get();

            $pgScore = 0;
            $pgCount = 0;

            $essayScore = 0;
            $essayCount = 0;

            foreach ($category->questions as $q) {
                $answer = $answers->where('question_id', $q->id)->first();

                if ($q->type === 'choice') {
                    $pgCount++;
                    $pgScore += $answer->score ?? 0;
                }

                if ($q->type === 'essay') {
                    $essayCount++;
                    $essayScore += $answer->score ?? 0;
                }
            }

            $pgDisplay = $pgCount > 0 ? "$pgScore/$pgCount" : "0/0";
            $essayDisplay = $essayCount > 0 ? "$essayScore/$essayCount" : "0/0";

            $percentPG = $pgCount > 0 ? round(($pgScore / $pgCount) * 100, 2) : 0;
            $percentEssay = $essayCount > 0 ? round(($essayScore / $essayCount) * 100, 2) : 0;

            // Bobot dihitung dari PG + essay
            $weightedScore = round((($percentPG + $percentEssay) / 2 * $category->weight) / 100, 2);

            $results[] = [
                'category_id'    => $category->id,
                'category_name'  => $category->name,
                'progress'       => $progress ? $progress->toArray() : ['status' => 'not_started'],
                'pg_score'       => $pgScore,
                'pg_count'       => $pgCount,
                'pg_display'     => $pgDisplay,
                'essay_score'    => $essayScore,
                'essay_count'    => $essayCount,
                'essay_display'  => $essayDisplay,
                'weighted_score' => $weightedScore,
                'weight'         => $category->weight,
                'passing_score'  => $category->passing_score,
                'passed'         => ($percentPG + $percentEssay) / 2 >= $category->passing_score,
                'answers'        => $answers,
            ];

            $totalWeightedScore += $weightedScore;
            $totalWeight += $category->weight;
        }

        $finalScore = $totalWeight > 0 ? round($totalWeightedScore / $totalWeight * 100, 2) : 0;
        $recommendation = $finalScore >= 75 ? 'Lulus' : 'Tidak Lulus';

        return view('hrd.reports.show', compact('candidate', 'results', 'finalScore', 'recommendation'));
    }

    // ================= EDIT & UPDATE ESSAY =================
    public function editEssay($candidateId, $categoryId)
    {
        $candidate = Candidate::findOrFail($candidateId);
        $category = Category::findOrFail($categoryId);

        $answers = CandidateAnswer::with('question')
            ->where('candidate_id', $candidateId)
            ->where('category_id', $categoryId)
            ->whereHas('question', function ($q) {
                $q->where('type', 'essay');
            })->get();

        return view('hrd.reports.edit_essay', compact('candidate', 'category', 'answers'));
    }

    public function updateEssayScores(Request $request, $candidateId)
    {
        foreach ($request->input('scores', []) as $answerId => $score) {
            CandidateAnswer::where('id', $answerId)->update(['score' => $score]);
        }

        return redirect()->route('hrd.reports.show', $candidateId)
            ->with('success', 'Skor essay berhasil diperbarui');
    }

    // ================= EXPORT PDF =================
    public function exportPdf($candidateId)
    {
        $candidate = Candidate::findOrFail($candidateId);

        $categories = Category::with('questions')->orderBy('id')->get();
        $results = [];
        $totalWeightedScore = 0;
        $totalWeight = 0;

        foreach ($categories as $category) {

            $progress = CandidateProgress::where([
                'candidate_id' => $candidateId,
                'category_id'  => $category->id,
            ])->first();

            $status = $progress->status ?? 'not_started';
            $cheatCount = $progress->cheat_count ?? 0;

            // Ambil jawaban kandidat
            $answers = CandidateAnswer::where('candidate_id', $candidateId)
                ->where('category_id', $category->id)
                ->get();

            $totalPg = $category->questions->where('type', 'choice')->count();
            $pgScore = 0;

            if ($totalPg > 0) {
                foreach ($category->questions->where('type', 'choice') as $q) {
                    $ans = $answers->where('question_id', $q->id)->first();
                    $pgScore += $ans->score ?? 0;
                }
            }

            $percent = $totalPg > 0 ? round(($pgScore / $totalPg) * 100, 2) : 0;
            $weightedScore = round(($percent * $category->weight) / 100, 2);

            $totalWeightedScore += $weightedScore;
            $totalWeight += $category->weight;

            $results[] = [
                'category_id'    => $category->id,
                'category_name'  => $category->name,
                'status'         => $status,
                'score'          => $pgScore,
                'question_count' => $totalPg,
                'percent'        => $percent,
                'weight'         => $category->weight,
                'weighted_score' => $weightedScore,
                'passing_score'  => $category->passing_score,
                'passed'         => $percent >= $category->passing_score,
            ];
        }

        $finalScore = $totalWeight > 0 ? round($totalWeightedScore / $totalWeight, 2) : 0;
        $recommendation = $finalScore >= 70 ? 'Lulus' : 'Tidak Lulus'; // misal ambang 70%

        $pdf = Pdf::loadView('hrd.reports.pdf', compact(
            'candidate',
            'results',
            'finalScore',
            'recommendation'
        ))->setPaper('A4', 'portrait');

        return $pdf->download('Laporan_Psikotes_' . $candidate->name . '.pdf');
    }
}
