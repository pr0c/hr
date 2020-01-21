<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model {
    protected $fillable = [ //add 'owner_id' and 'owner_type' if need to create certification with separately created owner
        'category', 'attachment'
    ];
    protected $table = 'certifications';
    public $timestamps = false;

    public function owner() {
        return $this->morphTo('owner');
    }

    public function attachments() {
//        return $this->hasMany(Attachment::class, 'attachment_id', 'attachment');
        return $this->morphMany(Attachment::class, 'owner');
    }

    public function type() {
        return $this->hasOne(CertificationType::class, 'id', 'category');
    }

    public function categories() {
        return $this->belongsToMany(CertificationCategory::class, 'certification_category_list', 'certification_id', 'category_id');
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with(
            [
                'owner',
                'attachments' => function($attachment) {
                    $attachment->with('file');
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