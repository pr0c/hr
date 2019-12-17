<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model {
    protected $fillable = ['title_id', 'symbol'];
    protected $table = 'currencies';
    public $timestamps = false;

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }
}