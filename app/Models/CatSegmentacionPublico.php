<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatSegmentacionPublico extends Model
{
    use SoftDeletes;
    protected $table = 'cat_segmentacion_publico';
}
