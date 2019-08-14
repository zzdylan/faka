<?php
namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\ExcelExporter; 

class OrdersExporter extends ExcelExporter
{
    protected $fileName = '订单列表.xlsx';

    protected $columns = [
        'id'      => 'ID',
        'trade_no'   => '订单号',
        'name' => '订单名称',
        'goods_name' => '商品名称',
        'total_price' => '订单总价',
        'email' => '邮箱',
    ];
}