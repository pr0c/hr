<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountService extends Model {
    protected $fillable = ['title_id'];
    protected $table = 'account_services';
    public $timestamps = false;

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }
}