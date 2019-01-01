

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="Content-Language" content="zh-cn">
    <meta name="renderer" content="webkit">
    <title>支付宝当面付 - </title>

    <style type="text/css">


        html {
            font-size: 62.5%;
            font-family: 'helvetica neue', tahoma, arial, 'hiragino sans gb', 'microsoft yahei', 'Simsun', sans-serif
        }

        body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, button, textarea, p, blockquote, th, td, hr {
            margin: 0;
            padding: 0
        }

        body {
            line-height: 1.333;
            font-size: 12px
        }

        h1, h2, h3, h4, h5, h6 {
            font-size: 100%;
            font-family: arial, 'hiragino sans gb', 'microsoft yahei', 'Simsun', sans-serif
        }

        input, textarea, select, button {
            font-size: 12px;
            font-weight: normal
        }

        input[type="button"], input[type="submit"], select, button {
            cursor: pointer
        }

        table {
            border-collapse: collapse;
            border-spacing: 0
        }

        address, caption, cite, code, dfn, em, th, var {
            font-style: normal;
            font-weight: normal
        }

        li {
            list-style: none
        }

        caption, th {
            text-align: left
        }

        q:before, q:after {
            content: ''
        }

        abbr, acronym {
            border: 0;
            font-variant: normal
        }

        sup {
            vertical-align: text-top
        }

        sub {
            vertical-align: text-bottom
        }

        fieldset, img, a img, iframe {
            border-width: 0;
            border-style: none
        }

        img {
            -ms-interpolation-mode: bicubic
        }

        textarea {
            overflow-y: auto
        }

        legend {
            color: #000
        }

        a:link, a:visited {
            text-decoration: none
        }

        hr {
            height: 0
        }

        label {
            cursor: pointer
        }

        .clearfix:after {
            content: "\200B";
            display: block;
            height: 0;
            clear: both
        }

        .clearfix {
            *zoom: 1
        }

        a {
            color: #328CE5
        }

        a:hover {
            color: #2b8ae8;
            text-decoration: none
        }

        a.hit {
            color: #C06C6C
        }

        a:focus {
            outline: none
        }

        .hit {
            color: #8DC27E
        }

        .txt_auxiliary {
            color: #A2A2A2
        }

        .clear {
            *zoom: 1
        }

        .clear:before, .clear:after {
            content: "";
            display: table
        }

        .clear:after {
            clear: both
        }

        body, .body {
            background: #f7f7f7;
            height: 100%
        }

        .mod-title {
            height: 60px;
            line-height: 60px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            background: #fff
        }

        .mod-title .ico-wechat {
            display: inline-block;
            width: 41px;
            height: 36px;
            background: url("./alipay-pay.png") 0 -115px no-repeat;
            vertical-align: middle;
            margin-right: 7px
        }

        .mod-title .text {
            font-size: 20px;
            color: #333;
            font-weight: normal;
            vertical-align: middle
        }

        .mod-ct {
            width: 610px;
            padding: 0 135px;
            margin: 0 auto;
            margin-top: 15px;
            background: #fff url("./wave.png") top center repeat-x;
            text-align: center;
            color: #333;
            border: 1px solid #e5e5e5;
            border-top: none
        }

        .mod-ct .order {
            font-size: 20px;
            padding-top: 30px
        }

        .mod-ct .amount {
            font-size: 48px;
            margin-top: 20px
        }

        .mod-ct .qr-image {
            margin-top: 30px
        }

        .mod-ct .qr-image img {
            width: 230px;
            height: 230px
        }

        .mod-ct .detail {
            margin-top: 60px;
            padding-top: 25px
        }

        .mod-ct .detail .arrow .ico-arrow {
            display: inline-block;
            width: 20px;
            height: 11px;
            background: url("./mqq-pay.png") -25px -100px no-repeat
        }

        .mod-ct .detail .detail-ct {
            display: none;
            font-size: 14px;
            text-align: right;
            line-height: 28px
        }

        .mod-ct .detail .detail-ct dt {
            float: left
        }

        .mod-ct .detail-open {
            border-top: 1px solid #e5e5e5
        }

        .mod-ct .detail .arrow {
            padding: 6px 34px;
            border: 1px solid #e5e5e5
        }

        .mod-ct .detail .arrow .ico-arrow {
            display: inline-block;
            width: 20px;
            height: 11px;
            background: url("./mqq-pay.png") -25px -100px no-repeat
        }

        .mod-ct .detail-open .arrow .ico-arrow {
            display: inline-block;
            width: 20px;
            height: 11px;
            background: url("./mqq-pay.png") 0 -100px no-repeat
        }

        .mod-ct .detail-open .detail-ct {
            display: block
        }

        .mod-ct .tip {
            margin-top: 40px;
            border-top: 1px dashed #e5e5e5;
            padding: 30px 0;
            position: relative
        }

        .mod-ct .tip .ico-scan {
            display: inline-block;
            width: 56px;
            height: 55px;
            background: url("./mqq-pay.png") 0 0 no-repeat;
            vertical-align: middle;
            *display: inline;
            *zoom: 1
        }

        .mod-ct .tip .tip-text {
            display: inline-block;
            vertical-align: middle;
            text-align: left;
            margin-left: 23px;
            font-size: 16px;
            line-height: 28px;
            *display: inline;
            *zoom: 1
        }

        .mod-ct .tip .dec {
            display: inline-block;
            width: 22px;
            height: 45px;
            background: url("./mqq-pay.png") 0 -55px no-repeat;
            position: absolute;
            top: -23px
        }

        .mod-ct .tip .dec-left {
            background-position: 0 -55px;
            left: -136px
        }

        .mod-ct .tip .dec-right {
            background-position: -25px -55px;
            right: -136px
        }

        .foot {
            text-align: center;
            margin: 30px auto;
            color: #888888;
            font-size: 12px;
            line-height: 20px;
            font-family: "simsun"
        }

        .foot .link {
            color: #0071ce
        }


    </style>

