<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillType extends Model {
    protected $fillable = ['title_id', 'category', 'sub_category'];
    protected $table = 'skill_types';
    public $timestamps = false;

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }

    public function category_info() {
        return $this->hasOne(SkillTypeCategory::class, 'id', 'category');
    }

    public function sub_category_info() {
        return $this->hasOne(SkillSubCategory::class, 'id', 'sub_category');
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with(
            [
                'title' => function($title) use ($lang) {
                    $title->translated($lang);
                },
                'category_info' => function($category) use ($lang) {
                    $category->extended($lang);
                },
                'sub_category_info' => function($sub_category) use ($lang) {
                    $sub_category->extended($lang);
                }
            ]
        );
    }
}