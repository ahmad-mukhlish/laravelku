<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    
	protected $table = "tb_merk";
    public $timestamps = false;
	protected $primaryKey = 'id_merk';
}
