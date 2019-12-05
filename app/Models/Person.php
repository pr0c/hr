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

    public function accounts() {
        return $this->morphMany(Account::class, 'owner');
    }

    public function scopeWithAccounts($query) {
        return $query->with('accounts');
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