<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificationType extends Model {
    protected $fillable = ['title_id', 'category'];
    protected $table = 'certification_types';
    public $timestamps = false;

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }

    public function category_info() {
        return $this->hasMany(Translate::class, 'translate_id', 'category');
    }

    public function allowedCategories() {
        return $this->belongsToMany(CertificationCategory::class, 'certification_allowed_categories', 'type', 'category');
    }

    public function scopeFull($query, $lang = 1) {
        return $query->with([
            'title' => function($title) use ($lang) {
                $title->translated($lang);
            },
            'category_info' => function($category) use ($lang) {
                $category->translated($lang);
            }
        ]);
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with(
            [
                'title' => function($title) use ($lang) {
                    $title->translated($lang);
                },
                'allowedCategories' => function($allowedCategory) use ($lang) {
                    $allowedCategory->translated($lang);
                }
            ]
        );
    }
}