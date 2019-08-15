<?php

namespace App\Admin\Controllers;

use App\Events\OrderShipped;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Admin\Extensions\Tools\HandleOrders;
use Illuminate\Http\Request;
use App\Admin\Extensions\OrdersExporter;

class OrderController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('订单')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);
        $grid->exporter(new OrdersExporter());
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->add('处理成功', new HandleOrders(Order::SUCCESS));
                $batch->add('处理失败', new HandleOrders(Order::ERROR));
            });
        });
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            //$actions->disableView();
        });
        $grid->model()->orderBy('id', 'desc');
        $grid->id('订单id');
        $grid->trade_no('订单号');
        $grid->name('订单名称');
        $grid->goods_name('商品名称');
        $grid->unit_price('商品单价');
        $grid->count('购买数量');
        $grid->total_price('订单总价');
        $grid->pay_account('充值账号');
        $grid->email('邮件');
        $grid->type('订单类型')->display(function ($type) {
            switch ($type) {
                case 1:
                    return '<span class="label label-primary">手动发卡</span>';
                case 2:
                    return '<span class="label label-success">自动发卡</span>';
            }
        });
        $grid->out_trade_no('第三方支付号');
        $grid->pay_type('支付方式')->display(function ($payType) {
            switch ($payType) {
                case 1:
                    return '<span class="label label-success">微信支付</span>';
                case 2:
                    return '<span class="label label-info">支付宝支付</span>';
                default:
                    return '';
            }
        });
        $grid->password('查询密码')->display(function ($password) {
            return $this->password;
        });
        $grid->status('订单状态')->display(function ($status) {
            switch ($status) {
                case 0:
                    return '<span class="label label-default">未支付</span>';
                case 1:
                    return '<span class="label label-primary">已支付</span>';
                case 2:
                    return '<span class="label label-warning">过期</span>';
                case 3:
                    return '<span class="label label-success">处理成功</span>';
                case 4:
                    return '<span class="label label-danger">处理失败</span>';
            }
        });
        $grid->ip('ip');
        $grid->created_at('创建时间');
        $grid->pay_time('支付时间');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->id('ID');
        $show->trade_no('订单号');
        $show->name('订单名称');
        $show->total_price('订单总价');
        $show->more_input_value('表单')->unescape()->as(function ($more_input_value) {
            $string = '';
            $input_arr = json_decode($more_input_value, true);
            foreach ($input_arr as $key => $v) {
                $string = $string . $v['name'] . ':' . $v['value'];
                if ($key == count($input_arr) - 1) {
                    //$string = $string . '。';
                } else {
                    $string = $string . "<br>";
                }
            }
            return "{$string}";
        });
        $show->email('邮件');
        $show->type('订单类型')->as(function($type){
            if($type == 1){
                return '手动发卡';
            }else if($type == 2){
                return '自动发卡';
            }
        });
        $show->pay_type('支付方式')->as(function($pay_type){
            if($pay_type == Order::WECHAT){
                return '微信支付';
            }else if($pay_type == Order::ALIPAY){
                return '支付宝支付';
            }
        });
        $show->status('订单状态')->as(function($status){
            if($status == Order::NO_PAY){
                return '未支付';
            }else if($status == Order::PAYED){
                return '已支付';
            }else if($status == Order::EXPIRE){
                return '已过期';
            }else if($status == Order::SUCCESS){
                return '处理成功';
            }else if($status == Order::ERROR){
                return '处理失败';
            }

        });
        $show->payed_time('支付时间');
        $show->ip('ip');
        $show->created_at('创建时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order);

        $form->display('ID');
        $form->display('Created at');
        $form->display('Updated at');

        return $form;
    }

    public function status(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action;
        Order::whereIn('id', $ids)->update(['status' => $action]);
        foreach ($ids as $id) {
            $order = Order::find($id);
            if ($action == Order::SUCCESS && $order->type == 1) {
                event(new OrderShipped($order));
            }
        }
        return ['code' => 0];
    }

}
