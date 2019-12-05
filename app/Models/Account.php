<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model {
    protected $fillable = [
        'type', 'identifier', 'provider', 'owner_id', 'owner_type'
    ];
//    protected $hidden = ['owner_id', 'owner_type'];
    protected $table = 'accounts';
    public $timestamps = false;

    public function owner() {
        return $this->morphTo('owner');
    }

    public function services() {
        return $this->belongsToMany(AccountService::class, 'supported_services', 'account_id', 'service_id');
    }
}