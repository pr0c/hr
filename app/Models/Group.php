<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {
    use \App\Traits\Account;

    protected $fillable = [
        'short_name', 'full_name', 'email', 'phone', 'address', 'city', 'country', 'vat', 'reg_number', 'website', 'owner_id', 'owner_type', 'type', 'logo'
    ];

    public static $validation = [
        'short_name' => 'unique:groups',
        'full_name' => 'required|unique:groups',
        'email' => 'email'
    ];

    public $timestamps = false;

    public function ownAccounts() {
        return $this->morphMany(Account::class, 'owner');
    }

    public function userAccounts() {
        return $this->morphMany(UserAccount::class, 'user');
    }

    public function owner() {
        return $this->morphTo('owner');
    }

    public function departments() {
        return $this->morphMany(Group::class, 'owner');
    }

    public function membersHistory() {
        return $this->hasMany(JobHistory::class, 'group_id', 'id');
    }

    public function type_info() {
        return $this->hasOne(GroupType::class, 'id', 'type');
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with([
            'userAccounts',
            'owner',
            'departments',
            'membersHistory',
            'type_info'
        ]);
    }

    public function scopeFull($query, $lang = 1) {
        return $query->with([
            'userAccounts' => function($account) use ($lang) {
                $account->withInfo($lang);
            },
            'owner',
            'departments' => function($department) use ($lang) {
                $department->extended($lang);
            },
            'membersHistory' => function($member) use ($lang) {
                $member->extended($lang);
            },
            'type_info' => function($type) use ($lang) {
                $type->extended($lang);
            }
        ]);
    }
}