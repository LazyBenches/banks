<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/25
 * Time: 14:59
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Request;


use LazyBench\Banks\IndustrialBank\Structure\RequestBase;

class BatOutTransfer extends RequestBase
{
    protected $isQuery = false;
    protected $requestTag = 'ASYNBATCHTRSFRTRNRQ';
    protected $responseTag = 'ASYNBATCHTRSFRTRNRS';
    protected $responseBodyTag = 'RSBODY';
    protected $requestBody = [
        'RQBODY' => [
            'TITLE' => '异步批量支付',
            'ACCTFROM' => [
                'ACCTID' => '117010130400122277',
                'NAME' => 'test',
                'BANKDESC' => '兴业银行',
                'CITY' => '福州',
            ],
            'BIZTYPE' => '0',
            'TOTALCOUNT' => '3',
            'TOTALAMOUNT' => '16.25',
            'CURSYM' => 'RMB',
            'PURPOSE' => 'test网银支付麤',
            'MEMO' => '银企测试备注',
            'XFERINFOTEXT' => [
                '@value' => '
            1|117010100150190084|银企测试182|Y|Y||||3.01|purpose|memo|
            2|21100000601|沈木兰|Y|N||||5.78|test网银支付麤|备注<>|
            3|1234567-89-20130917|银企测试跨行|N|N|105312828008|中国建设银行|台州|7.46|用途&lt;&lt;|备注<>|
            ',
                '@ATTRIBUTES' => [
                    'size' => '3',
                ],
            ],
        ],
    ];

}
