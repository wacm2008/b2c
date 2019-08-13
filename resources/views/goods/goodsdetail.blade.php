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
<div class="pro_des">
    <div class="des_name">
        <p></p>
    </div>
    <div class="des_price">
        本店价格：<b>￥</b><br />
    </div>
    <div class="des_choice">
        <span class="fl">颜色：</span>
        <ul>
            <li class="checked">银色<div class="ch_img"></div></li>
            <li>深空灰<div class="ch_img"></div></li>
            <li>金色<div class="ch_img"></div></li>
        </ul>
    </div>
    <div class="des_choice">
        <span class="fl">内存：</span>
        <ul>
            <li>64G<div class="ch_img"></div></li>
            <li class="checked">256G<div class="ch_img"></div></li>
        </ul>
    </div>
    <div class="des_join">
        <div class="j_nums">
            <input type="text" value="1" id="buy_number" class="n_ipt" />
            <input type="button" id="more" class="n_btn_1" />
            <input type="button" id="less" class="n_btn_2" />
        </div>
        库存(<font color="red" size="3" id="goods_num"></font>)件
        <span class="fl"><a id="carAdd"><img src="/index/images/j_car.png" /></a></span>
    </div>
</div>
</body>
</html>