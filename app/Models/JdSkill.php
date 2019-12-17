<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JdSkill extends Model {
    protected $fillable = ['jd_id', 'skill_id'];
    protected $table = 'jd_skills';
    public $timestamps = false;

    public function skill() {
        return $this->hasOne(Skill::class, 'id', 'skill_id');
    }
}