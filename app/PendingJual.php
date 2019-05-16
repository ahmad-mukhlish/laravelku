<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingJual extends Model
{
	protected $table = "tb_pending_jual";
	protected $primaryKey = 'id_pending';
    public $timestamps = true;
}
