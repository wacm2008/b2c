<?php

namespace App\Admin\Controllers;

use App\Model\GoodsAttrModel;
use App\Model\GoodsAttrValueModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GoodsAttrController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品属性管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GoodsAttrModel);

        $grid->column('attr_id', __('Attr id'));
        $grid->column('title', __('Title'));
        $grid->column('order', __('Order'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('parent_id', __('Parent id'));

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
        $show = new Show(GoodsAttrModel::findOrFail($id));

        $show->field('attr_id', __('Attr id'));
        $show->field('title', __('Title'));
        $show->field('order', __('Order'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('parent_id', __('Parent id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new GoodsAttrModel);

        $form->text('title', __('Title'));
        $form->number('order', __('Order'))->default(1);
        $form->number('parent_id', __('Parent id'));

        return $form;
    }
}
