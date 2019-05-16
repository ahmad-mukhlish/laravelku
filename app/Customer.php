<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $table = "tb_customer";
	protected $primaryKey = 'no_ktp';
    public $timestamps = false;
    
    public $incrementing = false;
}


?>
