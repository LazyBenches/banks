<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/20
 * Time: 17:35
 */

namespace LazyBench\Banks\IndustrialBank\Traits;

use LazyBench\Banks\ArrayToXml\ArrayToXml;
use LazyBench\Banks\IndustrialBank\Config\Config;
use LazyBench\Banks\IndustrialBank\Interfaces\RequestInterface;

trait RequestTrait
{
    /**
     * 请求
     * @var bool
     */
    protected $onlyHeader = false;
    protected $requestHeader;
    protected $requestBody = [];
    protected $requestTrnUid;
    protected $requestString;


    /**
     * Author:LazyBench
     *
     * @param $trnUid
     */
    public function __construct($trnUid)
    {
        $this->requestTrnUid = $trnUid;
    }

    /**
     * Author:LazyBench
     * 设置请求头
     * @param Config $config
     * @param null $dateTime
     */
    public function setRequestHeader(Config $config, $dateTime = null)
    {
        $this->requestHeader = [
            'SIGNONMSGSRQV1' => [
                'SONRQ' => [
                    'DTCLIENT' => $dateTime ?: date('Y-m-d H:i:s'),
                    'CID' => $config->getCid(),
                    'USERID' => $config->getUserId(),
                    'USERPASS' => $config->getUserPass(),
                    'GENUSERKEY' => $config->getGenUserKey(),
                ],
            ],
        ];
    }

    /**
     * Author:LazyBench
     * 设置请求body
     * @param array $body
     * @return string
     * @throws \LazyBench\Banks\ArrayToXml\Exception\ConversionException
     */
    public function setRequestBody(array $body): string
    {
        $this->requestBody = array_change_key_case($body, CASE_UPPER);
        $xml = new ArrayToXml(['encoding' => 'GBK',]);
        if ($this->onlyHeader) {
            $this->requestString = $xml->buildXML($this->requestHeader, 'FOX')->saveXML();
            return $this->requestString;
        }
        $content = [
            'SECURITIES_MSGSRQV1' => [
                $this->requestTag => array_merge([
                    'TRNUID' => $this->requestTrnUid,//最大30位，建议值为YYYYMMDD+序号
                ], $this->requestBody),
            ],
        ];
        $this->requestString = $xml->buildXML(array_merge($this->requestHeader, $content), 'FOX')->saveXML();
        return $this->requestString;
    }


    public function getRequestTag(): string
    {
        return $this->requestTag;
    }


    /**
     * Author:LazyBench
     * 获取请求串
     * @return string
     */
    public function getRequestString(): string
    {
        return $this->requestString;
    }

}
