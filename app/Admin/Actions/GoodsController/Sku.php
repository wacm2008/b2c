<?php

namespace App\Admin\Actions\GoodsController;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Sku extends RowAction
{
    public $name = 'sku管理';

//    public function handle(Model $model)
//    {
//        // $model ...
//
//        return $this->response()->success('Success message.')->refresh();
//    }
    public function href()
    {
        //获取当前行的主键值
        //echo $this->getKey();
        $key = $this->getKey();
        return '/admin/sku_detail/'.$key;
    }
}