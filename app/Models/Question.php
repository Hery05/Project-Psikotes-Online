<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'category_id',
        'type',
        'question_text',
        'question_image',
        'options',
        'correct_answer',
    ];

    protected $casts = [
        'options' => 'array',
        'choices' => 'array',
    ];

    /* ================= RELASI ================= */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // SATU SOAL BISA PUNYA BANYAK JAWABAN
    public function answers()
    {
        return $this->hasMany(CandidateAnswer::class);
    }
}
