<?php

namespace App\Admin\Controllers;

use App\Model\SkuModel;
use App\Model\GoodsAttrModel;
use App\Model\GoodsAttrValueModel;
use App\Model\GoodsModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
class SkuController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'sku管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SkuModel);

        $grid->column('id', __('Id'));
        $grid->column('goods_id', __('Goods id'));
        $grid->column('goods_sn', __('Goods sn'));
        $grid->column('sku', __('Sku'));
        $grid->column('desc', __('Desc'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('price0', __('Price0'));
        $grid->column('price', __('Price'));
        $grid->column('store', __('Store'));
        $grid->column('is_onsale', __('Is onsale'));

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
        $show = new Show(SkuModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('goods_id', __('Goods id'));
        $show->field('goods_sn', __('Goods sn'));
        $show->field('sku', __('Sku'));
        $show->field('desc', __('Desc'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('price0', __('Price0'));
        $show->field('price', __('Price'));
        $show->field('store', __('Store'));
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
        $form = new Form(new SkuModel);

        $form->number('goods_id', __('Goods id'));
        $form->text('goods_sn', __('Goods sn'));
        $form->text('sku', __('Sku'));
        $form->text('desc', __('Desc'));
        $form->number('price0', __('Price0'));
        $form->number('price', __('Price'));
        $form->number('store', __('Store'));
        $form->switch('is_onsale', __('Is onsale'))->default(1);

        return $form;
    }
    public function skuDetail(Content $content,$goods_id)
    {
        //echo $goods_id;
        //$data=SkuModel::where(['goods_id'=>$goods_id])->first()->toArray();
        //echo "<pre>";print_r($data);echo "</pre>";
        $form = new Form(new SkuModel);
        $form->setAction('/admin/sku-detail-update?id='.$goods_id);
        $form->text('goods_id', __('Goods id'))->default($goods_id);
        $form->text('goods_sn', __('Goods sn'));
        //获取当前商品属性
        $attr = GoodsModel::find($goods_id)->toArray();
        $attr_arr = explode(',',$attr['attr_id']);
        //print_r($attr_arr);die;
        $i = 0;
        foreach($attr_arr as $k=>$v)
        {
            $attr_info = GoodsAttrModel::find($v)->toArray();
            //print_r($attr_info);die;
            $attr_value = GoodsAttrValueModel::select('attr_vid','title')->where(['attr_id'=>$v])->orderBy('order','asc')->get()->toArray();
            //print_r($attr_value);die;
            $option = [];
            foreach($attr_value as $k1=>$v1){
                $option[$v1['attr_vid']] = $v1['title'];
            }
            $form->select('attr_id'.$i, __($attr_info['title']))->options($option);
            $i++;
        }
        $form->text('sku', __('Sku'));
        $form->text('desc', __('Desc'));
        $form->number('price0', __('Price0'));
        $form->number('price', __('Price'));
        $form->number('store', __('Store'));
        $form->switch('is_onsale', __('Is onsale'))->default(1);

        return $content->body($form);
    }
    public function skuUpdate()
    {
        $attr_vid = '';
        for($i=0;$i<3;$i++)
        {
            if(isset($_POST['attr_id'.$i])){
                $attr_vid .= $_POST['attr_id'.$i] . ',';
                unset($_POST['attr_id'.$i]);
            }
        }

        $_POST['attr_vid'] = rtrim($attr_vid,',');
        unset($_POST['_token']);
        //echo '<pre>';print_r($_POST);echo '</pre>';
        SkuModel::insert($_POST);
        admin_toastr('添加成功','success');
        return redirect('/admin/sku_detail/'.$_POST['goods_id']);
    }
}