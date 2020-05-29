<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/12/5
 * Time: 14:10
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Request;


use LazyBench\Banks\IndustrialBank\Structure\RequestBase;

class SubAccountLog extends RequestBase
{
    protected $requestTag = 'VATSTMTTRNRQ';
    protected $responseTag = 'VATSTMTTRNRS';
    protected $responseBodyTag = 'VATSTMTRS';
    protected $requestBody = [
        'VATSTMTRQ' => [
            'VATTYPE' => '',
            //查询类型：1－虚拟子账户交易明细查询
            'MAINACCT' => '',
            //18位实体扣款账户
            'SUBACCT' => '',
            //6位虚拟小序号
            'ACCTFROM' => [
                'ACCTID' => '',//18位实体扣款账户, 必输
                //                'NAME' => '',
                //            'BANKDESC'=>'',//开户行名称(可选) 未限制，仅在报文中体现
                //            'CITY'=>'',//兑付城市(可选) 未限制，仅在报文中体现
                //            'BANKDESC'=>'',//开户行名称(可选) 未限制，仅在报文中体现
            ],
            'INCTRAN' => [//包含交易流水（未指定起止时间，表示查余额；若指定起止时间，那么：1）开始时间=结束时间；2）开始时间早于结束时间，并且结束时间不为当天。建议查询指定某一天的流水，避免网络传输带来的超时）。 日期信息未填写，表示只查询企业内部账户余额。
                'DTSTART' => '2015-05-08',//开始时间 格式：YYYY-MM-DD
                'DTEND' => '2015-07-31',//结束时间 格式：YYYY-MM-DD
                'PAGE' => '1',//请求响应的页数（代表从第几页开始查询），每页100条明细
            ],
        ],
    ];
}
