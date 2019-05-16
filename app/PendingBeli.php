<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingBeli extends Model
{
	protected $table = "tb_pending_beli";
	protected $primaryKey = 'id_pending';
    public $timestamps = true;
}
