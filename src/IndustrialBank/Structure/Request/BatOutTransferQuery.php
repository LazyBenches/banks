<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/25
 * Time: 16:04
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Request;


use LazyBench\Banks\IndustrialBank\Structure\RequestBase;

class BatOutTransferQuery extends RequestBase
{
    protected $isQuery = true;
    protected $requestTag = 'ASYNBATCHTRSFRTRNRQ';
    protected $responseTag = 'ASYNBATCHTRSFRTRNRS';
    protected $responseBodyTag = 'RSBODY';
    protected $requestBody = [
        'ASYNBATCHTRSFRTRNRQ' => [
            'TRNUID' => '',
        ],
    ];

}