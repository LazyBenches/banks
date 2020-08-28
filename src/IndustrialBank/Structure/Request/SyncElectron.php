<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2020/8/25
 * Time: 18:28
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Request;


use LazyBench\Banks\IndustrialBank\Structure\RequestBase;

class SyncElectron extends RequestBase
{
    protected $requestTag = 'ASYNRECEIPTINFOTRNRQ';
    protected $responseTag = 'ASYNRECEIPTINFOTRNRS';
    protected $responseBodyTag = 'RSBODY';
    protected $requestBody = [
        'RQBODY' => [
            'CLT_REF_NO' => '',
        ],
    ];
}
