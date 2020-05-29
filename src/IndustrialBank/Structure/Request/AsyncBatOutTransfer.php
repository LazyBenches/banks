<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/28
 * Time: 17:52
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Request;


use LazyBench\Banks\IndustrialBank\Structure\RequestBase;

class AsyncBatOutTransfer extends RequestBase
{
    protected $isQuery = false;
    protected $requestTag = 'ASYNBATCHTRSFRTRNRQ';
    protected $responseTag = 'ASYNBATCHTRSFRTRNRS';
    protected $responseBodyTag = 'RSBODY';
    protected $requestBody = [
        'RQBODY' => [
            'TITLE' => '',
            'ACCTFROM' => [
                'ACCTID' => '',
                'NAME' => '',
                'BANKDESC' => '',
                'CITY' => '',
            ],
            'BIZTYPE' => '',
            'TOTALCOUNT' => '',
            'TOTALAMOUNT' => '',
            'CURSYM' => '',
            'PURPOSE' => '',
            'MEMO' => '',
            'XFERINFOTEXT' => [
                '@CDATA' => '1|117010100150190084|银企测试182|Y|Y||||3.01|purpose|memo|
2|21100000601|沈木兰|Y|N||||5.78|test网银支付麤|备注<>|
3|1234567-89-20130917|银企测试跨行|N|N|105312828008|中国建设银行|台州|7.46|用途&lt;&lt;|备注<>|',
                '@ATTRIBUTES' => [
                    'size' => '3',
                ],
            ],
        ],
    ];
}
