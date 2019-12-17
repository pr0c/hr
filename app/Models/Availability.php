<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model {
    protected $fillable = ['title_id'];
    protected $table = 'availability_types';
    public $timestamps = false;

    public function places() {
        return $this->hasMany(Place::class, 'availability_id', 'id');
    }

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }
}