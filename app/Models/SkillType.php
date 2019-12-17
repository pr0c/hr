<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillType extends Model {
    protected $fillable = ['title_id'];
    protected $table = 'skill_types';
    public $timestamps = false;

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }
}