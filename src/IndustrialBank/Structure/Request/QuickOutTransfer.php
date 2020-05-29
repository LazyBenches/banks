<?php
/**
 * 跨行快速转账
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/25
 * Time: 14:11
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Request;


use LazyBench\Banks\IndustrialBank\Structure\RequestBase;

class QuickOutTransfer extends RequestBase
{
    protected $isQuery = false;
    protected $requestTag = 'ICTRANSFERTRNRQ';
    protected $responseTag = 'ICTRANSFERTRNRS';
    protected $responseBodyTag = 'XPMTRS';
    protected $requestBody = [
        'XMPTRQ' => [
            'FUNDACCT' => [
                'ACCTID' => '',
            ],
            'XFERINFO' => [
                'ACCTFROM' => [
                    'ACCTID' => '',
                    'NAME' => '',
                ],
                'ACCTTO' => [
                    'ACCTID' => '',
                    'NAME' => '',
                    'BANKDESC' => '',
                    'BANKNUM' => '',
                    'CITY' => '',
                    '@ATTRIBUTES' => [
                        'INTERBANK' => 'N',
                        'LOCAL' => 'N',
                    ],
                ],
                'TRNAMT' => '',
                'PURPOSE' => '',
                'MEMO' => '',
            ],
        ],
    ];
}
