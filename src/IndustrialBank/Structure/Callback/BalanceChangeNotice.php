<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/21
 * Time: 10:40
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Callback;

use LazyBench\Banks\IndustrialBank\Structure\ResponseBase;

class BalanceChangeNotice extends ResponseBase
{
    protected $tag = 'BALANCECHANGENOTICE';
    protected $body = [
        'NOTICE_INFO' => [
            'ACCTID' => '',
            'ACCT_NAME' => '',
            'TRADE_TIME' => '',
            'TRNTYPE' => '',
            'MEMO' => '',
            'TRNAMT' => '',
            'BALAMT' => '',
            'ATTACHINFO' => '',
        ],
    ];
}