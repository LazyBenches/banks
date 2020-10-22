<?php
/**
 * 批量开户
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/20
 * Time: 20:06
 */

namespace LazyBench\Banks\IndustrialBank\Structure;


use LazyBench\Banks\IndustrialBank\Interfaces\RequestInterface;
use LazyBench\Banks\IndustrialBank\Interfaces\ResponseInterface;
use LazyBench\Banks\IndustrialBank\Traits\RequestTrait;
use LazyBench\Banks\IndustrialBank\Traits\ResponseTrait;

class SubAccountOpen implements RequestInterface, ResponseInterface
{
    use RequestTrait, ResponseTrait;

    protected $requestTag = 'VSABATCHOPENTRNRQ';
    protected $responseTag = 'VSABATCHOPENTRNRS';

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
                'MAINACCT' => $param['mainAccount'],
                'TOTALCOUNT' => 1,
                'VSAOPENINFO' => [
                    'SUBACCT' => str_pad($param['subAccount'], '6', '0', STR_PAD_LEFT),
                    'SUBNAME' => $param['subAccountName'],
                    'CALINTSIDENT' => '0',//不计息
                    'RATECODE' => '01000000',//人民币零利率
                    'RATESCALEFLTVAL' => '0.0',//利率比例浮动值
                    'RATEPOINTFLTVAL' => '0.0',//利率点数浮动值
                    'RATEWORKDATE' => $param['date'],//利率生效日期
                    'ADJINTSIDENT' => '3',//利随本清
                    'ADJINTSCYCLE' => 'D00',//当结息标志为3、4只能为D00
                    'FIRADJINTSDATE' => $param['date'],//初次结息日期，格式YYYY-MM-DD
                    'BUDGETIDENT' => '0',//预算标志,0-否 1-是
                    'BUDGETQUOTA' => '0',//预算额度，不可填负数
                    'BUDGETCYCLE' => '0',//额度循环标志：0-不循环，1-日，3-月，4-季，5-半年，6-年
                    'OVERQUOTA' => $param['overQuota'],//透支额度，不可填负数，大于0表示可透支
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
        $this->responseBody = $responseBody['RSBODY'] ?? [];
        return true;
    }
}
