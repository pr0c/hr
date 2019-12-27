<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobHistory extends Model {
    protected $fillable = [
        'person_id', 'group_id', 'department', 'start_date', 'end_date', 'city', 'country', 'job_title_id', 'job_description'
    ];
    protected $table = 'job_history';
    public $timestamps = false;

    public function person() {
        return $this->hasOne(Person::class, 'id', 'person_id');
    }

    public function group() {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function department() {
        return $this->hasOne(Group::class, 'id', 'department');
    }

    public function country_info() {
        return $this->hasOne(Country::class, 'id', 'country');
    }

    public function jobTitle() {
        return $this->hasOne(JobTitle::class, 'id', 'job_title_id');
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with([
            'person',
            'group',
            'department',
            'country_info' => function($country) use ($lang) {
                $country->extended($lang);
            },
            'jobTitle' => function($jobTitle) use ($lang) {
                $jobTitle->with(['title' => function($title) use ($lang) {
                    $title->translated($lang);
                }]);
            }
        ]);
    }
}