<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $connection = 'mysql_sensor';
    protected $table = 'tbl_sensor';
    protected $hidden = ['created_at','updated_at'];
}
