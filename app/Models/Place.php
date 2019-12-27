<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model {
    protected $fillable = ['places'];
    protected $table = 'availability_places';
    public $timestamps = false;
}