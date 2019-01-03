@extends('home.layout')
@section('content')
<form class="layui-form">
    <blockquote class="layui-elem-quote quoteBox">
        <form class="layui-form">
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input type="text" class="layui-input searchVal" placeholder="充值账号搜索" />
                </div>
                <a class="layui-btn search_btn" data-type="reload">搜索</a>
            </div>
            <div class="layui-inline">
                <select class="type" name="type" lay-verify="">
                    <option value="">请选择发卡类型</option>
                    <option selected value="1">手动发卡</option>
                    <option value="2">自动发卡</option>
                </select>
            </div>
        </form>
    </blockquote>
    <table id="ordersList" lay-filter="ordersList"></table>
    <!--订单状态-->
    <script type="text/html" id="ordersStatus">
        {{--0未支付 1已支付,正在处理中 2已过期 3处理成功 4处理失败--}}
        @{{#  if(d.status == 0){ }}
        未支付
        @{{#  } else if(d.status == 1){ }}
        已支付,正在处理中
        @{{#  } else if(d.status == 2){ }}
        已过期
        @{{#  } else if(d.status == 3){ }}
        处理成功
        @{{#  } else if(d.status == 4){ }}
        处理失败
        @{{#  } else { }}

        @{{#  }}}
    </script>

    <!--操作-->
    <script type="text/html" id="ordersListBar">
        {{--<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>--}}
        {{--<a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>--}}
        <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="look">查看</a>
    </script>
</form>
@endsection
@section('script')
<script>
    layui.use(['form','layer','laydate','table','laytpl'],function(){
        var form = layui.form,
            layer = parent.layer === undefined ? layui.layer : top.layer,
            $ = layui.jquery,
            laydate = layui.laydate,
            laytpl = layui.laytpl,
            table = layui.table;

        //订单列表
        var tableIns = table.render({
            elem: '#ordersList',
            url : '/api/orders',
            parseData: function(res){ //res 即为原始返回的数据
                if(!res){
                    return {
                        "code": 0, //解析接口状态
                        "msg": '', //解析提示文本
                        "count": 0, //解析数据长度
                        "data": [] //解析数据列表
                    };
                }
                return {
                    "code": 0, //解析接口状态
                    "msg": '', //解析提示文本
                    "count": res.total, //解析数据长度
                    "data": res.data //解析数据列表
                };
            },
            cellMinWidth : 95,
            page : true,
            height : "full-125",
            limit : 20,
            limits : [10,15,20,25],
            id : "ordersListTable",
            cols : [[
                {type: "checkbox", fixed:"left", width:50},
                {field: 'id', title: 'ID', width:60, align:"center"},
                {field: 'name', title: '订单名称', align:'center'},
                {field: 'type', title: '订单类型', align:'center'},
                {field: 'count', title: '充值数量',  align:'center'},
                {field: 'unit_price', title: '商品单价', align:'center'},
                {field: 'total_price', title: '订单总价', align:'center'},
                {field: 'pay_type', title: '充值方式', align:'center'},
                {field: 'status', title: '状态', align:'center',templet:"#ordersStatus"},
                {field: 'created_at', title: '下单时间', align:'center',width:180},
                {title: '操作', width:170, templet:'#ordersListBar',fixed:"right",align:"center"}
            ]]
        });

        //搜索【此功能需要后台配合，所以暂时没有动态效果演示】
        $(".search_btn").on("click",function(){
            if($(".searchVal").val() != ''){
                table.reload("ordersListTable",{
                    page: {
                        curr: 1 //重新从第 1 页开始
                    },
                    where: {
                        search: $(".searchVal").val(),  //搜索的关键字,
                        type: $(".type").val()
                    }
                })
            }else{
                layer.msg("请输入搜索的内容");
            }
        });
        //列表操作
        table.on('tool(ordersList)', function(obj){
            var layEvent = obj.event,
                data = obj.data;
            if(layEvent === 'look'){ //查看
                if(data.type == 1){
                    layer.open({
                        type: 1,
                        skin: 'layui-layer-rim', //加上边框
                        area: ['420px', '240px'], //宽高
                        content: data.pay_account
                    });
                }else if(data.type == 2){
                    layer.prompt({title: '输入密码', formType: 1}, function(pass, index){
                        layer.close(index);
                        $.post('/api/orders/data/'+data.id,{password:pass},function(res){
                            if(res.code === 0){
                                layer.open({
                                    type: 1,
                                    skin: 'layui-layer-rim', //加上边框
                                    area: ['420px', '240px'], //宽高
                                    content: res.data
                                });
                            }else{
                                layer.msg(res.message);
                            }
                        });
                        //验证成功

                    });
                }
            }
        });
    })
</script>
@endsection