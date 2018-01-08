<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelUsersEmpresa extends Model
{
    use SoftDeletes;
    protected $table = 'rel_users_empresa';
}
