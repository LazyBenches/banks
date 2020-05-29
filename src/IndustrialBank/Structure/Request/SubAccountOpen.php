<?php
/**
 * 批量开户
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/20
 * Time: 20:06
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Request;


use LazyBench\Banks\IndustrialBank\Structure\RequestBase;

class SubAccountOpen extends RequestBase
{
    protected $isQuery = false;
    protected $requestTag = 'VSABATCHOPENTRNRQ';
    protected $responseTag = 'VSABATCHOPENTRNRS';
    protected $responseBodyTag = 'RSBODY';
    protected $requestBody = [
        'RQBODY' => [
            'MAINACCT' => '',
            'TOTALCOUNT' => '',
            'VSAOPENINFO' => [
                [
                    'SUBACCT' => '',
                    'SUBNAME' => '',
                    'CALINTSIDENT' => '',
                    'RATECODE' => '',
                    'RATESCALEFLTVAL' => '',
                    'RATEPOINTFLTVAL' => '',
                    'RATEWORKDATE' => '',
                    'ADJINTSIDENT' => '',
                    'ADJINTSCYCLE' => '',
                    'FIRADJINTSDATE' => '',
                    'BUDGETIDENT' => '',
                    'BUDGETQUOTA' => '',
                    'BUDGETCYCLE' => '',
                    'OVERQUOTA' => '',
                ],
                [
                    'SUBACCT' => '',
                    'SUBNAME' => '',
                    'CALINTSIDENT' => '',
                    'RATECODE' => '',
                    'RATESCALEFLTVAL' => '',
                    'RATEPOINTFLTVAL' => '',
                    'RATEWORKDATE' => '',
                    'ADJINTSIDENT' => '',
                    'ADJINTSCYCLE' => '',
                    'FIRADJINTSDATE' => '',
                    'BUDGETIDENT' => '',
                    'BUDGETQUOTA' => '',
                    'BUDGETCYCLE' => '',
                    'OVERQUOTA' => '',
                ],
            ],
        ],
    ];
}
