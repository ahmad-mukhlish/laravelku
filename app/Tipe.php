<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipe extends Model
{
    
	protected $table = "tb_tipe";
    public $timestamps = false;
	protected $primaryKey = 'id_tipe';
}
