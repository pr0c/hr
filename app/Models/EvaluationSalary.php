<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationSalary extends Model {
    protected $fillable = [
        'last_currency', 'new_currency', 'perspective', 'last_hours', 'last_salary', 'last_extras', 'new_salary', 'new_extras', 'new_hours'
    ];
    protected $table = 'evaluation_salaries';
    public $timestamps = false;

    public function last_currency() {
        return $this->hasOne(Currency::class, 'id', 'last_currency');
    }

    public function new_currency() {
        return $this->hasOne(Currency::class, 'id', 'new_currency');
    }
}