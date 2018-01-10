<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabCampana extends Model
{
    use SoftDeletes;
    protected $table = 'tab_campana';

    public $fillable = [
        'nombre',
        'asunto',
        'nombre_emisor',
        'email_emisor',
        'email_respuesta',
        'mensaje_sms',
        'personalizado',
        'cat_categoria_campana_id',
        'tab_empresa_id',
        'status',
    ];
}
