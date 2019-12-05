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
}