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
    <link rel="stylesheet" type="text/css" href="/index/css/ShopShow.css" />
    <link rel="stylesheet" type="text/css" href="/index/css/MagicZoom.css" />
    <script type="text/javascript" src="/index/js/MagicZoom.js"></script>
    <script type="text/javascript" src="/index/js/num.js">
        var jq = jQuery.noConflict();
    </script>
    <script type="text/javascript" src="/index/js/p_tab.js"></script>
    <script type="text/javascript" src="/index/js/shade.js"></script>

    <title>商品详情</title>
</head>
<body>
<input type="hidden" id="goods_id" value="{{$goods_id}}">
<div id="tsShopContainer">
    <div id="tsImgS">
        {{--<a href="" title="Images" class="MagicZoom" id="MagicZoom">--}}
        <img src="storage/{{$goods_img}}" width="210" height="185" />
        {{--</a>--}}
    </div>
</div>
<div class="pro_des">

    <div class="des_name">
        <p>{{$goods_name}}</p>
    </div>
    <div class="des_price">
        本店价格：<b>￥{{$price}}</b><br />
    </div>
    <div class="des_choice">
        @foreach($attr as $k=>$v)
        <span class="fl">{{$v['attr_name']}}：</span>
        <ul>
            @foreach($v['attr_v'] as $k1=>$v1)
            <li class="">{{$v1['title']}}<div class="ch_img"></div></li>
            @endforeach
            <br>
        </ul>
        @endforeach
    </div>
    {{--<div class="des_choice">--}}
        {{--<span class="fl">颜色：</span>--}}
        {{--<ul>--}}
            {{--<li class="checked">银色<div class="ch_img"></div></li>--}}
            {{--<li>深空灰<div class="ch_img"></div></li>--}}
            {{--<li>金色<div class="ch_img"></div></li>--}}
        {{--</ul>--}}
    {{--</div>--}}
    {{--<div class="des_choice">--}}
        {{--<span class="fl">内存：</span>--}}
        {{--<ul>--}}
            {{--<li>64G<div class="ch_img"></div></li>--}}
            {{--<li class="checked">256G<div class="ch_img"></div></li>--}}
        {{--</ul>--}}
    {{--</div>--}}
    <div class="des_join">
        <div class="j_nums">
            <input type="text" value="1" id="buy_number" class="n_ipt" />
            <input type="button" id="more" class="n_btn_1" />
            <input type="button" id="less" class="n_btn_2" />
        </div>
        库存(<font color="red" size="3" id="goods_num">{{$store}}</font>)件
        <span class="fl"><a id="carAdd"><img src="/index/images/j_car.png" /></a></span>
    </div>
</div>
</body>
</html>
<script src="/js/jquery.js"></script>
<script>
    $(function () {
        var goods_num=parseInt($("#goods_num").text());
        //加号
        $("#more").click(function(){
            var _this=$(this);
            var buy_number=parseInt($("#buy_number").val());
            //console.log(buy_number);
            //console.log(goods_num);
            if(buy_number>=goods_num){
                _this.prop('disabled',true);
                _this.next('input').prop('disabled',false);
            }else{
                buy_number=buy_number+1;
                $("#buy_number").val(buy_number);
                _this.next('input').prop('disabled',false);
            }
        });
        //减号
        $("#less").click(function(){
            var _this=$(this);
            var buy_number=parseInt($("#buy_number").val());
            //console.log(buy_number);
            if(buy_number<=1){
                _this.prop('disabled',true);
                _this.prev('input').prop('disabled',false);
            }else{
                buy_number=buy_number-1;
                $("#buy_number").val(buy_number);
                _this.prev('input').prop('disabled',false);
            }
        });
        //失去焦点
        $("#buy_number").blur(function(){
            var buy_number=$("#buy_number").val();
            //console.log(buy_number);
            var reg=/^[1-9]\d*$/;
            if(!reg.test(buy_number)){
                $("#buy_number").val(1);
            }else if(buy_number<=1){
                $("#buy_number").val(1);
            }else if(buy_number>=goods_num){
                $("#buy_number").val(goods_num);
            }
        });
        //加入购物车
        $("#carAdd").click(function(){
            var buy_number=$("#buy_number").val();
            var goods_id=$("#goods_id").val();
            //console.log(buy_number);
			//console.log(goods_id);
            $.ajax({
                url:'/carAdd',
                data:{buy_number:buy_number,goods_id:goods_id},
                dataType:'json',
                type:'post',
                async:false,
                success:function (res) {
                    console.log(res);
                }
            });
        });
    })
</script>