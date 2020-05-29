<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/21
 * Time: 17:30
 */

namespace LazyBench\Banks\IndustrialBank\Structure\Constants;


class StatusCode
{

    //1	AUDITING 中间值	指令审核中	当设置二级或二级以上流程（即银企代理服务软件的配置参数EnableSign=NO）时，需由企业登录企业网银进行复核及授权后，才能继续完成交易。
    //2	AUDITED	中间值	指令已审核	当转账报文中<DTDUE>节点“期望转账日”大于当前日期时返回。到了设定的期望转账日，银行系统将自动执行指令，无需客户另外干预。
    //3	CANCEL	最终值	指令已撤销
    //4	EXPIRED	最终值	指令过期
    //5	FAIL	最终值	交易失败
    //6	PAYOUT	最终值	交易成功/登记成功
    //7	PENDING	中间值	指令状态未知	指令状态未知，请等待15分钟后再次发起查询，与银行系统进行对账。
    //8	PART_PAYOUT	最终值	部分支付成功	当批量转账时出现；非批量转账的情况下，不会出现该状态。
    //9	WAIT_FOR_AUDIT	中间值	等待银行端审核	当贷款户转账金额超过限额时出现，需要账户行审核后才能继续完成交易。如果在提交指令半个工作日后，状态仍未发生变化，请及时联系账户行审核。
    //10	PROCESSING	中间值	后台处理中	异步交易，后台处理中
    //11	SEND_BACK	中间值	退回经办	提交的指令被授权人员退回


    /**
     * 终态
     */
    public const FINAL_CODE = [
        'CANCEL',
        'EXPIRED',
        'FAIL',
        'PAYOUT',
        'PART_PAYOUT',
    ];

    /**
     * 中间状态
     */
    public const WAITING_CODE = [
        'PENDING',
        'WAIT_FOR_AUDIT',
        'PROCESSING',
        'SEND_BACK',
        'AUDITING',
        'AUDITED',
    ];
}
