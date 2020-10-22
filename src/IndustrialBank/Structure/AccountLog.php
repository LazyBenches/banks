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

class AccountLog implements RequestInterface, ResponseInterface
{
    use RequestTrait, ResponseTrait;

    protected $requestTag = 'BALNTRADEINQUIRYTRNRQ';
    protected $responseTag = 'BALNTRADEINQUIRYTRNRS';

    /**
     * Author:LazyBench
     *
     * @param array $param
     * @return array
     */
    public function formatBody(array $param): array
    {

        $this->requestBody = array_change_key_case([
            'RQBODY' => [
                'ACCTFROM' => [
                    'ACCTID' => $param['mainAccount'],//18位实体扣款账户, 必输
                ],
                'INCTRAN' => [//包含交易流水（未指定起止时间，表示查余额；若指定起止时间，那么：1）开始时间=结束时间；2）开始时间早于结束时间，并且结束时间不为当天。建议查询指定某一天的流水，避免网络传输带来的超时）。 日期信息未填写，表示只查询企业内部账户余额。
                    'DTSTART' => $param['dateStart'],//开始时间 格式：YYYY-MM-DD
                    'DTEND' => $param['dateEnd'],//结束时间 格式：YYYY-MM-DD
                    'PAGE' => $param['page'],//请求响应的页数（代表从第几页开始查询），每页100条明细
                    'TRNTYPE' => $param['transferType'],//借贷标记：0表示借方(往帐)  1表示贷方(来帐) 默认查询2-借贷双方全部流水
                ],
            ],
        ], CASE_UPPER);
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
