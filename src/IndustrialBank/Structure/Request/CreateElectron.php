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

class CreateElectron extends RequestBase
{
    protected $isQuery = false;
    protected $requestTag = 'ELECTRONICRECEIPTTRNRQ';
    protected $responseTag = 'ELECTRONICRECEIPTTRNRS';
    protected $responseBodyTag = 'RSBODY';
    protected $requestBody = [
        'RQBODY' => [
            'RECEIPT_TYPE' => '',
            'ACCTID' => '',
            'RECEIPTDATE' => '',
        ],
    ];
}
