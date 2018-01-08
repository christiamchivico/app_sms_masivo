<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelCampanaTipoCampana extends Model
{
    use SoftDeletes;
    protected $table = 'rel_campana_tipocampana';

    public $fillable = [
        'cat_tipo_campana_id',
        'tab_campana_id'
    ];

}
