<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MercanteModel extends Model
{
    protected $table='p_mercante';
    public $timestamps=false;
    protected $primaryKey='shop_id';
}
