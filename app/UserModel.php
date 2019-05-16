<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    
	protected $table = "tb_user";
    public $timestamps = false;
	protected $primaryKey = 'id_user';
}
