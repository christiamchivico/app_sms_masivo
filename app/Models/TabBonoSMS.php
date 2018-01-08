<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TabBonoSMS extends Model
{
	use SoftDeletes;
    protected $table = 'tab_bono_sms';    
}
