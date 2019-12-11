<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Account extends Model {
    use \App\Traits\Account;

    protected $fillable = [
        'type', 'identifier', 'provider', 'owner_id', 'owner_type'
    ];
//    protected $hidden = ['owner_id', 'owner_type'];
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

    public static function isExist($identifier) {
        if(Account::where('identifier', '=', $identifier)->count() > 0) {
            return true;
        }
        else return false;
    }

    /*protected static function boot() {
        parent::boot();

        static::created(function($account) {
            if(!empty($account->owner_id) && !empty($account->owner_type)) {
                UserAccount::create([
                    'account_id' => $account->id,
                    'user_id' => $account->owner_id,
                    'user_type' => $account->owner_type
                ]);
            }
        });
    }*/
}