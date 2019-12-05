<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model {
    use \App\Traits\Account;

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'gender', 'birth_date', 'birth_place', 'hometown', 'country', 'face_pic'
    ];
    protected $table = 'persons';
    public $timestamps = false;

    public function ownAccounts() {
        return $this->morphMany(Account::class, 'owner');
    }

    public function userAccounts() { //Own and shared accounts
        return $this->morphMany(UserAccount::class, 'user');
    }

    public function scopeWithAccounts($query) {
        return $query->with('ownAccounts');
    }

    public function scopeWithUserAccounts($query) {
        return $query->with('userAccounts');
    }

    public function scopePhotos($query) {
        return $query->with('photos');
    }

    /*protected static function boot() {
        parent::boot();

        static::created(function($person) {

        });
    }*/
}