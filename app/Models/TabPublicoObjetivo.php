<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabPublicoObjetivo extends Model
{
    use SoftDeletes;
    protected $table = 'tab_publico_objetivo';

    public $fillable = [
        'email',
        'nombre',
        'telefono',
        'tab_publico_inf_id',
    ];
}
