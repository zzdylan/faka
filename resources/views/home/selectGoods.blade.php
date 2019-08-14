@extends('home.layout')
@section('content')
<div class="layui-row">
    <div class="layui-col-md6">
        <div class="layui-card">
            <div class="layui-card-header">购买商品</div>
            <div class="layui-card-body">
                <form class="layui-form layui-form-pane" action="" lay-filter="goodsForm">
                    <div class="layui-form-item">
                        <label class="layui-form-label">商品分类</label>
                        <div class="layui-input-block">
                            <select id="category-view" name="category_id" lay-filter="categorySelect" lay-verify="required">
                                <option value="">请选择商品分类</option>
                                @foreach($categories as $category)
                                    <option @if(isset($currentGoods) && ($currentGoods->category->id == $category->id)) selected @endif value="{{$category->id}}">{{$category->name}}</option>
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
                            <input type="number" name="count" required lay-verify="required" autocomplete="off"
                                   class="layui-input" value="1">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">邮箱</label>
                        <div class="layui-input-block">
                            <input type="text" name="email" placeholder="请仔细输入正确邮箱，用于接收通知" required lay-verify="required|email"
                                   autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div id="email-and-password">

                    </div>
                    <div id="first-input">

                    </div>
                    <div id="more-input">

                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">支付方式</label>
                        <div class="layui-input-block">
                            <input type="radio" name="pay_type" value="1" title="微信" checked>
                            <input type="radio" name="pay_type" value="2" title="支付宝" >
                        </div>
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
@endsection
@section('script')
<script id="goods" type="text/html">
    <option value="">请选择商品</option>
    @{{#  layui.each(d, function(index, item){ }}
    <option value="@{{item.id}}">@{{item.text}}</option>
    @{{#  }); }}
</script>

<script id="email-and-password-tpl" type="text/html">
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
<script id="pay-account-input-tpl" type="text/html">
    <div class="layui-form-item">
        <label class="layui-form-label">@{{ d }}</label>
        <div class="layui-input-block">
            <input type="text" name="pay_account" placeholder="请输入@{{ d }}"
                   autocomplete="off" class="layui-input">
        </div>
    </div>
</script>
<script>
    layui.use(['jquery', 'form', 'laytpl','layer'], function () {
        var form = layui.form;
        var laytpl = layui.laytpl;
        var $ = layui.$;
        var layer = layui.layer;
        var getGoodsList = function(categoryId,callback=''){
            $.get('/api/goods?q=' + categoryId, function (goodsData) {
                var getTpl = $('#goods').html();
                laytpl(getTpl).render(goodsData, function (html) {
                    $('#goods-view').html(html);
                    form.render('select');
                    if(typeof callback == 'function'){
                        callback();
                    }
                });
            });
        }
        var getGoodsDetail = function (goodsId) {
            $.get('/api/goods/' + goodsId, function (res) {
                $('#price').val(res.price);
                $('#goods_stock').val(res.goods_stock);
                $('#goods-introduce').html(res.introduce);
                if (res.type == 1) {
                    $('#email-and-password').html('');
                    var getTpl1 = $('#pay-account-input-tpl').html();
                    if(res.first_input){
                        laytpl(getTpl1).render(res.first_input, function (html) {
                            $('#first-input').html(html);
                        });
                    }
                    var getTpl2 = $('#more-input-tpl').html();
                    if(res.more_input){
                        laytpl(getTpl2).render(res.more_input, function (html) {
                            $('#more-input').html(html);
                        });
                    }
                } else if(res.type == 2){
                    $('#first-input').html('');
                    $('#more-input').html('');
                    var emailAndPassword = $('#email-and-password-tpl').html();
                    $('#email-and-password').html(emailAndPassword);
                }
            });
        }
        form.on('select(categorySelect)', function (data) {
            var categoryId = data.value;
            getGoodsList(categoryId);
        });
        @if(isset($currentGoods))
        getGoodsList({{$currentGoods->category->id}},function(){
            $("select[name='goods_id']").val({{$currentGoods->id}});
            form.render('select');
        });
        getGoodsDetail({{$currentGoods->id}});
        @endif
        form.on('select(goodsSelect)', function (data) {
            var goodsId = data.value;
            getGoodsDetail(goodsId);
        });
        form.on('submit(confirmPay)', function(data){
            $.post('/api/orders',data.field,function(res){
                if(res.code === 1){
                    window.parent.location.href = '/orders/'+res.data.order_id;
                }else{
                    layer.msg(res.message);
                }
            });
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });

    });
</script>
@endsection