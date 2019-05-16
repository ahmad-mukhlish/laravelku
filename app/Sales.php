<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = "tb_sales";
	protected $primaryKey = 'no_ktp_sales';
    public $timestamps = false;
}
