<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BenefitType extends Model {
    protected $fillable = ['title'];
    protected $table = 'benefit_types';
    public $timestamps = false;

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title');
    }
}