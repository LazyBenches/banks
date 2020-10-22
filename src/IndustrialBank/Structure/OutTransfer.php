<?php
/**
 * 主账户对外转账
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/21
 * Time: 18:33
 */

namespace LazyBench\Banks\IndustrialBank\Structure;


use LazyBench\Banks\IndustrialBank\Interfaces\RequestInterface;
use LazyBench\Banks\IndustrialBank\Interfaces\ResponseInterface;
use LazyBench\Banks\IndustrialBank\Traits\RequestTrait;
use LazyBench\Banks\IndustrialBank\Traits\ResponseTrait;

class OutTransfer implements RequestInterface, ResponseInterface
{
    use RequestTrait, ResponseTrait;

    protected $requestTag = 'XFERTRNRQ';
    protected $responseTag = 'XFERTRNRS';

    /**
     * Author:LazyBench
     *
     * @param array $param
     * @return array
     */
    public function formatBody(array $param): array
    {
        return [
            'XFERRQ' => [
                'XFERINFO' => [
                    'ACCTFROM' => [
                        'ACCTID' => $param['mainAccount'],
                        'BANKDESC' => '兴业银行',
                    ],
                    'ACCTTO' => [
                        'ACCTID' => $param['toAccount'],
                        'NAME' => $param['toName'],
                        'BANKDESC' => $param['toBankName'],
                        'CITY' => $param['toCity'],
                        '@ATTRIBUTES' => [
                            'INTERBANK' => $param['isInterBank'],//是否兴业银行
                            'LOCAL' => $param['isLocal'],//是否是天津地区
                        ],
                    ],
                    'TRNAMT' => $param['amount'],
                    'PURPOSE' => $param['purpose'],
                    'MEMO' => $param['memo'],
                ],
            ],
        ];
    }

    /**
     * Author:LazyBench
     *
     * @param $responseBody
     * @return bool
     */
    public function handleResponseBody($responseBody): bool
    {
        $this->payStatus = $responseBody['XFERRS']['XFERPRCSTS'] ?? [];
        $this->responseBody = $responseBody['XFERRS'] ?? [];
        return true;
    }
}
