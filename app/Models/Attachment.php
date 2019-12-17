<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model {
    public $timestamps = false;

    public function file() {
        return $this->hasOne(File::class);
    }
}