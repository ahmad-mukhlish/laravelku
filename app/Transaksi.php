<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    
	protected $table = "tb_transaksi";
    public $timestamps = false;
	protected $primaryKey = 'id_transaksi';

}
