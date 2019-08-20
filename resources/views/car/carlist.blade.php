<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link type="text/css" rel="stylesheet" href="/index/css/style.css" />
    <script type="text/javascript" src="/index/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="/index/js/menu.js"></script>
    <script type="text/javascript" src="/index/js/lrscroll_1.js"></script>
    <script type="text/javascript" src="/index/js/n_nav.js"></script>

    <script src="/js/jquery.js"></script>

    <title>购物车展示</title>
</head>
<body>
<div class="content mar_20">
    <img src="/index/images/img1.jpg" />
</div>
<div class="content mar_20">
    <table border="0" class="car_tab" style="width:1200px; margin-bottom:50px;" cellspacing="0" cellpadding="0">
        <tr>
            <td class="car_th" width=""><input type="checkbox" id="allbox" /></td>
            <td class="car_th" width="290">商品名称</td>
            <td class="car_th" width="150">店铺</td>
            <td class="car_th" width="140">单价</td>
            <td class="car_th" width="150">购买数量</td>
            <td class="car_th" width="130">小计</td>
            <td class="car_th" width="150">操作</td>
        </tr>
        <tbody id="clearAll">
        @foreach($carInfo as $k=>$v)
            <tr class="$var collect" goods_num="{{$v->store}}" goods_id="{{$v->goods_id}}">
                <td><input type="checkbox" class="box"/></td>
                <td align="center">
                    <div class="c_s_img"><img src="storage/{{$v->goods_img}}" width="73" height="73" /></div>
                    {{$v->goods_name}}
                </td>
                <td align="center">
                    <span>{{$v->shop_name}}</span>
                </td>
                <td align="center">
                    <span>{{$v->price}}</span>
                </td>
                <td align="center">
                    <div class="c_num">
                        <input type="button" id="less" class="car_btn_1" />
                        <input type="text" value="{{$v->buy_number}}" class="car_ipt buy_number" />
                        <input type="button" id="more" class="car_btn_2" />
                    </div>
                </td>
                <td align="center" class='total' style="color:#ff4e00;">￥<span>{{$v->buy_number*$v->price}}</span></td>

                <td align="center"><a class="del">删除</a>&nbsp; &nbsp;<a href="#" class="save">加入收藏</a></td>

            </tr>
        @endforeach
        </tbody>
        <tr height="70">
            <td colspan="6" style="font-family:'Microsoft YaHei'; border-bottom:0;">
                <label class="r_txt"><input type="button" id="clearCar" value="清空购物车" /></label>
                <label class="r_txt"><input type="button" value="加入收藏夹" /></label>
                <span class="fr" >商品总价：<b style="font-size:22px; color:#ff4e00;" id="totalPrice">￥0</b></span>
            </td>
        </tr>
        <tr valign="top" height="150">
            <td colspan="6" align="right">
                <a href="#">
                    <img src="/index/images/buy1.gif" /></a>&nbsp; &nbsp;
                <a href="/orderAdd" id="confirmOrder">
                    <img src="/index/images/btn_sure.gif" />
                </a>
            </td>
        </tr>
    </table>

