<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {
    protected $fillable = ['title_id', 'flag'];
    protected $table = 'countries';
    public $timestamps = false;

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }

    public function currency() {
        return $this->belongsToMany(Currency::class, 'countries_currencies', 'country_id', 'currency_id');
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with([
            'title' => function($title) use ($lang) {
                $title->translated($lang);
            },
            'currency' => function($currency) use ($lang) {
                $currency->with(['title' => function($title) use ($lang) {
                    $title->translated($lang);
                }]);
            }
        ]);
    }
}