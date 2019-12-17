<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificationType extends Model {
    protected $fillable = ['title_id'];
    protected $table = 'certification_types';
    public $timestamps = false;

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }

    public function allowedCategories() {
        return $this->belongsToMany(CertificationCategory::class, 'certification_allowed_categories', 'category', 'type');
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