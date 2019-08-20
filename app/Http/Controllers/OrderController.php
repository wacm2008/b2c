<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\CarModel;
use App\Model\GoodsModel;
use App\Model\OrderDetailModel;
use App\Model\SkuModel;
use App\Model\VendorOrderModel;
use App\Model\OrderModel;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{
    protected $uid = 22;
    /**
     * 生成订单
     */
    public function orderAdd()
    {
        //根据登录用户uid 获取购物车表中信息
        $cart_list = CarModel::where(['uid'=>$this->uid])->get();
        if($cart_list)
        {
            $order_sn = OrderModel::generateOrderSN();  //总订单号
            $total = 0;      //订单总价

            //拆单
            $list = $cart_list->toArray();
            $vender_order = [];
            $arr_goods_price = [];

            foreach($list as $k=>$v)
            {
                //根据 商户id 组合订单
                $vender_order[$v['shop_id']][] = $v;
                //计算价格
                $goods_price = SkuModel::where(['sku'=>$v['sku']])->first()->price;
                $total += $goods_price * $v['store'];   //单价 * 数量

                $arr_goods_price[$v['sku']] = $goods_price;
            }

            $order_info = [
                'order_sn'  => $order_sn,       //总订单号
                'uid'       => $this->uid,
                'total'     => $total,
            ];

            // 事务开始
            DB::beginTransaction();
            try{
                //记录总订单
                OrderModel::insert($order_info);

                //分订单
                foreach($vender_order as $k1=>$v1)
                {
                    $v_total = 0 ;
                    $v_order_sn = OrderModel::generateVOrderSN();   //分单号
                    //计算分单商品价格
                    foreach($v1 as $k2=>$v2){
                        $v_total += $arr_goods_price[$v2['sku']] * $v2['store'];

                        //记录订单商品
                        $order_goods = [
                            'goods_id'  => $v2['goods_id'],
                            'sku'       => $v2['sku'],
                            'order_sn'  => $order_sn,
                            'v_order_sn'    => $v_order_sn,
                            'price'     => $arr_goods_price[$v2['sku']],
                        ];
                        OrderDetailModel::insert($order_goods);
                    }
                    $v_o = [
                        'order_sn'  => $order_sn,
                        'v_order_sn'  => $v_order_sn,
                        'amount'    => $v_total,
                        'shop_id' => $k1,
                        'uid'       => $this->uid,
                    ];
                    //记录分单
                    VendorOrderModel::insert($v_o);

                    // 事务 结束
                    DB::commit();
                }

                echo "生成订单成功: " . $order_sn;echo '</br>';
                //TODO 清空购物车 blabla...

            }catch (\Exception $e){
                DB::rollBack();     //回滚
                echo $e->getMessage();
                // TODO 记录异常信息 blabla
            }
        }else{
            //TODO 空购物车

        }

    }
}
