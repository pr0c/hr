<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Benefit extends Model {
    protected $fillable = ['type', 'benefit'];
    protected $table = 'benefits';
    public $timestamps = false;

    public function benefit() {
        return $this->hasMany(Translate::class, 'translate_id', 'benefit');
    }

    public function type() {
        return $this->hasOne(BenefitType::class, 'id', 'type');
    }
}