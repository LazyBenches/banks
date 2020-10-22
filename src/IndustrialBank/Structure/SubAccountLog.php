<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/12/5
 * Time: 14:10
 */

namespace LazyBench\Banks\IndustrialBank\Structure;


use LazyBench\Banks\IndustrialBank\Interfaces\RequestInterface;
use LazyBench\Banks\IndustrialBank\Interfaces\ResponseInterface;
use LazyBench\Banks\IndustrialBank\Traits\RequestTrait;
use LazyBench\Banks\IndustrialBank\Traits\ResponseTrait;

class SubAccountLog implements RequestInterface, ResponseInterface
{
    use RequestTrait, ResponseTrait;

    protected $requestTag = 'VATSTMTTRNRQ';
    protected $responseTag = 'VATSTMTTRNRS';

    /**
     * Author:LazyBench
     *
     * @param array $param
     * @return array
     */
    public function formatBody(array $param): array
    {
        return [
            'VATSTMTRQ' => [
                'VATTYPE' => '1',
                'MAINACCT' => $param['mainAccount'],
                'SUBACCT' => (string)str_pad($param['account'], '6', '0', STR_PAD_LEFT),
                'ACCTFROM' => [
                    'ACCTID' => $param['mainAccount'],
                ],
                'INCTRAN' => [
                    'DTSTART' => $param['dateStart'],
                    'DTEND' => $param['dateEnd'],
                    'PAGE' => $param['page'],
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

        $this->payStatus = $responseBody['VATSTMTRS']['XFERPRCSTS'] ?? [];
        $this->responseBody = $responseBody['VATSTMTRS'] ?? [];
        return true;
    }
}
