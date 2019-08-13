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

    <link href="/css/page.css" rel="stylesheet">
    <script src="/js/jquery.js"></script>
    <title>商品展示</title>
</head>
<body>
    <div class="list_c" id="show">
        <ul class="cate_list">
            @foreach($data as $v)
                <li>
                    <div class="img"><a href="/goodsdetail/{{$v->goods_id}}">
                            <img src="storage/{{$v->goods_img}}" width="210" height="185" /></a></div>
                    <div class="price">
                        <font>￥<span>{{$v->price}}</span></font> &nbsp;
                    </div>
                    <div class="name"><a href="/goodsdetail/{{$v->goods_id}}">{{$v->goods_name}}</a></div>
                    <div class="carbg">
                        <a href="javascript:void(0)" class="ss">收藏</a>
                        <a href="javascript:void(0)" class="j_car">加入购物车</a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
{{ $data->links() }}
</body>
</html>