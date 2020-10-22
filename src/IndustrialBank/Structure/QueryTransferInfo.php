<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/12/5
 * Time: 9:30
 */

namespace LazyBench\Banks\IndustrialBank\Structure;


use LazyBench\Banks\IndustrialBank\Interfaces\RequestInterface;
use LazyBench\Banks\IndustrialBank\Interfaces\ResponseInterface;
use LazyBench\Banks\IndustrialBank\Traits\RequestTrait;
use LazyBench\Banks\IndustrialBank\Traits\ResponseTrait;

class QueryTransferInfo implements RequestInterface, ResponseInterface
{
    use RequestTrait, ResponseTrait;

    protected $requestTag = 'XFERINQTRNRQ';
    protected $responseTag = 'XFERINQTRNRS';

    /**
     * Author:LazyBench
     *
     * @param array $param
     * @return array
     */
    public function formatBody(array $param): array
    {
        return [
            'XFERINQRQ' => [
                'CLIENTREF' => $param['oldTrnUid'],
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
        $this->payStatus = $responseBody['XFERINQRS']['XFERLIST']['XFER']['XFERPRCSTS'] ?? [];
        $this->responseBody = $responseBody['XFERINQRS']['XFERLIST']['XFER'] ?? [];
        return true;
    }
}
