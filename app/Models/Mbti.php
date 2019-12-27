<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mbti extends Model {
    protected $fillable = [
        'code', 'role_id', 'verb_id', 'seasonal_clock', 'elemental'
    ];
    protected $table = 'mbti_types';
    public $timestamps = false;

    public function role() {
        return $this->hasMany(Translate::class, 'translate_id', 'role_id');
    }

    public function verb() {
        return $this->hasMany(Translate::class, 'translate_id', 'verb_id');
    }

    public function clock() {
        return $this->hasMany(Translate::class, 'translate_id', 'seasonal_clock');
    }

    public function elemental() {
        return $this->hasMany(Translate::class, 'translate_id', 'elemental');
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with([
            'role' => function($role) use ($lang) {
                $role->translated($lang);
            },
            'verb' => function($verb) use ($lang) {
                $verb->translated($lang);
            },
            'clock' => function($clock) use ($lang) {
                $clock->translated($lang);
            },
            'elemental' => function($element) use ($lang) {
                $element->translated($lang);
            }
        ]);
    }
}