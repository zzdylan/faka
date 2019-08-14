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
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .text-center {
            text-align: center;
        }

        .wrapper {
            width: 760px;
            height: 608px;
            background-color: #ffffff;
            box-shadow: 1px 2px 20px 0 rgba(229, 229, 229, 0.8);
        }

        .pay-method {
            height: 50px;
            line-height: 50px;
            border-bottom: 2px dashed #f7f7f7;
        }

        .pay-method img {
            width: 40px;
            vertical-align: middle;
        }

        .price {
            margin-bottom: 10px;
        }

        .discount {
            color: #f9ae3a;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .qr-code {
            display: inline-block;
            width: 290px;
            height: 290px;
            position: relative;
        }

        #invalid-img {
            display: none;
            width: 80px;
            height: 80px;
            position: absolute;
            top: 50%;
            margin-top: -40px;
            left: 50%;
            margin-left: -40px;
        }

        .qr-code-invalid {
            opacity: 0.2;
        }

        #count {
            margin-top: 25px;
            margin-bottom: 35px;
            font-weight: normal;
        }

    </style>
</head>
<body>
<?php
switch ($order->pay_type){
    case 1:
        $payTypeStr = '微信';
        $payLogo = asset('images/wechat.jpg');
        break;
    case 2:
        $payTypeStr = '支付宝';
        $payLogo = asset('images/alipay.jpg');
        break;
}
?>
<div class="wrapper">
    <div class="text-center pay-method">
        <img src="{{$payLogo}}"
             alt="">
        <span>{{$payTypeStr}}支付</span>
    </div>
    <div class="text-center">
        <h1 class="price">￥{{$order->total_price}}</h1>
        <div class="qr-code">
            <img id="invalid-img"
                 src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBzdGFuZGFsb25lPSJubyI/PjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+PHN2ZyB0PSIxNTQ3NjM0MDE2MzQ0IiBjbGFzcz0iaWNvbiIgc3R5bGU9IiIgdmlld0JveD0iMCAwIDEwMjYgMTAyNCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHAtaWQ9IjIwMTIiIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMjAwLjM5MDYyNSIgaGVpZ2h0PSIyMDAiPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PC9zdHlsZT48L2RlZnM+PHBhdGggZD0iTTIwMy41MDMzMSA1MjguNzM5Yy0yNS40MjMtNi4yMi0zNC43MDItMjEuMDM1LTI3LjgxNS00NC40NzRsMjYuNDEyLTk4LjU2OSAzMi44NTcgOC44MDQtNS4xOTMgMTkuMzc3IDk5LjQxNCAyNi42MzkgMTAuODM2LTQwLjQ0LTEzOC4xNjctMzcuMDIxIDcuOTAyLTI5LjQ4NiAxNzEuMDIzIDQ1LjgyNS0yNi42MzkgOTkuNDEtMTMyLjI3MS0zNS40MzktMTEuMDYgNDEuMjgxYy0zLjU3OCAxMS4wOSAwLjMyNSAxNy44NTEgMTEuNzE4IDIwLjI5Nmw4MC4wMzcgMjEuNDQ1YzEzLjE3OCA0Ljc0NSAyMS45MDEgMS4zNTMgMjYuMTk0LTEwLjEzNiAwLjU5OS0yLjI0MSAyLjIwOC02LjAyNyA0Ljg0Ni0xMS4zNDUgMi4zNTktNi41OTMgNC4yNzktMTEuNDk2IDUuNzQ4LTE0LjcxNSAxMC44OTIgNi41MzIgMjAuOCAxMi4yMDYgMjkuNzU4IDE3LjAwNC01LjI5NiAxMy4wMjgtMTAuNTg1IDI0Ljg1OC0xNS44MzIgMzUuNDg3LTcuODgzIDE1Ljk0OC0yMy4yNjcgMjAuNTQ1LTQ2LjE0IDEzLjgyMmwtMTAzLjYyOC0yNy43NjV6IG0xODcuNzA1IDU5LjMyNWwtMi43NjUtMzYuODU4YzIuMTM1LTEuMjMzIDUuMjY0LTIuNzk1IDkuMzg4LTQuNzA2IDIuOTktMi4yMDUgOS42MTYtNS41NTEgMTkuODQ1LTEwLjAzNWwxMy4zMTktNDkuNzA3LTIyLjc0Ni02LjA5NCA3LjkwMS0yOS40ODggNTMuMDc1IDE0LjIyMi0yMS4yMTkgNzkuMTkxYzUuNDggMTcuNzI1IDE3LjI3OSAyOC43MTcgMzUuNDEzIDMyLjk2OCAyOS4wNDYgOC4zOTEgNjUuODM3IDE4LjI0OCAxMTAuMzY2IDI5LjU3Mi01LjQ4IDYuOTY4LTExLjA1NCAxNS4zOTQtMTYuNzE4IDI1LjMxOWwtNjQuODcyLTE3LjM4MmE3MzEyLjQwMiA3MzEyLjQwMiAwIDAgMS00NC4xOTktMTMuNjUyYy0yMS4zNTEtNS43MjItMzUuNzUyLTE3LjExMi00My4yMi0zNC4xNTQtMi44NTQgMS42NDctNi43NzMgMy44OTktMTEuNzUxIDYuNzg1LTExLjM5OCA2LjU2OS0xOC42NzYgMTEuMjUtMjEuODE3IDE0LjAxOXogbTY0LjEwMy0xMzguMTMxYy00LjUxNC0xNi44NTctOS41OTItMzMuODYzLTE1LjIyMS01MS4wMzNsMjkuNTAxLTUuNjRhOTI2LjE0MyA5MjYuMTQzIDAgMCAxIDE3LjgwOSA0OC4xMTNsLTMyLjA4OSA4LjU2eiBtNDYuMDI4IDgwLjk1N2MtMy41MTYtOS4zNjMtOC43MjgtMjIuNDk5LTE1LjYyOC0zOS40MDMtMS45MTQtNC4xMjMtMy4xOTctNy4xNzctMy44NjQtOS4xNmwyNy4wMzUtOS45MTRjOC4xODUgMTYuNjQzIDE1LjY3MiAzMi41MDQgMjIuNDcyIDQ3LjU1OWwtMzAuMDE1IDEwLjkxOHogbS0xNS41MzQtNzAuMDc5bDcuMjI1LTI2Ljk2IDc1LjgyMyAyMC4zMTUgOC44MDQtMzIuODU0IDMyLjAxNSA4LjU3OS04LjgwMyAzMi44NTQgMjYuMTE2IDYuOTk4LTcuMjI0IDI2Ljk2MS0yNi4xMTctNi45OTktMTYuOTMxIDYzLjE4NWMtNS41MDQgMjUuMDIyLTIwLjExOSAzNC42NTEtNDMuODU2IDI4Ljg4NC04LjAyNS0xLjU0NC0yMC40NDYtNC41NzUtMzcuMjk3LTkuMDkgMS42MjQtMTIuOCAyLjA4Mi0yMy41MTIgMS4zODgtMzIuMTM0YTU2NS43MzEgNTY1LjczMSAwIDAgMCAzMC4xMDMgOC45NjhjMTEuMDc4IDMuNTc1IDE3LjQ4OC0wLjEyNSAxOS4yMjktMTEuMTAzbDE1LjM1MS01Ny4yODktNzUuODI2LTIwLjMxNXogbTE3MS41MDcgMjguNzk4bDYuNzcxLTI1LjI3NCAxMC45NTIgMi45MzYgNC41MTctMTYuODUxIDI4LjY0MSA3LjY3NC00LjUxNCAxNi44NTIgMjguNjQ0IDcuNjc2IDQuNzQyLTE3LjY5MSAyOC42NDQgNy42NzQtNC43NDIgMTcuNjkgMTAuOTUyIDIuOTM2LTYuNzcxIDI1LjI3MS0xMC45NTItMi45MzMtMjIuOCA4NS4wOTEgMTQuMzIxIDMuODM4LTMuMTU5IDExLjc5NmM0LjU0LTEwLjIxMyA4Ljk5NS0yMy40NjggMTMuMzYzLTM5Ljc2NGwyNS4wNTctOTMuNTE2IDgwLjg4MSAyMS42NzQtNDUuMTUgMTY4LjQ5NWMtMy45MTEgMTQuNTk5LTEzLjA0OCAyMC41NzItMjcuMzgzIDE3Ljk0NWwtMTMuNDc4LTMuNjExYy04LjAyMS0xLjU1Ni0xMy43MDYtMi43Ny0xNy4wNzgtMy42NzMgMS40NzctMTIuMjQ2IDIuMTI3LTIxLjQxMSAxLjk0NC0yNy40NzMgNi43NDEgMS44MDcgMTIuNjM4IDMuMzg2IDE3LjY5IDQuNzQxIDcuMTQzIDIuNTIxIDExLjM0MSAwLjMzIDEyLjU5MS02LjU1OGw2Ljc3Ni0yNS4yNzUtMjUuMjc0LTYuNzcyYy05Ljc0MiAyNS4wODYtMjMuODg2IDQ0LjE2Ny00Mi40MzUgNTcuMjU2LTQuMjY1LTYuNTYyLTkuMTU3LTEyLjk5My0xNC42OTMtMTkuMjg3bC0xNy40ODQgNy45NTZjLTQuODU4LTEzLjM1LTEwLjgyNy0yNi45ODQtMTcuOTI3LTQwLjkyM2wyMC4yMzQtOC4xMjMtMzkuNTk2LTEwLjYwOSAxNS4xNDUgMTcuNjA0Yy0xNC44NSAxMC40NjgtMjguMzk4IDE5LjQ3OS00MC42NDkgMjcuMDMxLTQuMzgxLTguMzk3LTkuOTQzLTE2LjgxMy0xNi43MTItMjUuMjQ3IDEyLjM2NS01LjcxNiAyMy45MDEtMTIuODUzIDM0LjYzNC0yMS40MTlsLTI3LjgwMi03LjQ0OSA2Ljc3My0yNS4yNzQgMTMuNDc4IDMuNjExIDIyLjc5OS04NS4wOS0xMC45NS0yLjkzNXogbTIwLjQwNCA4Mi4yMjFsLTMuNjA4IDEzLjQ3OSAyOC42NDQgNy42NzUgMy42MS0xMy40OC0yOC42NDYtNy42NzR6IG05LjQ4MS0zNS4zODZsLTMuNjEgMTMuNDggMjguNjQ2IDcuNjc2IDMuNjA4LTEzLjQ3OS0yOC42NDQtNy42Nzd6IG05LjcwNy0zNi4yMjRsLTMuNjEgMTMuNDc5IDI4LjY0MyA3LjY3NCAzLjYxNC0xMy40NzktMjguNjQ3LTcuNjc0eiBtMjMuNzYxIDE0Ny4yMjhjNS43MjgtNS42ODggMTAuNy0xMS44NzcgMTQuOTA4LTE4LjU3OWwtMjguNjQ0LTcuNjc1YzQuNjMyIDkuNjc3IDkuMjA0IDE4LjQyMiAxMy43MzYgMjYuMjU0eiBtNjIuNjA2LTYxLjc4NGMtMC45MDMgMy4zNzEtMS44MDYgNi43NC0yLjcxMSAxMC4xMDlsMjQuNDMzIDYuNTQ3IDYuNTQ4LTI0LjQzMS0yNC40MzMtNi41NDctMy44MzcgMTQuMzIyeiBtMTcuODMyLTY2LjU1NWwtNi43NzEgMjUuMjc0IDI0LjQzIDYuNTQ3IDYuNzczLTI1LjI3My0yNC40MzItNi41NDh6TTUxMy4yODQzMSAyNzguNTY1Yzc2LjkxMSAwIDE0NS4xMjYgMzcuMjAxIDE4Ny42NTMgOTQuNTgzbDI5Ljc1MyA3Ljk3MmMtNDQuNDE0LTczLjYyLTEyNS4xNTktMTIyLjg1My0yMTcuNDA2LTEyMi44NTMtNDQuNTY3IDAtODYuNDQxIDExLjUwNS0xMjIuODQxIDMxLjY4N2wyOS42OTYgNy45NTZjMjguNTM2LTEyLjQzMiA2MC4wMzEtMTkuMzQ1IDkzLjE0NS0xOS4zNDV6IG0xNTMuMjg2LTEzLjIwMWwxNi4yODkgMTMuMjA0IDUuMDIzLTE5Ljc5MSAxOC4yMzQtMTAuNjU4LTE4LjIzNC0xMC42NTYtNS4wMjMtMTkuNzktMTYuMjg5IDEzLjIwNy0yMS4zNDUtMS41NzcgOC4xNjkgMTguODE4LTguMTY5IDE4LjgxNiAyMS4zNDUtMS41NzN6IG0tMjgyLjY2Mi00NC4yOWwtMTYuNzYtMTEuNjY0LTMuNjU4IDIwLjY1LTE3LjE1NiAxMi43OTIgMTguNTAxIDguODY3IDYuMTUzIDE5LjU2OSAxNS4wOTQtMTUuMTc0IDIwLjk1OS0wLjY5NS05LjE3MS0xOC4yNDIgNi44LTIwLjAwNC0yMC43NjIgMy45MDF6IG0xNTYuOTAyLTI4LjUzMmwtMTIuNDIxLTE2LjIwNy05Ljc2MyAxOC41NjMtMjAuMjMxIDYuOTcyIDE0LjkzIDE0LjA3LTAuMDg0IDIwLjUxNSAxOC45ODktOS44NjYgMjAuMTgxIDUuNzA3LTMuMTkyLTIwLjE2OSAxMi41NTYtMTYuOTg0LTIwLjk2NS0yLjYwMXogbTIyNy4xMDMgMTI3LjQ0MWwtMTcuNTk5LTEyLjE3OS0yLjUwMSAyMC4zNjItMTYuNTg0IDEyLjA3NSAxOS4xOTQgOS40NjMgNy4zNDcgMTkuNjQ2IDE0LjM2MS0xNC41MTEgMjEuMTI1IDAuMDYzLTEwLjMxNS0xOC40MzUgNS43MDgtMTkuNjA1LTIwLjczNiAzLjEyMXogbTIyOC41NTcgMTUzLjM3MUwxMTQuMTU4MzEgMjM2LjkzNmMtMjEuNjU3LTUuODAxLTQzLjkxNiA3LjA1My00OS43MjEgMjguNzFMMS4zOTUzMSA1MDAuOTI2Yy01LjgwMSAyMS42NTYgNy4wNSA0My45MTggMjguNzA2IDQ5LjcyM0w5MTIuNDEyMzEgNzg3LjA2MWMyMS42NTggNS44MDQgNDMuOTE5LTcuMDQ4IDQ5LjcyMy0yOC43MDZsNjMuMDQxLTIzNS4yODFjNS44MDMtMjEuNjU3LTcuMDUxLTQzLjkyMS0yOC43MDYtNDkuNzJ6IG02LjQ3IDU0LjI2OWwtNTcuNzg2IDIxNS42NzRjLTQuMzU0IDE2LjI0My0yMS4wNSAyNS44ODMtMzcuMjkxIDIxLjUzMUw0NS4xNTgzMSA1MzMuNjY5Yy0xNi4yNDMtNC4zNTQtMjUuODgtMjEuMDUtMjEuNTMxLTM3LjI5bDU3Ljc5Mi0yMTUuNjhjNC4zNTEtMTYuMjQzIDIxLjA0Ny0yNS44OCAzNy4yOTEtMjEuNTI3TDk4MS40MTMzMSA0OTAuMzNjMTYuMjQxIDQuMzU0IDI1Ljg4MiAyMS4wNTIgMjEuNTI3IDM3LjI5M3pNNTEzLjI4NDMxIDE0Ni42MjdjMTY5LjA5MiAwIDMxMS4zMjcgMTE0Ljg3IDM1Mi45OTYgMjcwLjgyNmwyMi40NjMgNi4wMTdjLTQwLjAwOC0xNzAuMzI5LTE5Mi45MjItMjk3LjE0Mi0zNzUuNDU4LTI5Ny4xNDItMTEwLjY3NyAwLTIxMC40NjIgNDYuNjI2LTI4MC43OTUgMTIxLjMwMmwyMi40MzkgNi4wMTNjNjYuMTE4LTY2LjEyMiAxNTcuNDYxLTEwNy4wMTYgMjU4LjM1NS0xMDcuMDE2eiBtOTMuMTQ4IDU3OS40NjFjLTI4LjUzNyAxMi40MzQtNjAuMDMzIDE5LjM0NC05My4xNDcgMTkuMzQ0LTc2LjkxIDAtMTQ1LjEyNS0zNy4yMDEtMTg3LjY1NC05NC41ODRsLTI5Ljc1NC03Ljk3M2M0NC40MTYgNzMuNjIxIDEyNS4xNTkgMTIyLjg1NCAyMTcuNDA4IDEyMi44NTQgNDQuNTY3IDAgODYuNDQzLTExLjUwNSAxMjIuODQyLTMxLjY4NWwtMjkuNjk1LTcuOTU2eiBtLTIxNy43ODQgNDIuMTQ0bC0xNi4xNjMtMTMuMTczLTQuOTc4IDE5Ljc0NS0xOC4wOSAxMC42MyAxOC4wOSAxMC42MzQgNC45NzggMTkuNzQzIDE2LjE2My0xMy4xNzIgMjEuMTY2IDEuNTctOC4xMDItMTguNzc0IDguMTAyLTE4Ljc3My0yMS4xNjYgMS41N3ogbTEyNC41NzMgNjIuNTIzbDEyLjMyIDE2LjE3MSA5LjY4Ni0xOC41MTkgMjAuMDY1LTYuOTU1LTE0LjgwOS0xNC4wMzcgMC4wODUtMjAuNDY2LTE4LjgzNCA5Ljg0MS0yMC4wMi01LjY5MiAzLjE2NiAyMC4xMTktMTIuNDUzIDE2Ljk0NiAyMC43OTQgMi41OTJ6TTI1Ni42MjgzMSA3MDMuMTY5bDE2LjU1MSAxMy4zNTYgMy45MS0yMC4wODkgMTcuMjU4LTEwLjg1NS0xOC4zMjItMTAuNzY0LTUuODg1LTIwLjA2My0xNS4yMzIgMTMuNDM2LTIwLjg5OC0xLjU0NSA4LjkwNyAxOS4wNjgtNy4wMyAxOS4xMDcgMjAuNzQxLTEuNjUxeiBtMjU2LjY1NiAxNzQuMjAzYy0xNjkuMDkgMC0zMTEuMzI5LTExNC44NzItMzUyLjk5NS0yNzAuODI2bC0yMi40NjItNi4wMTljNDAuMDA2IDE3MC4zMyAxOTIuOTIxIDI5Ny4xNDQgMzc1LjQ1NyAyOTcuMTQ0IDExMC42NzkgMCAyMTAuNDY0LTQ2LjYyNiAyODAuNzk4LTEyMS4zbC0yMi40MzgtNi4wMTNjLTY2LjEyMSA2Ni4xMi0xNTcuNDYzIDEwNy4wMTQtMjU4LjM2IDEwNy4wMTR6IG0xNDYuNzM2LTc0LjQ4bDE2LjY1MyAxMS42NTMgMy41OTItMjAuNTg4IDE3LjAwMy0xMi43MjgtMTguMzc4LTguODY2LTYuMTQ0LTE5LjUyNC0xNC45NTEgMTUuMTA4LTIwLjgwMSAwLjY2NyA5LjEzNyAxOC4yLTYuNzA3IDE5LjkzMyAyMC41OTYtMy44NTV6IiBwLWlkPSIyMDEzIj48L3BhdGg+PC9zdmc+"
                 alt="">
            <img id="qr-code-img" width="100%"
                 src="{{$payQrcode}}"
                 alt="">
        </div>
        <h2 id="count"></h2>
        <div>打开{{$payTypeStr}}扫一扫</div>
    </div>
</div>
{{--<script>--}}
{{--    const countDown = (second) => {--}}
{{--        const s = second % 60;--}}
{{--        const m = Math.floor(second / 60);--}}
{{--        return `${`0${m}`.slice(-2)}:${`0${s}`.slice(-2)}`;--}}
{{--    };--}}

{{--    let time = {{$result['remain_seconds']}};--}}

{{--    const timer = setInterval(() => {--}}
{{--        document.getElementById('count').innerHTML = countDown(time--);--}}
{{--        if (time < 0) {--}}
{{--            document.getElementById('qr-code-img').className = 'qr-code-invalid';--}}
{{--            document.getElementById('invalid-img').style.display = 'block';--}}
{{--            clearInterval(timer);--}}
{{--        }--}}
{{--    }, 1000);--}}
{{--</script>--}}
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