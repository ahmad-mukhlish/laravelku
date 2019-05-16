<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
	protected $table = "tb_motor";
	protected $primaryKey = 'no_mesin';
    public $timestamps = true;
	public $incrementing = false;
}
