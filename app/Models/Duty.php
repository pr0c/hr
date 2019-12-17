<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Duty extends Model {
    protected $fillable = ['title_id'];
    protected $table = 'duties';
    public $timestamps = false;

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }
}