<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Category;
use App\Models\CandidateAnswer;
use App\Models\CandidateProgress;

class DashboardController extends Controller
{
    /* =================================================
     * DASHBOARD UTAMA HRD
     * ================================================= */
    public function index()
    {
        $totalCandidates = Candidate::count();

        $finishedCandidates = Candidate::where('is_finished', 1)->count();

        $ongoingCandidates = $totalCandidates - $finishedCandidates;

        $candidates = Candidate::orderBy('created_at', 'desc')->get();

        return view('hrd.dashboard', compact(
            'totalCandidates',
            'finishedCandidates',
            'ongoingCandidates',
            'candidates'
        ));
    }

    /* =================================================
     * DETAIL HASIL KANDIDAT
     * ================================================= */
    public function result($candidateId)
    {
        $candidate = Candidate::findOrFail($candidateId);
        $categories = Category::orderBy('id')->get();

        $results = [];
        $finalScore = 0;
        $totalWeight = 0;

        foreach ($categories as $category) {

            $progress = CandidateProgress::where([
                'candidate_id' => $candidateId,
                'category_id'  => $category->id,
            ])->first();

            $status = $progress->status ?? 'not_started';
            $cheatCount = $progress->cheat_count ?? 0;
            $score = null;

            // Hitung nilai hanya jika kategori selesai
            if ($progress && $progress->status === 'finished') {

                $totalPg = $category->questions()
                    ->where('type', 'choice')
                    ->count();

                if ($totalPg > 0) {

                    $correct = CandidateAnswer::where('candidate_id', $candidateId)
                        ->where('category_id', $category->id)
                        ->sum('score');

                    $score = round(($correct / $totalPg) * 100);

                    // Akumulasi nilai akhir berbobot
                    $finalScore += ($score * $category->weight);
                    $totalWeight += $category->weight;
                } else {
                    $score = 0;
                }
            }

            $results[] = [
                'category' => $category,
                'status'   => $status,
                'score'    => $score,
                'weight'   => $category->weight,
                'cheat'    => $cheatCount,
            ];
        }

        $finalScore = $totalWeight > 0
            ? round($finalScore / $totalWeight)
            : null;

        return view('hrd.reports.show', compact(
            'candidate',
            'results',
            'finalScore'
        ));
    }
}
