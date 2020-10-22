<?php
/**
 * 虚拟子账号内部转账
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/20
 * Time: 20:47
 */

namespace LazyBench\Banks\IndustrialBank\Structure;


use LazyBench\Banks\IndustrialBank\Interfaces\RequestInterface;
use LazyBench\Banks\IndustrialBank\Interfaces\ResponseInterface;
use LazyBench\Banks\IndustrialBank\Traits\RequestTrait;
use LazyBench\Banks\IndustrialBank\Traits\ResponseTrait;

class SubInnerTransfer implements RequestInterface, ResponseInterface
{
    use RequestTrait, ResponseTrait;

    protected $requestTag = 'VSAINTRSFTRNRQ';
    protected $responseTag = 'VSAINTRSFTRNRS';

    /**
     * Author:LazyBench
     *
     * @param array $param
     * @return array
     */
    public function formatBody(array $param): array
    {
        $this->requestBody = [
            'VSAINTRSFRQ' => [
                'MAINACCT' => $param['mainAccount'],
                'SUBACCT' => $param['subAccount'],
                'TOSUBACCT' => $param['subToAccount'],
                'TRNAMT' => $param['amount'],
                'PURPOSE' => $param['purpose'],
                'MEMO' => $param['memo'],
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
        $this->payStatus = $responseBody['VSAINTRSFRS']['XFERPRCSTS'] ?? [];
        $this->responseBody = $responseBody['VSAINTRSFRS'] ?? [];
        return true;
    }
}
