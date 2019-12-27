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

    public static $validation = [
        'first_name' => 'required|alpha',
        'middle_name' => 'alpha',
        'last_name' => 'required|alpha',
        'gender' => 'numeric',
        'birth_date' => 'date',
        'face_pic' => 'numeric'
    ];

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

    public function mainPhoto() {
        return $this->hasOne(Attachment::class, 'id', 'face_pic');
    }

    public function photos() {
//        return $this->hasMany(Attachment::class, 'owner_');
        return $this->morphMany(Attachment::class, 'owner');
    }

    public function certifications() {
        return $this->morphMany(Certification::class, 'owner');
    }

    public function country() {
        return $this->hasOne(Country::class, 'id', 'country');
    }

    public function evaluations() {
        return $this->hasMany(Evaluation::class, 'person', 'id');
    }

    public function madeEvaluations() {
        return $this->hasMany(Evaluation::class, 'evaluator', 'id');
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with([
            'userAccounts' => function($userAccount) use ($lang) {
                $userAccount->withInfo($lang);
            },
            'evaluations' => function($evaluation) use ($lang) {
                $evaluation->extended($lang);
            },
            'certifications' => function($certificate) use ($lang) {
                $certificate->extended($lang);
            },
            'photos' => function($photo) {
                $photo->with('file');
            },
            'mainPhoto' => function($facePic) {
                $facePic->with('file');
            }
        ]);
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