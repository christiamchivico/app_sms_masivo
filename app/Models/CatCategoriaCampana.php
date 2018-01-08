<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatCategoriaCampana extends Model
{
    use SoftDeletes;
    protected $table = 'cat_categoria_campana';
}
