<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model {
    protected $fillable = [
        'category', 'title_id', 'attachment', 'owner_id', 'owner_type'
    ];
    protected $table = 'certifications';
    public $timestamps = false;

    public function owner() {
        return $this->morphTo('owner');
    }

    public function attachments() {
        return $this->hasMany(Attachment::class, 'attachment_id', 'attachment');
    }

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }

    public function type() {
        return $this->hasOne(CertificationType::class, 'id', 'category');
    }

    public function categories() {
        return $this->belongsToMany(CertificationCategory::class, 'certification_category_list', 'category_id', 'certification_id');
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with(
            [
                'owner',
                'attachments' => function($attachment) {
                    $attachment->with('file');
                },
                'title' => function($title) use ($lang) {
                    $title->translated($lang);
                },
                'type' => function($type) use ($lang) {
                    $type->extended($lang);
                },
                'categories' => function($category) use ($lang) {
                    $category->translated($lang);
                }
            ]
        );
    }
}