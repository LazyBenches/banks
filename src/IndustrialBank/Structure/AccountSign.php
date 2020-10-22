<?php
/**
 * 虚拟账户签约 请求结构
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/20
 * Time: 15:41
 */

namespace LazyBench\Banks\IndustrialBank\Structure;


use LazyBench\Banks\IndustrialBank\Interfaces\RequestInterface;
use LazyBench\Banks\IndustrialBank\Interfaces\ResponseInterface;
use LazyBench\Banks\IndustrialBank\Traits\RequestTrait;
use LazyBench\Banks\IndustrialBank\Traits\ResponseTrait;

class AccountSign implements RequestInterface, ResponseInterface
{
    use RequestTrait, ResponseTrait;

    protected $requestTag = 'VSASIGNTRNRQ';
    protected $responseTag = 'VSASIGNTRNRS';

    /**
     * Author:LazyBench
     *
     * @param array $param
     * @return array
     */
    public function formatBody(array $param): array
    {
        return [
            'RQBODY' => [
                'MAINACCT' => $param['mainAccount'],//18位实体扣款账户, 必输
                'SIGNFLG' => 'Y',
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
        $this->responseBody = $responseBody['RSBODY'] ?? [];
        return true;
    }
}
