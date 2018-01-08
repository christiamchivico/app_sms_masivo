<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabResultadoSmsDet extends Model
{
    use SoftDeletes;
    protected $table = 'tab_resultado_sms_det';

    public $fillable = [
        'tab_publico_objetivo_info_id',
        'aceptado',
        'fecha_envio',
        'enviado',
        'fecha_confirmado',
        'resultado_t',
        'caracteres',
        'costo',
        'ip',
    ];
}
