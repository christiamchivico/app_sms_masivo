<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabPrecioSMS extends Model
{
    use SoftDeletes;
    protected $table = 'tab_precio_sms';
}
