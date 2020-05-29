<?php
/**
 * 主账户对外转账
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/21
 * Time: 18:33
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Request;


use LazyBench\Banks\IndustrialBank\Structure\RequestBase;

class OutTransfer extends RequestBase
{
    protected $isQuery = false;
    protected $requestTag = 'XFERTRNRQ';
    protected $responseTag = 'XFERTRNRS';
    protected $responseBodyTag = 'XFERRS';
    protected $requestBody = [
        'XFERTRNRQ' => [
            'TRNUID' => '',
            'XFERRQ' => [
                'XFERINFO' => [
                    'ACCTFROM' => [
                        'ACCTID' => '',
                    ],
                    'ACCTTO' => [
                        'ACCTID' => '',
                        'NAME' => '',
                        'BANKDESC' => '',
                        'BANKNUM' => '',
                        'CITY' => '',
                        '@ATTRIBUTES' => [
                            'INTERBANK' => 'Y',
                            'LOCAL' => 'Y',
                        ],
                    ],
                    'CHEQUENUM' => '',
                    'TRNAMT' => '',
                    'PURPOSE' => '',
                    'MEMO' => '',
                ],
            ],
        ],
    ];
}
