<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateProgress extends Model
{
    protected $table = 'candidate_progress';

    protected $fillable = [
        'candidate_id',
        'category_id',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
