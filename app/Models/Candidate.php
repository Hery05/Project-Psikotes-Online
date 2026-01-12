<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_finished'
    ];

     protected $hidden = [
        'password'
    ];

    public function answers()
    {
        return $this->hasMany(CandidateAnswer::class);
    }

    public function progress()
    {
        return $this->hasMany(CandidateProgress::class);
    }

    public function getTotalScoreAttribute()
    {
        return $this->answers()->sum('score');
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

}
