<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabResultadoMailing extends Model
{
    use SoftDeletes;
    protected $table = 'tab_resultado_mailing';
}
