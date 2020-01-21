<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupType extends Model {
    protected $fillable = ['title_id', 'category'];
    protected $table = 'group_types';
    public $timestamps = false;

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }

    public function category_info() {
        return $this->hasMany(Translate::class, 'translate_id', 'category');
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with(
            [
                'title' => function($title) use ($lang) {
                    $title->translated($lang);
                },
                'category_info' => function($category) use ($lang) {
                    $category->translated($lang);
                }
            ]
        );
    }
}