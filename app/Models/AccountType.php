<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model {
    protected $fillable = ['title_id', 'default_provider', 'category'];
    protected $table = 'account_types';
    public $timestamps = false;

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }

    public function allowedServices() {
        return $this->belongsToMany(AccountService::class, 'account_type_services', 'type_id', 'service_id');
    }

    public function category_info() {
        return $this->hasMany(Translate::class, 'translate_id', 'category');
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with(['title' => function($title) use ($lang) {
            $title->translated($lang);
        },
        'allowedServices' => function($service) use ($lang) {
            $service->with(['title' => function($title) use ($lang) {
                $title->translated($lang);
            }]);
        },
        'category_info' => function($category) use ($lang) {
            $category->translated($lang);
        }]);
    }
}