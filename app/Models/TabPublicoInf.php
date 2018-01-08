<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabPublicoInf extends Model
{
    use SoftDeletes;
    protected $table = 'tab_publico_inf';

    public $fillable = [
        'nombre',
        'cat_categoria_publico_id',
        'tab_empresa_id',
    ];
}