<body>
<div class="body">
    <h1 class="mod-title">
        <span class="ico-wechat"></span><span class="text">快捷支付</span>
    </h1>
    <div class="mod-ct">
        <div class="order">
        </div>
        <div class="amount">￥0.01</div>
        <div class="qr-image" id="" title="">
            <canvas width="230" height="230" style="display: none;"></canvas>
            <img src="{{$result['qr_code']}}" title="请使用微信或者支付宝“扫一扫”" style=""></div>

        <div class="detail" id="orderDetail">
            <dl class="detail-ct" style="display: block;" >
                <dt>购买物品</dt>
                <dd id="productName">{{$order->name}}</dd>
                <dt>商户订单号</dt>
                <dd id="billId">{{$order->trade_no}}</dd>
            </dl>

        </div>
        <div class="tip">
            <div class="tip-text">
                <p>请使用手机微信或者支付宝扫一扫</p>
                <p>扫描二维码完成支付</p>
            </div>
        </div>
        <div class="tip-text">
        </div>
    </div>
    <div class="foot">

    </div>
</div>
<div style="width:720px;height:380px;display:none;">
    <div id="video-dialog"></div>
    <a href="javascript:void(0);" onclick="return false;" style="position:absolute;right:-25px;top:-20px;"
       id="close_video_btn" class="ico-video-close"></a></div>
<script src="https://cdn.bootcss.com/jquery/2.2.3/jquery.min.js"></script>
<script>

    // 检查是否支付完成
    function loadmsg() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/api/orders/{{$order->id}}",
            timeout: 10000, //ajax请求超时时间10s
            success: function (data, textStatus) {
                //从服务器得到数据，显示数据并继续查询
                if (data.status == 1) {
                    alert('支付成功，点击跳转中...');
                    window.location.href = '/';
                } else {
                    setTimeout("loadmsg()", 4000);
                }
            },
            //Ajax请求超时，继续查询
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (textStatus == "timeout") {
                    setTimeout("loadmsg()", 1000);
                } else { //异常
                    setTimeout("loadmsg()", 4000);
                }
            }
        });
    }

    window.onload = loadmsg();
</script>
</body>
</html>
