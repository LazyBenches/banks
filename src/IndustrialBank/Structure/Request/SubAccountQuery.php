<?php
/**
 * 虚拟子账户信息查询
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/25
 * Time: 16:15
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Request;


use LazyBench\Banks\IndustrialBank\Structure\RequestBase;

class SubAccountQuery extends RequestBase
{
    protected $requestTag = 'VSASUBACCTINFOTRNRQ';
    protected $responseTag = 'VSASUBACCTINFOTRNRS';
    protected $responseBodyTag = 'SUBACCTLIST';
    protected $requestBody = [
        'INQUIRYINFO' => [
            'MAINACCT' => '',
            //18位主账户
            'SUBACCT' => '',
            //子账户:ALL全部子账户 XXXX-具体子账户
            'STARTROW' => '',
            //开始行，每行20笔，默认1
            'PATTERN' => '',
            //非必填
            //查询模式，1-查询某个子账户详细信息，响应增加详细信息：利率代号、利率生效日期、利率比例浮动值、利率点数浮动值、执行利率、计息标识、结息标识、结息周期、首次结息日期、应加应减积数、未结利息、预算标识、预算额度、预算额度起始日期、预算额度到期日期、额度循环标志、透资额度、结算账号、主账户户名、主账户余额、子账户汇总余额
        ],
    ];
}
