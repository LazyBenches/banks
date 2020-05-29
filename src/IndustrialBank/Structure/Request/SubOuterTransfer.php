<?php
/**
 * 虚拟子账户对外支付
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/21
 * Time: 18:27
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Request;


use LazyBench\Banks\IndustrialBank\Structure\RequestBase;

class SubOuterTransfer extends RequestBase
{
    protected $isQuery = false;
    protected $requestTag = 'VATTRNRQ';
    protected $responseTag = 'VATTRNRS';
    protected $responseBodyTag = 'VATRS';
    protected $responseTransferBodyTag = 'XFERRS';
    protected $requestBody = [
        'VATRQ' => [//请求支付信息节点,如果不输则为查询客户端交易流水（TRNUID）的交易情况
            'VATTYPE' => '',//支付类型：1－虚拟子账户对外支付
            'MAINACCT' => '',//实体扣款账户，最大18位
            'SUBACCT' => '',//虚拟小序号, 最大6位
            'XFERINFO' => [//对外支付信息
                'ACCTFROM' => [//付款账户信息
                    'ACCTID' => '',//18位实体扣款账户
                    'NAME' => '',//虚拟子账户名称, 最大60位，必输
                    //                    'BANKDESC' => '',//开户行名称，最大50位	非必输
                    //                    'CITY'=>'',//兑付地址，最大30位	非必输
                ],
                'ACCTTO' => [//收款人账户信息
                    'ACCTID' => '',//收款账号，最大32位
                    'NAME' => '',//收款人名称，最大50位
                    'BANKDESC' => '',//收款人开户行名称，最大50位，其他银行时必须输入
                    //                    'BANKNUM' => '',//收报行号，长度为12位、或不输。(可选) 当支付方式为SUPER时必输
                    'CITY' => '',//收款人城市，同城可以不发送，最大30位	非必输
                    //                    'COLLECT' => '',//是否转向财务公司内部账户1表示是，0或空表示否
                    '@ATTRIBUTES' => [
                        'INTERBANK' => 'N',
                        //是否兴业银行INTERBANK=”Y”/””N”；注意：此处必须正确填写INTERBANK，与账号实际信息必须一致，否则报错，跨行时，银行名称不可填写兴业银行字样
                        'LOCAL' => 'N',
                        //是否同城LOCAL=”Y”/”N”，账户信息尽量填全。
                    ],
                ],
                'TRNAMT' => '',//转账金额，金额>0,整数最长15位，小数2位当支付方式为SUPER时，交易金额不得超过5万
                //                'PMTMODE' => '',//支付方式虚拟子账户超级网银跨行支付必填：SUPER
                'PURPOSE' => '',//用途，最大60位	必输
                //                'DTDUE' => '',//客户端要求转账的执行日期，如果客户端未发送DTDUE，则服务器将执行转账，格式yyyy-MM-dd；
                'MEMO' => '',//备注，仅在在付款方对账单中出现，最大60位
            ],
        ],
    ];
}
