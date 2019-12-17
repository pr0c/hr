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

    public function scopePhotos($query) {
        return $query->with('photos');
    }

    public function facePic() {
        return $this->hasOne(Attachment::class, 'attachment_id', 'face_pic');
    }

    public function photos() {
        return $this->hasMany(Attachment::class, 'attachment_id', 'attachment_id');
    }

    public function certifications() {
        return $this->morphMany(Certification::class, 'owner');
    }

    /*public function scopeWithUserAccounts($query, $lang = 1) {
        return $query->with(['userAccounts' => function($q) use($lang) {
            return $q->with(['account' => function($account) use($lang) {
                return $account->extendedAccount($lang);
            }]);
        }]);
    }*/

    /*protected static function boot() {
        parent::boot();

        static::created(function($person) {

        });
    }*/
}