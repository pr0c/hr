<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model {
    protected $fillable = [
        'file_id', 'owner_id', 'owner_type'
    ];
    protected $table = 'attachments';
    public $timestamps = false;

    public function file() {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

    public function owner() {
        return $this->morphTo('owner');
    }
}