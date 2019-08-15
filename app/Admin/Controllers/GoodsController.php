<?php

namespace App\Admin\Controllers;

use App\Model\GoodsModel;
use App\Model\GoodsAttrModel;
use App\Model\CategoryModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Actions\GoodsController\Sku;
use Encore\Admin\Layout\Content;
class GoodsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GoodsModel);

        $grid->column('goods_id', __('Goods id'));
        $grid->column('goods_sn', __('Goods sn'));
        $grid->column('goods_name', __('Goods name'));
        $grid->column('goods_img', __('Goods img'))->image();
        $grid->column('short_desc', __('Short desc'));
        $grid->column('price0', __('Price0'));
        $grid->column('price', __('Price'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('is_delete', __('Is delete'));
        $grid->column('is_onsale', __('Is onsale'));

        $grid->actions(function($actions){
            $actions->add(new Sku);
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(GoodsModel::findOrFail($id));

        $show->field('goods_id', __('Goods id'));
        $show->field('goods_sn', __('Goods sn'));
        $show->field('goods_name', __('Goods name'));
        $show->field('goods_img', __('Goods img'));
        $show->field('short_desc', __('Short desc'));
        $show->field('price0', __('Price0'));
        $show->field('price', __('Price'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('is_delete', __('Is delete'));
        $show->field('is_onsale', __('Is onsale'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new GoodsModel);

        $form->text('goods_sn', __('Goods sn'));
        $form->text('goods_name', __('Goods name'));
        $form->select('cid', __('Cid'))->options(CategoryModel::selectOptions());
        $form->image('goods_img', __('Goods img'));
        $form->text('short_desc', __('Short desc'));
        $form->number('price0', __('Price0'));
        $form->number('price', __('Price'));
        //商品属性
        $form->select('attr_id1', 'attr_id1')->options(GoodsAttrModel::selectOptions());
        $form->select('attr_id2', 'attr_id2')->options(GoodsAttrModel::selectOptions());
        $states = [
            "on" => ["value" => 1, "text" => "是", "color" => "success"],
            "off" => ["value" => 0, "text" => "否", "color" => "danger"],
        ];
        $form->switch('is_delete', __('Is delete'))->states($states);
        $form->switch('is_onsale', __('Is onsale'))->default(1)->states($states);

        return $form;
    }
    public function edit($id,Content $content)
    {
        //$tab = new Tab();

        $this->form()->tab("detail",function(){});
        $this->form()->tab("sku",function(){});


        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? trans('admin.edit'))
            ->body($this->form()->edit($id));
    }
    public function update($id)
    {

        $attr_id1 = $_POST['attr_id1'];
        $attr_id2 = $_POST['attr_id2'];
        $_POST['attr_id'] = $attr_id1 . ',' . $attr_id2;

        if($_POST['is_delete']=='on'){
            $_POST['is_delete'] = 1;
        }else{
            $_POST['is_delete'] = 0;
        }

        if($_POST['is_onsale']=='on'){
            $_POST['is_onsale'] = 1;
        }else{
            $_POST['is_onsale'] = 0;
        }
        unset($_POST['attr_id1']);
        unset($_POST['attr_id2']);
        unset($_POST['_token']);
        unset($_POST['_method']);
        unset($_POST['_previous_']);
        GoodsModel::where(['goods_id'=>$id])->update($_POST);
    }
    public function store()
    {
        echo '<pre>';print_r($_POST);echo '</pre>';
        $attr_id1 = $_POST['attr_id1'];
        $attr_id2 = $_POST['attr_id2'];
        unset($_POST['attr_id1']);
        unset($_POST['attr_id2']);
        unset($_POST['_token']);
        unset($_POST['_previous_']);
        if($_POST['is_delete']=='on'){
            $_POST['is_delete'] = 1;
        }else{
            $_POST['is_delete'] = 0;
        }

        if($_POST['is_onsale']=='on'){
            $_POST['is_onsale'] = 1;
        }else{
            $_POST['is_onsale'] = 0;
        }
        $_POST['attr_id'] = $attr_id1 . ',' . $attr_id2;
        GoodsModel::insert($_POST);
    }
}
