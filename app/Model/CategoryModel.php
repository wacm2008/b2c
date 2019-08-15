<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\ModelTree;
class CategoryModel extends Model
{
    use ModelTree;
    protected $table='p_category';
    protected $primaryKey='cid';
}
