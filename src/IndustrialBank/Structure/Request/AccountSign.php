<?php
/**
 * 虚拟账户签约 请求结构
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/20
 * Time: 15:41
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Request;


use LazyBench\Banks\IndustrialBank\Structure\RequestBase;

class AccountSign extends RequestBase
{
    protected $requestTag = 'VSASIGNTRNRQ';
    protected $responseTag = 'VSASIGNTRNRS';
    protected $responseBodyTag = 'RSBODY';
    protected $requestBody = [
        'RQBODY' => [
            'MAINACCT' => '',
            'SIGNFLG' => 'Y',
        ],
    ];
}
