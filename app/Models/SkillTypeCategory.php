<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillTypeCategory extends Model {
    protected $table = 'skill_categories';
    protected $fillable = ['title_id'];
    public $timestamps = false;

    public function sub_categories() {
        return $this->belongsToMany(SkillSubCategory::class, 'skill_category_sub_categories', 'category_id', 'sub_category_id');
    }

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with(['title' => function($title) use ($lang) {
            $title->translated($lang);
        }]);
    }
}