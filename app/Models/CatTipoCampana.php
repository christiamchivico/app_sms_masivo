<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatTipoCampana extends Model
{
	use SoftDeletes;
    protected $table = 'cat_tipo_campana';
}