</div>
</body>
</html>
<script>
    $(function () {
        //加号
        $(".car_btn_2").click(function() {
            var _this = $(this);
            var buy_number = parseInt(_this.prev('input').val());
            var goods_num = _this.parents('tr').attr('goods_num');
            var goods_id = _this.parents('tr').attr('goods_id');
            //console.log(buy_number);
            //console.log(goods_num);
            if (buy_number >= goods_num) {
                _this.prop('disabled', true);
            } else {
                buy_number += 1;
                _this.prev('input').val(buy_number);
                _this.siblings("input[class='car_btn_1']").prop('disabled', false);
            }
            //改变数量
            $.post(
                "/changeNum",
                {goods_id:goods_id,buy_number:buy_number},
                function(res){
                    //改变小计
                    var self_price=parseInt(_this.parents('td').prev('td').find('span').last().text());
                    //console.log(self_price);
                    var total=self_price*buy_number;
                    _this.parents('td').next('td').find('span').text(total);
                    //重新计算总价
                    getTotalPrice();
                }
            );
        });
        //减号
        $(".car_btn_1").click(function(){
            var _this=$(this);
            var buy_number=parseInt(_this.next('input').val());
            var goods_num=_this.parents('tr').attr('goods_num');
            var goods_id=_this.parents('tr').attr('goods_id');
            //console.log(buy_number);
            //console.log(goods_num);
            if(buy_number<=1){
                _this.prop('disabled',true);
            }else{
                buy_number-=1;
                _this.next('input').val(buy_number);
                _this.siblings("input[class='car_btn_2']").prop('disabled',false);
            }
            //改变数量
            $.post(
                "/changeNum",
                {goods_id:goods_id,buy_number:buy_number},
                function(res){
                    //改变小计
                    var self_price=parseInt(_this.parents('td').prev('td').find('span').last().text());
                    //console.log(self_price);
                    var total=self_price*buy_number;
                    _this.parents('td').next('td').find('span').text(total);
                    //重新计算总价
                    getTotalPrice();
                }
            );
        });
        //失去焦点
        $('.buy_number').blur(function(){
            var _this=$(this);
            var buy_number=parseInt(_this.val());
            var goods_num=_this.parents('tr').attr('goods_num');
            var goods_id=_this.parents('tr').attr('goods_id');
            var reg=/^[1-9]\d*$/;
            if(!reg.test(buy_number)){
                _this.val(1);
            }else if(buy_number<=1){
                _this.val(1);
            }else if(buy_number>=goods_num){
                _this.val(goods_num);
            }else{
                _this.val(buy_number);
            }
            buy_number=parseInt(_this.val());
            //改变数量
            $.post(
                "/changeNum",
                {goods_id:goods_id,buy_number:buy_number},
                function(res){
                    //改变小计
                    var self_price=parseInt(_this.parents('td').prev('td').find('span').last().text());
                    //console.log(self_price);
                    var total=self_price*buy_number;
                    _this.parents('td').next('td').find('span').text(total);
                    //重新计算总价
                    getTotalPrice();
                }
            );
        });
        //点击复选框
        $(document).on('click','.box',function(){
            var _this=$(this);
            if(_this.prop('checked')==false){
                $('#allbox').prop('checked',false);
            }
            getTotalPrice();
        });
        //全选
        $('#allbox').click(function(){
            var _this=$(this);
            var estado=_this.prop('checked');
            $('.box').prop('checked',estado);
            getTotalPrice();
        });
        //购物车总价格
        function getTotalPrice(){
            var goods_id=$('.box').parents('tr').attr('goods_id');
			//console.log(goods_id);
            var box=$('.box');
            var goods_id='';
            box.each(function(index){
                var _this=$(this);
                if(_this.prop('checked')==true){
                    goods_id+=_this.parents('tr').attr('goods_id')+',';
                }
            });
            //console.log(goods_id);
            goods_id=goods_id.substr(0,goods_id.length-1);
            //console.log(goods_id);
            $.post(
                "/totalPrice",
                {goods_id:goods_id},
                function(res){
                    console.log(res);
                    $("#totalPrice").text('￥'+res);
                }
            );
        }
        //确认订单
        // $('#confirmOrder').click(function () {
        //     var box=$('.box');
        //     var goods_id='';
        //     box.each(function(index){
        //         var _this=$(this);
        //         //console.log(_this.prop('checked'));
        //         if(_this.prop('checked')==true){
        //             goods_id+=_this.parents('tr').attr('goods_id')+',';
        //         }
        //     });
        //     goods_id=goods_id.substr(0,goods_id.length-1);
        //     $.ajx({
        //         url:'/orderAdd',
        //         data:{goods_id:goods_id},
        //         dataType:'json',
        //         type:'post',
        //         async:false,
        //         success:function (res) {
        //             console.log(res);
        //         }
        //     })
        // });
    })
</script>
