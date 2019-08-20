<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{

    protected $table = 'p_orders';
    protected $primaryKey = 'oid';

    /**
     * 生成总订单号
     * @return string
     */
    public static function generateOrderSN()
    {
        return 'O' . date('ymdH') . rand(11111,99999) . rand(2222,9999);
    }

    /**
     * 生成分订单号
     * @return string
     */
    public static function generateVOrderSN()
    {
        return 'V' . date('ymdH') . rand(11111,99999) . rand(2222,9999);
    }
}
