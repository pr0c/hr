<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model {
    protected $fillable = ['title_id', 'default_provider'];
    protected $table = 'account_types';
    public $timestamps = false;

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }

    public function allowedServices() {
        return $this->belongsToMany(AccountService::class, 'account_type_services', 'service_id', 'type_id');
    }
}