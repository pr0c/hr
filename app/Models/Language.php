<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {
    protected $fillable = ['title_id'];
    protected $table = 'languages';
    public $timestamps = false;

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }

    public function translates() {
        return $this->hasMany(Translate::class, 'language');
    }

    public function scopeWithTranslate($query, $lang = 1) {
        return $query->with(['title' => function($title) use($lang) {
           $title->translated($lang);
        }]);
    }
}