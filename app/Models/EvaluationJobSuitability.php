<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationJobSuitability extends Model {
    protected $fillable = [
        'evaluation_id', 'job_title_id', 'years_exp', 'hour_salary', 'currency', 'ability', 'potential_ability', 'confidence', 'interest'
    ];
    protected $table = 'evaluation_job_suitability';
    public $timestamps = false;

    public function job_title() {
        return $this->hasOne(JobTitle::class, 'id', 'job_title_id');
    }

    public function currency() {
        return $this->hasOne(Currency::class, 'id', 'currency');
    }
}