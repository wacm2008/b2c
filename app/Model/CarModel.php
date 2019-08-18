<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table='p_car';
    protected $primaryKey='car_id';
    public $timestamps=false;
}
