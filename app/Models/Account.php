<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Account extends Model {
    use \App\Traits\Account;

    protected $fillable = [
        'type', 'identifier', 'provider', 'owner_id', 'owner_type'
    ];

    protected $table = 'accounts';
    public static $validation = [
        'type' => 'numeric',
        'identifier' => 'required|unique:accounts',
        'provider' => 'numeric'
    ];

    public $timestamps = false;

    public function owner() {
        return $this->morphTo('owner');
    }

    public function services() {
        return $this->belongsToMany(AccountService::class, 'supported_services', 'account_id', 'service_id');
    }

    public function provider() {
        return $this->hasOne(Group::class, 'id', 'provider');
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with(
            [
                'owner',
                'services' => function ($service) use ($lang) {
                    $service->with(['title' => function($title) use ($lang) {
                        $title->translated($lang);
                    }]);
                },
                'provider'
            ]
        );
    }

    public static function isExist($identifier) {
        if(Account::where('identifier', '=', $identifier)->count() > 0) {
            return true;
        }
        else return false;
    }
}