<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelUsersCampana extends Model
{
    use SoftDeletes;
    protected $table = 'rel_users_campana';

    
    public $fillable = [
        'users_id',
        'tab_campana_id'
    ];
}
