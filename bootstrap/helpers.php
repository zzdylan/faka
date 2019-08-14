<?php

/**
 * 获取当前毫秒数
 * @return type
 */
function getMillisecond() {
    list($t1, $t2) = explode(' ', microtime());
    return (float) sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
}

/**
 * 生成订单号
 * @return type
 */
function buildTradeNo() {
    return getMillisecond() . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}

function blade2str($blade,$data = array())
{
    $data['__env'] = app(Illuminate\Contracts\View\Factory::class);
    $str = Blade::compileString($blade);

    ob_start() and extract($data, EXTR_SKIP);
    try {
        eval('?>' . $str);
    }
    catch (\Exception $e) {
        ob_end_clean();
        throw $e;
    }
    $str = ob_get_contents();
    ob_end_clean();
    return $str;
}

function is_weixin(){
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
        return true;
    }
    return false;
}