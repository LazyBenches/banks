<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/21
 * Time: 11:24
 */

use LazyBench\Banks\IndustrialBank\Industrial;
use LazyBench\Banks\IndustrialBank\Interfaces\RequestInterface;
use LazyBench\Banks\IndustrialBank\Structure\SubAccountQuery;

include '../vendor/autoload.php';
if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    function env(string $key = null, $default = null)
    {
        if (!$key) {
            return $_SERVER;
        }

        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'on':
            case 'yes':
            case 'true':
            case '(true)':
                return true;
            case 'off':
            case 'no':
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        if (defined($value)) {
            $value = constant($value);
        }

        return $value;
    }
}

$configs = include('configs/'.strtolower(env('APP_ENV')).'.php');

class RequestTest
{
    public function varExport($data, $tag = '说明')
    {
        echo '=>=>=>=>=>=>=>=>=>=>=>'.$tag.'=>=>=>=>=>=>=>=>=>=>=>', PHP_EOL;
        var_export($data);
        echo '=>=>=>=>=>=>=>=>=>=>=>'.$tag.'=>=>=>=>=>=>=>=>=>=>=>', PHP_EOL;
        return;
    }

    public function echo($string, $tag = '说明')
    {
        echo '=>=>=>=>=>=>=>=>=>=>=>'.$tag.'=>=>=>=>=>=>=>=>=>=>=>', PHP_EOL;
        echo $string, PHP_EOL;
        echo '=>=>=>=>=>=>=>=>=>=>=>'.$tag.'=>=>=>=>=>=>=>=>=>=>=>', PHP_EOL;
        return;
    }

    /**
     * Author:LazyBench
     * 所属银行
     * @var int
     */
    protected $bank = 0;
    /**
     * Author:LazyBench
     *
     * @var
     */
    protected $errorMsg;
    /**
     * Author:LazyBench
     *
     * @var Industrial
     */
    protected $industrial;

    /**
     * BankLogic constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->industrial = new Industrial();
    }

    /**
     * Author:LazyBench
     *
     * @param array $config
     * @return $this
     */
    public function setMainAccount(array $config)
    {
        foreach ($config as $key => $value) {
            $this->industrial->setConfig($key, $value);
        }
        return $this;
    }

    public function getErrorMessage()
    {
        return $this->errorMsg;
    }


    /**
     * Author:LazyBench
     * @param $param
     * @param RequestInterface|\LazyBench\Banks\IndustrialBank\Interfaces\ResponseInterface $structure
     * @return array|string
     */
    public function handleRequest(array $param, RequestInterface $structure)
    {
        $structure->setRequestHeader($this->industrial->getConfig());
        $structure->formatBody($param);
        $structure->formatRequestString();
        $response = $this->industrial->request($structure);
        if (env('INDUSTRIAL_BANK_DEBUG', false)) {
            file_put_contents(alias('@runtime').'/logs/request_'.$structure->getRequestTag().'.xhtml', $structure->getRequestString());
            file_put_contents(alias('@runtime').'/logs/response_'.$structure->getRequestTag().'.xhtml', $structure->getResponseString());
        }
        return $response;
    }

    /**
     * Author:LazyBench
     *
     * @return Industrial
     */
    public function getIndustrial(): Industrial
    {
        return $this->industrial;
    }
}

