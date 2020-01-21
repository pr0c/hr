<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillSubCategory extends Model {
    protected $table = 'skill_sub_categories';
    protected $fillable = ['title_id'];
    public $timestamps = false;

    public function category_info() {
        return $this->belongsToMany(SkillCategory::class, 'skill_category_sub_categories', 'sub_category_id', 'category_id');
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