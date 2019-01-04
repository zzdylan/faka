<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>支付</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            color: #333;
            height: 100%;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .text-center {
            text-align: center;
        }

        header {
            height: 50px;
            line-height: 50px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }

        header img {
            vertical-align: middle;
            width: 40px;
        }

        section {
            background-color: #f7f7f7;
            padding: 30px 0 50px;
        }

        .info-wrapper {
            width: 880px;
            margin: auto;
            padding-top: 10px;
            background-color: #fff;
        }

        .info-wrapper .price {
            padding: 30px 0;
            margin: 0;
            font-size: 46px;
        }

        .info-wrapper .qr-code img {
            width: 216px;
            height: 216px;
        }

        .order-info {
            width: 612px;
            margin: 80px auto 0;
            padding-bottom: 30px;
            border-bottom: 1px dashed #e5e5e5;
        }

        .order-info .info-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }

        .footer {
            padding: 36px 0;
        }
    </style>
</head>
<body>
<header>
    <img src="data:image/jpeg;base64,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brfzMPqOG/kRzP8Awgeh/wDPB/8Av4aP+ED0P/ng/wD38NdNg0YNH1ut/Mw+o4b+RHM/8IHof/PB/wDv4aP+ED0P/ng//fw102DRg0fW638zD6jhv5Ecz/wgeh/88H/7+Gj/AIQPQ/8Ang//AH8NdNg0YNH1ut/Mw+o4b+RHM/8ACB6H/wA8H/7+Gj/hA9D/AOeD/wDfw102DRg0fW638zD6jh/5Ecz/AMIHof8Azwf/AL+Gj/hA9D/54P8A9/DXTYNGDR9brfzMPqOH/kRzP/CB6H/zwf8A7+Gj/hA9D/54P/38NdNg0YNH1ut/Mw+o4f8AkRzP/CB6H/zwf/v4aP8AhA9D/wCeD/8Afw102DRg0fW638zD6jh/5Ecz/wAIHof/ADwf/v4aP+ED0PH+of8A7+GumwaMGj61W/mYfUcP/IjnIvBGhRMG+ybv95ya1rTS7Gx4tLWKHtlEAP51exRiplVqS3bNIYalT+GKQgGKcKSlrI2CiiimMKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAP/2Q=="
         alt="">
    <span>快捷支付</span>
</header>
<section>
    <div class="info-wrapper">
        <h1 class="text-center price">￥{{$order->total_price}}</h1>
        <div class="qr-code text-center">
            <img src="{{$result['qr_code']}}"
                 alt="">
        </div>
        <div class="order-info">
            <div class="info-item">
                <span>购买物品</span>
                <span>{{$order->name}}</span>
            </div>
            <div class="info-item">
                <span>商户订单号</span>
                <span>{{$order->trade_no}}</span>
            </div>
        </div>
        <div class="footer text-center">
            请使用手机微信或者支付宝扫一扫<br>
            扫描二维码完成支付
        </div>
    </div>

</section>
<script src="https://cdn.bootcss.com/jquery/2.2.3/jquery.min.js"></script>
<script>

    // 检查是否支付完成
    function checkPayStatus() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/api/orders/{{$order->id}}",
            timeout: 10000, //ajax请求超时时间10s
            success: function (data, textStatus) {
                //从服务器得到数据，显示数据并继续查询
                if (data.status == 1 || data.status == 3) {
                    alert('支付成功，点击跳转中...');
                    window.location.href = '/';
                } else {
                    setTimeout("checkPayStatus()", 4000);
                }
            },
            //Ajax请求超时，继续查询
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (textStatus == "timeout") {
                    setTimeout("checkPayStatus()", 1000);
                } else { //异常
                    setTimeout("checkPayStatus()", 4000);
                }
            }
        });
    }

    window.onload = checkPayStatus();
</script>
</body>
</html>