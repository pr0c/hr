<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {
    protected $fillable = ['title_id'];
    protected $table = 'languages';
    public $timestamps = false;

    public function title() {
        return $this->belongsTo(Text::class, 'id', 'title_id');
    }

    public function translates() {
        return $this->hasMany(Translate::class, 'language');
    }
}