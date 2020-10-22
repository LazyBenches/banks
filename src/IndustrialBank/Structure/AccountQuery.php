<?php
/**
 * 虚拟子账户信息查询
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/25
 * Time: 16:15
 */

namespace LazyBench\Banks\IndustrialBank\Structure;


use LazyBench\Banks\IndustrialBank\Interfaces\RequestInterface;
use LazyBench\Banks\IndustrialBank\Interfaces\ResponseInterface;
use LazyBench\Banks\IndustrialBank\Traits\RequestTrait;
use LazyBench\Banks\IndustrialBank\Traits\ResponseTrait;

class AccountQuery implements RequestInterface, ResponseInterface
{
    use RequestTrait, ResponseTrait;

    protected $requestTag = 'CURRACCTQUERYTRNRQ';
    protected $responseTag = 'CURRACCTQUERYTRNRS';

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
                'ACCTID' => $param['mainAccount'],//18位实体扣款账户, 必输
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
        $this->responseBody = $responseBody['RSBODY'] ?? [];
        return true;
    }
}
