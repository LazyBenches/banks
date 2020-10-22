<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2020/8/25
 * Time: 18:28
 */

namespace LazyBench\Banks\IndustrialBank\Structure;


use LazyBench\Banks\IndustrialBank\Interfaces\RequestInterface;
use LazyBench\Banks\IndustrialBank\Interfaces\ResponseInterface;
use LazyBench\Banks\IndustrialBank\Traits\RequestTrait;
use LazyBench\Banks\IndustrialBank\Traits\ResponseTrait;

class SyncElectron implements RequestInterface, ResponseInterface
{
    use RequestTrait, ResponseTrait;

    protected $requestTag = 'ASYNRECEIPTINFOTRNRQ';
    protected $responseTag = 'ASYNRECEIPTINFOTRNRS';

    /**
     * Author:LazyBench
     *
     * @param array $param
     * @return array
     */
    public function formatBody(array $param): array
    {
        $this->requestBody = [
            'RQBODY' => [
                '@ATTRIBUTES' => [
                    'PAGE' => $param['page'],
                ],
                'CLT_REF_NO' => $param['nid'],
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
        $this->payStatus = $responseBody['RSBODY']['XFERPRCSTS'] ?? [];
        $this->responseBody = $responseBody['RSBODY'] ?? [];
        return true;
    }
}
