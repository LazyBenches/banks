<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/12/5
 * Time: 9:30
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Request;


use LazyBench\Banks\IndustrialBank\Structure\RequestBase;

class QueryTransferInfo extends RequestBase
{
    protected $requestTag = 'XFERINQTRNRQ';
    protected $responseTag = 'XFERINQTRNRS';
    protected $responseBodyTag = 'XFERINQRS';
    protected $responseTransferBodyTag = 'XFERLIST';
    protected $responseTransferBodyInfoTag = 'XFER';
    protected $requestBody = [
        'XFERINQRQ' => [
            'CLIENTREF' => '',//原订单编号
        ],
    ];
}
