<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KonfigInsentif extends Model
{
	protected $table = "tb_konfig_insentif";
	protected $primaryKey = 'id';    
    public $timestamps = false;
    public $incrementing = false;
}