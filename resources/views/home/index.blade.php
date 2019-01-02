@extends('home.layout')
@section('content')
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md6">
            <div class="layui-card">
                <div id="test"></div>
                <div class="layui-card-header">购买商品</div>
                <div class="layui-card-body">
                    <form class="layui-form" action="{{url('')}}">
                        <div class="layui-form-item">
                            <label class="layui-form-label">商品分类</label>
                            <div class="layui-input-block">
                                <select name="category_id" lay-filter="categorySelect" lay-verify="required">
                                    <option value="">请选择商品分类</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">商品列表</label>
                            <div class="layui-input-block">
                                <select lay-filter="goodsSelect" id="goods-view" name="goods_id" lay-verify="required">
                                    <option value="">请选择商品</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">商品单价</label>
                            <div class="layui-input-block">
                                <input disabled="disabled" id="price" type="text" name="price" required
                                       lay-verify="required" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">商品库存</label>
                            <div class="layui-input-block">
                                <input disabled="disabled" id="goods_stock" type="text" name="goods_stock" required
                                       lay-verify="required" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">购买数量</label>
                            <div class="layui-input-block">
                                <input type="text" name="count" required lay-verify="required" autocomplete="off"
                                       class="layui-input" value="1">
                            </div>
                        </div>
                        <div id="email-and-password">

                        </div>
                        <div id="more-input">

                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button id="confirmPayBtn" class="layui-btn" lay-submit="" lay-filter="confirmPay">确认购买</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header">商品详情</div>
                <div id="goods-introduce" class="layui-card-body">

                </div>
            </div>
        </div>
    </div>
    <script id="goods" type="text/html">
        <option value="">请选择商品</option>
        @{{#  layui.each(d, function(index, item){ }}
        <option value="@{{item.id}}">@{{item.text}}</option>
        @{{#  }); }}
    </script>

    <script id="email-and-password-tpl" type="text/html">
        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-block">
                <input type="text" name="email" placeholder="请仔细输入正确邮箱，接收卡密使用" required lay-verify="required|email"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">查询密码</label>
            <div class="layui-input-block">
                <input type="text" name="password" placeholder="请仔细查询密码，作为查询重要依据" required lay-verify="required"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
    </script>

    <script id="more-input-tpl" type="text/html">
        @{{#  layui.each(d, function(index, item){ }}
        <div class="layui-form-item">
            <label class="layui-form-label">@{{ item }}</label>
            <div class="layui-input-block">
                <input type="text" name="more_input_value[]" placeholder="请输入@{{ item }}"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        @{{#  }); }}

    </script>
@endsection
@section('script')
    <script>
        layui.use(['jquery', 'form', 'laytpl','layer'], function () {
            var form = layui.form;
            var laytpl = layui.laytpl;
            var $ = layui.$;
            var layer = layui.layer;
            form.on('select(categorySelect)', function (data) {
                var categoryId = data.value;
                $.get('/api/goods?q=' + categoryId, function (goodsData) {
                    var getTpl = $('#goods').html();
                    laytpl(getTpl).render(goodsData, function (html) {
                        $('#goods-view').html(html);
                        form.render('select');
                    });
                });
            });

            form.on('select(goodsSelect)', function (data) {
                var goodsId = data.value;
                getGoods(goodsId);
            });

            form.on('submit(confirmPay)', function(data){
                $.post('/api/orders',data.field,function(res){
                    if(res.code === 1){
                        location.href = '/orders/'+res.data.order_id+'/pay';
                    }else{
                        layer.msg(res.message);
                    }
                });
                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });

            var getGoods = function (goodsId) {
                $.get('/api/goods/' + goodsId, function (res) {
                    $('#price').val(res.price);
                    $('#goods_stock').val(res.goods_stock);
                    $('#goods-introduce').html(res.introduce);
                    if (res.type == 1) {
                        $('#email-and-password').html('');
                        var getTpl = $('#more-input-tpl').html();
                        laytpl(getTpl).render(res.more_input, function (html) {
                            $('#more-input').html(html);
                        });
                    } else if(res.type == 2){
                        $('#more-input').html('');
                        var emailAndPassword = $('#email-and-password-tpl').html();
                        $('#email-and-password').html(emailAndPassword);
                    }
                });
            }

            var notice = function(){
                //示范一个公告层
                layer.open({
                    type: 1
                    ,title: false //不显示标题栏
                    ,closeBtn: false
                    ,area: '300px;'
                    ,shade: 0.8
                    ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
                    ,btn: ['火速围观', '残忍拒绝']
                    ,btnAlign: 'c'
                    ,moveType: 1 //拖拽模式，0或者1
                    ,content: '<div style="text-align:center;padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">去github给个star呗</div>'
                    ,success: function(layero){
                        var btn = layero.find('.layui-layer-btn');
                        btn.find('.layui-layer-btn0').attr({
                            href: 'https://github.com/zzDylan/faka'
                            ,target: '_blank'
                        });
                    }
                });
            }
            notice();
        });
    </script>
@endsection