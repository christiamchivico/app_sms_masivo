<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelCampanaPublico extends Model
{
    use SoftDeletes;
    protected $table = 'rel_campana_publico';

    public $fillable = [
        'tab_publico_objetivo_info_id',
        'tab_campana_id',
    ];
}
