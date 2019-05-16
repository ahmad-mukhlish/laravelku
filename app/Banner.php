<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
	protected $table = "tb_banner";
	protected $primaryKey = 'id_banner';
    public $timestamps = false;
}
