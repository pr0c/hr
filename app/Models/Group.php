<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {
    use \App\Traits\Account;

    protected $fillable = [
        'short_name', 'full_name', 'email', 'phone', 'address', 'city', 'country', 'vat', 'reg_number', 'website', 'owner_id', 'owner_type'
    ];

    public static $validation = [
        'short_name' => 'unique:groups',
        'full_name' => 'required|unique:groups',
        'email' => 'email'
    ];

    public function ownAccounts() {
        return $this->morphMany(Account::class, 'owner');
    }

    public function userAccounts() {
        return $this->morphMany(UserAccount::class, 'user');
    }
}