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