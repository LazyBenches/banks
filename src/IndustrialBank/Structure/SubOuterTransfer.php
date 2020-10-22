<?php
/**
 * 虚拟子账户对外支付
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/21
 * Time: 18:27
 */

namespace LazyBench\Banks\IndustrialBank\Structure;


use LazyBench\Banks\IndustrialBank\Interfaces\RequestInterface;
use LazyBench\Banks\IndustrialBank\Interfaces\ResponseInterface;
use LazyBench\Banks\IndustrialBank\Traits\RequestTrait;
use LazyBench\Banks\IndustrialBank\Traits\ResponseTrait;

class SubOuterTransfer implements RequestInterface, ResponseInterface
{
    use RequestTrait, ResponseTrait;

    protected $requestTag = 'VATTRNRQ';
    protected $responseTag = 'VATTRNRS';

    /**
     * Author:LazyBench
     *
     * @param array $param
     * @return array
     */
    public function formatBody(array $param): array
    {
        $this->requestBody = [
            'VATRQ' => [
                'VATTYPE' => '1',
                'MAINACCT' => $param['mainAccount'],
                'SUBACCT' => $param['subAccount'],
                'XFERINFO' => [
                    'ACCTFROM' => [
                        'ACCTID' => $param['mainAccount'],
                        'NAME' => $param['mainAccountName'],
                    ],
                    'ACCTTO' => [
                        'ACCTID' => $param['toAccount'],
                        'NAME' => $param['toName'],
                        'BANKDESC' => $param['toBankName'],
                        'CITY' => $param['toCity'],
                        '@ATTRIBUTES' => [
                            'INTERBANK' => $param['isInnerBank'],
                            'LOCAL' => $param['isLocal'],
                        ],
                    ],
                    'TRNAMT' => $param['amount'],//decimalToInteger()
                    'PURPOSE' => $param['purpose'],
                    'MEMO' => $param['memo'],
                ],
            ],
        ];
        return $this->requestBody;
    }

    /**
     * Author:LazyBench
     *
     * @param $responseBody
     * @return bool
     */
    public function handleResponseBody($responseBody): bool
    {
        $this->payStatus = $responseBody['XFERRS']['XFERRS']['XFERPRCSTS'] ?? [];
        $this->responseBody = $responseBody['XFERRS']['XFERRS'] ?? [];
        return true;
    }
}
