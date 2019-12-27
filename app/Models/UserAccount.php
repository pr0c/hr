<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model {
    protected $fillable = ['account_id', 'user_id', 'user_type'];
    protected $table = 'user_accounts';
    public $timestamps = false;

    public function users() {
        return $this->morphTo('user');
    }

    public function account() {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    public function scopeWithInfo($query, $lang = 1) {
        return $query->with(['account' => function($account) use ($lang) {
            $account->extended($lang);
        }]);
    }
}