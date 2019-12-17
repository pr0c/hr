<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationMethod extends Model {
    protected $fillable = ['title_id'];
    protected $table = 'evaluation_methods';
    public $timestamps = false;

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }
}