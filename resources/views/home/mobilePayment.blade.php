<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>支付订单</title>
	
	<link rel="stylesheet" href="/css/mobile_pay.css" type="text/css"/>
	
	<script type="text/javascript" src="/js/jquery-1.8.2.min.js" ></script>
	
</head>
	
<body>
<!--头部  star-->
<header style="color:#fff">
	<a href="javascript:history.go(-1);">
		<div class="_left"><img src="/images/left.png"></div><span>支付订单</span></a>
</header>
<!--头部 end-->
<!--内容 star-->
<div class="contaniner fixed-cont">
	<div class="pay_img"><img src="/images/pay.jpg"></div>
    
    <div class="payTime">
    	<!-- <li><span>剩余时间14:56</span></li> -->
        <li><strong>¥{{$order->total_price}}</strong></li>
        <li>订单号:{{$order->trade_no}}</li>
    </div>
    
    <!--支付 star-->
	<!-- <div class="pay">
		<div class="show">
			<li><label><img src="static/picture/weixin.png" >微信支付<input name="Fruit" type="radio" value="" checked/><span></span></label> </li>
    		<li><label><img src="static/picture/zhifubao.png" >支付宝支付<input name="Fruit" type="radio" value="" /><span></span></label> </li>
    		<li><label><img src="static/picture/yue.png" >余额支付<input name="Fruit" type="radio" value="" /><span></span></label> </li>
    		<li class="center"><a href="#" onClick="showHideCode()">查看更多支付方式↓</a></li>
		</div>
		<div class="showList" id = "showdiv" style="display:none;">
			<li><label><img src="static/picture/yinhang.png" >银行卡<input name="Fruit" type="radio" value="" /><span></span></label> </li>
            <li><label><img src="static/picture/weixin.png" >添加更多<input name="Fruit" type="radio" value=""/><span></span></label> </li>
            
            <li style="background:none" ></li>
		</div>
	</div>  -->
    <!--支付 end--> 
    
    
</div>

    
<div class="book-recovery-bot2" id="footer">
	<a href="#"><div class="payBottom">
		@if($order->status == 0)
    	<li class="textfr">确认支付:</li>
        <li class="textfl"><span>¥{{$order->total_price}}</span></li>
        @else
        <li class="textfr">支付成功</li>
        @endif
    </div>
	</a>
</div> 
<!--内容 end-->
        

<script type="text/javascript">
function showHideCode(){
 	$("#showdiv").toggle();
}
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
    @if($order->stauts == 0)

		@if(is_weixin() && $order->pay_type == 1)
		$('#footer').click(function(){
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest', {
					// 以下6个支付参数通过payjs的jsapi接口获取
					// **************************
					"appId": "{{$pay_data['appId']}}",
					"timeStamp": "{{$pay_data['timeStamp']}}",
					"nonceStr": "{{$pay_data['nonceStr']}}",
					"package": "{{$pay_data['package']}}",
					"signType": "{{$pay_data['signType']}}",
					"paySign": "{{$pay_data['paySign']}}"
					// **************************
				},
				function (res) {
					if (res.err_msg == "get_brand_wcpay_request:ok") {
						//WeixinJSBridge.call('closeWindow');
						alert('支付成功');
					}
				}
			);
		});
		@endif

		@if($order->pay_type == 2)
			$('#footer').click(function(){
				location.href = '{{$code_url}}';
			});
		@endif

    @endif
</script>

</body>
</html>