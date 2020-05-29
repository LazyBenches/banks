<?php
/**
 * 虚拟子账号内部转账
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/20
 * Time: 20:47
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Request;


use LazyBench\Banks\IndustrialBank\Structure\RequestBase;

class SubInnerTransfer extends RequestBase
{
    protected $isQuery = false;
    protected $requestTag = 'VSAINTRSFTRNRQ';
    protected $responseTag = 'VSAINTRSFTRNRS';
    protected $responseBodyTag = 'VSAINTRSFRS';
    protected $requestBody = [
        'VSAINTRSFRQ' => [
            'MAINACCT' => '',
            'SUBACCT' => '',
            'SUBNAME' => '',
            'TOSUBACCT' => '',
            'TOSUBNAME' => '',
            'TRNAMT' => '',
            'PURPOSE' => '',
            'MEMO' => '',
            'DTDUE' => '',
        ],
    ];
}
