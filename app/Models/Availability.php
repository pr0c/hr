<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model {
    protected $fillable = ['min', 'max', 'places', 'type'];
    protected $table = 'availabilities';
    public $timestamps = false;

    public function place_list() {
        return $this->hasOne(Place::class, 'id', 'places');
    }

    public function type_info() {
        return $this->hasOne(AvailabilityType::class, 'id', 'type');
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with(
            [
                'place_list',
                'type_info' => function($type) use ($lang) {
                    $type->with(['title' => function($title) use ($lang) {
                        $title->translated($lang);
                    }]);
                }
            ]
        );
    }
}