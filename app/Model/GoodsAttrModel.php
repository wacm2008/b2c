<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\ModelTree;
class GoodsAttrModel extends Model
{
    use ModelTree;
    protected $table='p_goods_attr';
    protected $primaryKey='attr_id';
}