$test = new RequestTest();
foreach ($configs as $config) {
    $test->setMainAccount($config);
    $requestBody = [
        'INQUIRYINFO' => [
            'MAINACCT' => $test->getIndustrial()->getConfig()->getMainAccount(),
            'SUBACCT' => '010000',
            'STARTROW' => 1,
        ],
    ];
    $structure = new SubAccountQuery('check_'.time());
    if (!$test->handleRequest($requestBody, $structure)) {
        $test->echo('请求失败'.$structure->getStatusMsg());
        continue;
    }
    var_dump($structure->getResponseBody());
}
$requestBody = [
    'RQBODY' => [
        'MAINACCT' => $test->getIndustrial()->getConfig()->getMainAccount(),
        'SIGNFLG' => 'Y',
    ],
];
$structure = new \LazyBench\Banks\IndustrialBank\Structure\AccountSign('aaa');
$test->varExport($test->handleRequest($requestBody, $structure), '虚拟主账户签约成功');
$test->varExport($test->handleRequest($requestBody, $structure), '虚拟主账户签约失败');
$test->echo($structure->getRequestString());
//exit;
//$requestBody = [
//    'RQBODY' => [
//        'MAINACCT' => $test->getIndustrial()->getConfig()->getMainAccount(),
//        'TOTALCOUNT' => '3',
//        'VSAOPENINFO' => [
//            [
//                'SUBACCT' => '010456',
//                'SUBNAME' => '不计息子账号',
//                'CALINTSIDENT' => '0',
//                'RATECODE' => '01000000',
//                'RATESCALEFLTVAL' => '0.0',
//                'RATEPOINTFLTVAL' => '0.0',
//                'RATEWORKDATE' => '2016-10-25',
//                'ADJINTSIDENT' => '3',
//                'ADJINTSCYCLE' => 'D00',
//                'FIRADJINTSDATE' => '2016-10-25',
//                'BUDGETIDENT' => '1',
//                'BUDGETQUOTA' => '49999.01',
//                'BUDGETCYCLE' => '1',
//                'OVERQUOTA' => '1234.56',
//            ],
//            [
//                'SUBACCT' => '993001',
//                'SUBNAME' => '计息子账号',
//                'CALINTSIDENT' => '1',
//                'RATECODE' => '01000000',
//                'RATESCALEFLTVAL' => '0.0',
//                'RATEPOINTFLTVAL' => '0.04',
//                'RATEWORKDATE' => '2016-10-25',
//                'ADJINTSIDENT' => '3',
//                'ADJINTSCYCLE' => 'D00',
//                'FIRADJINTSDATE' => '2016-10-25',
//                'BUDGETIDENT' => '1',
//                'BUDGETQUOTA' => '79999.01',
//                'BUDGETCYCLE' => '1',
//                'OVERQUOTA' => '3234.56',
//            ],
//            [
//                'SUBACCT' => '651234',
//                'SUBNAME' => '核心V3测试子账户3',
//                'CALINTSIDENT' => '1',
//                'RATECODE' => '01000000',
//                'RATESCALEFLTVAL' => '0.0',
//                'RATEPOINTFLTVAL' => '0.05',
//                'RATEWORKDATE' => '2016-10-25',
//                'ADJINTSIDENT' => '3',
//                'ADJINTSCYCLE' => 'D00',
//                'FIRADJINTSDATE' => '2016-10-25',
//                'BUDGETIDENT' => '0',
//                'BUDGETQUOTA' => '0.00',
//                'BUDGETCYCLE' => '0',
//                'OVERQUOTA' => '0.00',
//            ],
//        ],
//    ],
//];
//$structure = new \LazyBench\Banks\IndustrialBank\Structure\SubAccountOpen();
//$test->varExport($test->handleRequest($requestBody, $structure), '虚拟子账户批量开户成功');
//$test->varExport($test->handleRequest($requestBody, $structure), '虚拟子账户批量开户失败');
//$test->echo($structure->getRequestString());
//exit;
//$xmlString = file_get_contents('../xml/request/主账户对外转账.xhtml');
//$xmlTool = new \LazyBench\Banks\Xml\XmlConverter($xmlString);
//$test->varExport($xmlTool->createArray(), '');
//$requestBody = [
//    'XFERRQ' => [
//        'XFERINFO' => [
//            'ACCTFROM' => [
//                'ACCTID' => '117010100150190084',
//            ],
//            'ACCTTO' => [
//                'ACCTID' => '117010100100076908',
//                'NAME' => 'test1',
//                'BANKDESC' => '',
//                'BANKNUM' => '',
//                'CITY' => '',
//                '@ATTRIBUTES' => [
//                    'INTERBANK' => 'Y',
//                    'LOCAL' => 'Y',
//                ],
//            ],
//            'CHEQUENUM' => '',
//            'TRNAMT' => '1.24',
//            'PURPOSE' => '转账给冥冥吃饭',
//            'MEMO' => '备注1119',
//        ],
//    ],
//];
//$structure = new \LazyBench\Banks\IndustrialBank\Structure\OutTransfer('aaa');
//$test->varExport($test->handleRequest($requestBody, $structure), '主账号对外转账成功');
//$test->echo($structure->getRequestString(),'主账号对外转账请求');
//$test->varExport($test->handleRequest($requestBody, $structure), '主账号对外转账失败');
//exit;
//$xmlString = file_get_contents('../xml/request/查询转账交易.xhtml');
//$xmlTool = new \LazyBench\Banks\Xml\XmlConverter($xmlString);
//$test->varExport($xmlTool->createArray(), '查询转账交易');
//$requestBody = [
//    'XFERINQRQ' => [
//        'CLIENTREF' => '20141119zzfc100',
//    ],
//];
//$structure = new \LazyBench\Banks\IndustrialBank\Structure\OutTransferQuery();
//$test->varExport($test->handleRequest($requestBody, $structure), '查询转账交易');
//$test->echo($structure->getRequestString());
//exit;
//$xmlString = file_get_contents('../xml/request/quick/行内转账.xhtml');
//$xmlTool = new \LazyBench\Banks\Xml\XmlConverter($xmlString);
//$test->varExport($xmlTool->createArray(), '行内转账');
//$requestBody = [
//    'XMPTRQ' => [
//        'FUNDACCT' => [
//            'ACCTID' => '216200100100017556',
//        ],
//        'XFERINFO' => [
//            'ACCTFROM' => [
//                'ACCTID' => '216200100100017556',
//                'NAME' => 'test',
//            ],
//            'ACCTTO' => [
//                'ACCTID' => '117010100100000560',
//                'NAME' => 'testACVD',
//                '@ATTRIBUTES' => [
//                    'INTERBANK' => 'N',
//                    'LOCAL' => 'N',
//                ],
//            ],
//            'TRNAMT' => '8.75',
//            'PURPOSE' => 'test快速转账支付用途麤',
//            'MEMO' => '支付备注',
//        ],
//    ],
//];
//$structure = new \LazyBench\Banks\IndustrialBank\Structure\QuickOutInnerTransfer();
//$test->varExport($test->handleRequest($requestBody, $structure), '行内转账');
//$test->echo($structure->getRequestString());
//exit;
//$xmlString = file_get_contents('../xml/request/quick/跨行大小额转账.xhtml');
//$xmlTool = new \LazyBench\Banks\Xml\XmlConverter($xmlString);
//$test->varExport($xmlTool->createArray(), '跨行大小额转账');
//$requestBody = [
//    'XMPTRQ' => [
//        'FUNDACCT' => [
//            'ACCTID' => '117010100100000177',
//        ],
//        'XFERINFO' => [
//            'ACCTFROM' => [
//                'ACCTID' => '117010100100000177',
//                'NAME' => 'test',
//            ],
//            'ACCTTO' => [
//                'ACCTID' => '21734639147391473974392',
//                'NAME' => '中国铁路集团财务公司',
//                'BANKDESC' => '工商银行',
//                'BANKNUM' => '102502052062',
//                'CITY' => '海口',
//                '@ATTRIBUTES' => [
//                    'INTERBANK' => 'N',
//                    'LOCAL' => 'N',
//                ],
//            ],
//            'TRNAMT' => '4.75',
//            'PURPOSE' => 'test快速转账支付用途麤',
//            'MEMO' => '支付备注',
//        ],
//    ],
//];
//$structure = new \LazyBench\Banks\IndustrialBank\Structure\QuickOutTransfer();
//$test->varExport($test->handleRequest($requestBody, $structure), '跨行大小额转账');
//$test->echo($structure->getRequestString());
//exit;
//$xmlString = file_get_contents('../xml/request/quick/转账支付指令查询.xhtml');
//$xmlTool = new \LazyBench\Banks\Xml\XmlConverter($xmlString);
//$test->varExport($xmlTool->createArray(), '转账支付指令查询');
//$requestBody = [
//    'XFERINQRQ' => [
//        'CLIENTREF' => 'testy533353',
//    ],
//];
//$structure = new \LazyBench\Banks\IndustrialBank\Structure\QuickOutTransferQuery();
//$test->varExport($test->handleRequest($requestBody, $structure), '快速转账支付指令查询无记录');
//$test->varExport($test->handleRequest($requestBody, $structure), '快速转账支付指令查询有记录');
//$test->echo($structure->getRequestString());
//exit;
//$xmlString = file_get_contents('../xml/request/async/批量支付.xhtml');
//$xmlTool = new \LazyBench\Banks\Xml\XmlConverter($xmlString);
//$test->varExport($xmlTool->createArray(), '批量支付');
//$requestBody = [
//    'RQBODY' => [
//        'TITLE' => '异步批量支付',
//        'ACCTFROM' => [
//            'ACCTID' => '117010130400122277',
//            'NAME' => 'test',
//            'BANKDESC' => '兴业银行',
//            'CITY' => '福州',
//        ],
//        'BIZTYPE' => '0',
//        'TOTALCOUNT' => '3',
//        'TOTALAMOUNT' => '16.25',
//        'CURSYM' => 'RMB',
//        'PURPOSE' => 'test网银支付麤',
//        'MEMO' => '银企测试备注',
//        'XFERINFOTEXT' => [
//            '@value' => '
//            1|117010100150190084|银企测试182|Y|Y||||3.01|purpose|memo|
//            2|21100000601|沈木兰|Y|N||||5.78|test网银支付麤|备注<>|
//            3|1234567-89-20130917|银企测试跨行|N|N|105312828008|中国建设银行|台州|7.46|用途&lt;&lt;|备注<>|
//            ',
//            '@ATTRIBUTES' => [
//                'size' => '3',
//            ],
//        ],
//    ],
//];
//$structure = new \LazyBench\Banks\IndustrialBank\Structure\BatOutTransfer();
//$xml = $test->handleRequestString($requestBody, $structure, 'cf3213e233333');
//$test->varExport($test->handleRequest($requestBody, $structure), '批量支付成功');
//$test->varExport($test->handleRequest($requestBody, $structure), '批量支付有误');
//$test->echo($structure->getRequestString());
//exit;
//$xmlString = file_get_contents('../xml/request/async/批量支付查询.xhtml');
//$xmlTool = new \LazyBench\Banks\Xml\XmlConverter($xmlString);
//$test->varExport($xmlTool->createArray(), '批量支付查询');
//$requestBody = [
//    'ASYNBATCHTRSFRTRNRQ' => [
//        'TRNUID' => 'cf3213e233333',
//    ],
//];
//$structure = new \LazyBench\Banks\IndustrialBank\Structure\BatOutTransferQuery();
//$xml = $test->handleRequestString([], $structure, 'cf3213e233333');
//$test->varExport($test->handleRequest([], $structure), '批量支付查询无记录');
//$test->varExport($test->handleRequest([], $structure), '批量支付查询有记录');
//$test->echo($structure->getRequestString());
//exit;
//$xmlString = file_get_contents('../xml/request/sub/查询单个子账户详细.xhtml');
//$xmlTool = new \LazyBench\Banks\Xml\XmlConverter($xmlString);
//$test->varExport($xmlTool->createArray(), '查询单个子账户详细');
//exit;
//$xmlString = file_get_contents('../xml/request/sub/查询所有子账户详细.xhtml');
//$xmlTool = new \LazyBench\Banks\Xml\XmlConverter($xmlString);
//$test->varExport($xmlTool->createArray(), '查询所有子账户详细');
//$requestBody = [
//    'INQUIRYINFO' => [
//        'MAINACCT' => $test->getIndustrial()->getConfig()->getMainAccount(),
//        'SUBACCT' => 'ALL',
//        'STARTROW' => '1',
//    ],
//];
//$structure = new \LazyBench\Banks\IndustrialBank\Structure\SubAccountQuery();
//$test->varExport($test->handleRequest($requestBody, $structure), '查询所有子账户详细');
//$test->varExport($test->handleRequest($requestBody, $structure), '查询单个子账户详细无记录');
//$test->echo($structure->getRequestString(), '查询所有子账户详细');
//exit;
//$xmlString = file_get_contents('../xml/request/sub/虚拟子账户内部转账.xhtml');
//$xmlTool = new \LazyBench\Banks\Xml\XmlConverter($xmlString);
//$test->varExport($xmlTool->createArray(), '虚拟子账户内部转账请求');
//$requestBody = [
//    'VSAINTRSFRQ' => [
//        'MAINACCT' => $test->getIndustrial()->getConfig()->getMainAccount(),
//        'SUBACCT' => '7788',
//        'SUBNAME' => 'test',
//        'TOSUBACCT' => '0592',
//        'TOSUBNAME' => 'test测试',
//        'TRNAMT' => '1.26',
//        'PURPOSE' => '测试用途',
//        'MEMO' => '测试备注',
//        'DTDUE' => '2015-07-31',
//    ],
//];
//$structure = new \LazyBench\Banks\IndustrialBank\Structure\SubInnerTransfer();
//$test->varExport($test->handleRequest($requestBody, $structure), '虚拟子账户内部转账');
//$test->echo($structure->getRequestString(), '虚拟子账户内部转账请求');
//exit;
//$xmlString = file_get_contents('../xml/request/sub/虚拟子帐户对外支付.xhtml');
//$xmlTool = new \LazyBench\Banks\Xml\XmlConverter($xmlString);
//$test->varExport($xmlTool->createArray(), '虚拟子帐户对外支付');
//$requestBody = [
//    'VATRQ' => [
//        'VATTYPE' => '1',
//        'MAINACCT' => '117010130400122277',
//        'SUBACCT' => '0006',
//        'XFERINFO' => [
//            'ACCTFROM' => [
//                'ACCTID' => '117010130400122277',
//                'NAME' => 'test',
//            ],
//            'ACCTTO' => [
//                'ACCTID' => '47391743917493174931749',
//                'NAME' => 'test',
//                'BANKDESC' => '招商银行北京分行',
//                'CITY' => '北京',
//                '@ATTRIBUTES' => [
//                    'INTERBANK' => 'N',
//                    'LOCAL' => 'N',
//                ],
//            ],
//            'TRNAMT' => '3.11',
//            'PMTMODE' => 'REAL_TIME',
//            'PURPOSE' => '虚拟子账户对外支付用途',
//            'DTDUE' => '2013-03-06',
//            'MEMO' => '虚拟子账户对外支付测试备注',
//        ],
//    ],
//];
//$structure = new \LazyBench\Banks\IndustrialBank\Structure\SubOutTransfer();
//$test->varExport($test->handleRequest($requestBody, $structure), '虚拟子帐户对外支付');
//$test->echo($structure->getRequestString(), '虚拟子帐户对外支付请求');
//exit;
