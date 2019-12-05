<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Text extends Model {
    protected $table = 'texts';
    public $timestamps = false;

    public function translates() {
        return $this->hasMany('\App\Models\Translate', 'translate_id');
    }
}