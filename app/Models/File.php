<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model {
    protected $fillable = ['src'];
    public $timestamps = true;

    public function upload() {

    }
}