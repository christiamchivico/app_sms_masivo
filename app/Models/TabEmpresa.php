<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabEmpresa extends Model
{
    use SoftDeletes;
    protected $table = 'tab_empresa';

    
}
