<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateAnswer extends Model
{
    protected $fillable = [
        'candidate_id',
        'category_id',
        'question_id',
        'answer',
        'score',
    ];

    /* ================= RELASI ================= */

    // jawaban milik kandidat
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // jawaban untuk soal
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // jawaban berada di kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
