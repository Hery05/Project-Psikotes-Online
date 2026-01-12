<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   protected $fillable = ['name','duration','passing_score','weight'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'category_id');
    }
    public function progress()
    {
        return $this->hasMany(CandidateProgress::class);
    }
}
