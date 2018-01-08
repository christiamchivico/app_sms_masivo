<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabResultadoSms extends Model
{
    use SoftDeletes;
    protected $table = 'tab_resultado_sms';
}
