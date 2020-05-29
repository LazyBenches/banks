<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/19
 * Time: 17:28
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Constants;

class ResponseStatus
{
    public const RESPONSE_CODE = [
        '0' => '操作成功',
        '2000' => '操作员不存在',
        '2002' => '电子回单不存在',
        '20203' => '没有交易明细',
        '40620' => '不存在该活期账号',
    ];
}
