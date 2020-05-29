<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/25
 * Time: 14:39
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Request;


use LazyBench\Banks\IndustrialBank\Structure\RequestBase;

class OutTransferQuery extends RequestBase
{
    protected $isQuery = true;
    protected $requestTag = 'XFERINQTRNRQ';
    protected $responseTag = 'XFERINQTRNRS';
    protected $responseBodyTag = 'XFERINQRS';
    protected $requestBody = [
        'XFERINQRQ' => [
            'CLIENTREF' => '20141119zzfc100',
        ],
    ];

}