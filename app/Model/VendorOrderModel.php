<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VendorOrderModel extends Model
{
    protected $table = 'p_vendor_orders';
    protected $primaryKey = 'v_oid';
}
