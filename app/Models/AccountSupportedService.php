<?php
/* DO NOT USE IT */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountSupportedService extends Model {
    protected $fillable = ['service_id', 'account_id'];
    protected $table = 'supported_services';
    public $timestamps = false;
}