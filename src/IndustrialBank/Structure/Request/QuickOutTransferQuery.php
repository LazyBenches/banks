<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/25
 * Time: 14:19
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Request;


use LazyBench\Banks\IndustrialBank\Structure\RequestBase;

class QuickOutTransferQuery extends RequestBase
{
    protected $isQuery = false;
    protected $requestTag = 'XFERTRNRQ';
    protected $responseTag = 'ICTRANSFERINQTRNRS';
    protected $responseBodyTag = 'XFERINQRS';
    protected $requestBody = [
        'XFERINQRQ' => [
            'CLIENTREF' => '',
        ],
    ];
}