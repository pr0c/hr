<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {
    protected $fillable = ['title_id'];
    protected $table = 'countries';
    public $timestamps = false;

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }

    public function currency() {
        return $this->belongsToMany(Currency::class, 'countries_currencies', 'currency_id', 'country_id');
    }
}