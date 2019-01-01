<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Order;
use App\Models\Goods;
use Carbon\Carbon;

class UpdateOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->order->status == 1) {
            return;
        }
        $result = app('youzan')->post('youzan.trades.qr.get', [
            'qr_id' => $this->order->out_trade_no,
            'status' => 'TRADE_RECEIVED'
        ]);
        $response = $result['response'];
        $trade = array_pop($response['qr_trades']);
        if ($response['total_results'] > 0) {
            $this->order->status = 1;
            switch ($trade['pay_type']) {
                case 'WXPAY_BIGUNSIGN':
                    $this->order->pay_type = 1;
                    break;
                case 'ALIWAP':
                    $this->order->pay_type = 2;
                    break;
            }
            $this->order->pay_time = $trade['pay_date'];
            $this->order->save();
        } else {
            $expirationTime = 30;
            if (Carbon::now()->diffInMinutes($this->order->created_at) >= $expirationTime) {//订单过期
                if ($this->order->type == 1) {
                    $goods = Goods::where('goods_id', $this->order->goods_id)->first();
                    //释放库存
                    $goods->addStock($this->order->count);
                }
                $this->order->status = 3;
                $this->order->save();
                return;
            } else {
                UpdateOrders::dispatch($this->order)
                    ->delay(Carbon::now()->addSeconds(2));
            }
        }
    }
}
