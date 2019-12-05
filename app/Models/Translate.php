<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translate extends Model {
    use \App\Traits\Translate;

    protected $fillable = [
        'language',
        'text',
        'translate_id'
    ];
    protected $table = 'translates';
    public $timestamps = false;

    public function language() {
        return $this->belongsTo(Language::class, null, 'language');
    }
}