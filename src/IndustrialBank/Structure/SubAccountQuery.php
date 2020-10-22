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

class SubAccountQuery implements RequestInterface, ResponseInterface
{
    use RequestTrait, ResponseTrait;

    protected $requestTag = 'VSASUBACCTINFOTRNRQ';
    protected $responseTag = 'VSASUBACCTINFOTRNRS';

    /**
     * Author:LazyBench
     *
     * @param array $param
     * @return array
     */
    public function formatBody(array $param): array
    {
        $this->requestBody = [
            'INQUIRYINFO' => [
                'MAINACCT' => $param['mainAccount'],
                'SUBACCT' => $param['subAccount'],
                'STARTROW' => $param['startRow'],
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
        $this->payStatus = $responseBody['SUBACCTLIST']['XFERPRCSTS'] ?? [];
        $this->responseBody = $responseBody['SUBACCTLIST'] ?? [];
        return true;
    }
}
