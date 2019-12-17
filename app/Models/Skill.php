<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model {
    protected $fillable = [
        'skill_type', 'years_exp', 'hours_exp', 'ability', 'potential_ability', 'confidence', 'interest'
    ];
    public $timestamps = false;

    public function type() {
        return $this->hasOne(SkillType::class, 'id', 'skill_type');
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with(['type' => function($type) use($lang) {
            $type->with(['title' => function($title) use($lang) {
                $title->translated($lang);
            }]);
        }]);
    }
}