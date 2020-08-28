<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/20
 * Time: 17:46
 */

namespace LazyBench\Banks\IndustrialBank\Structure;

use LazyBench\Banks\ArrayToXml\ArrayToXml;
use LazyBench\Banks\ArrayToXml\XmlToArray;
use LazyBench\Banks\IndustrialBank\Config\Config;
use LazyBench\Banks\IndustrialBank\Interfaces\RequestInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

abstract class RequestBase implements RequestInterface
{
    protected $onlyHeader = false;
    protected $isQuery = true;
    protected $requestHeader;
    protected $responseTag = '';
    protected $requestTag = '';
    protected $requestBody = [];
    protected $responseBody = [];
    protected $error;
    protected $errNo;
    protected $responseTrnUid;
    protected $requestTrnUid;
    protected $responseBodyTag = '';
    protected $responseTransferBodyTag = '';
    protected $responseTransferBodyInfoTag = '';
    protected $statusMsg;
    protected $statusCode;
    protected $payStatus;
    protected $logDir;

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
        $this->logDir = $config->getLogDir();
    }

    /**
     * Author:LazyBench
     *
     * @param string $string
     * @param $file
     * @throws \Exception
     */
    public function debug(string $string, $file)
    {
        $formatter = new LineFormatter('%message%', '');
        $stream = new StreamHandler($file, Logger::DEBUG);
        $stream->setFormatter($formatter);
        $log = new Logger('bank');
        $log->pushHandler($stream);
        $log->info($string);
    }


    public function setRequestBody(array $body): RequestInterface
    {
        $this->requestBody = array_change_key_case($body, CASE_UPPER);
        return $this;
    }

    public function getResponseBody()
    {
        return $this->responseBody;
    }

    public function getPayStatus()
    {
        return $this->payStatus;
    }

    public function getResponseTrnUid()
    {
        return $this->responseTrnUid;
    }

    public function isQuery(): bool
    {
        return $this->isQuery;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getRequestTag(): string
    {
        return $this->requestTag;
    }

    public function getStatusMsg()
    {
        return $this->statusMsg;
    }

    public function getErrNo()
    {
        return $this->errNo;
    }

    /**
     * Author:LazyBench
     * trnUid  最大30位，建议值为YYYYMMDD+序号
     * @param $config
     * @return \DOMDocument|mixed
     * @throws \LazyBench\Banks\ArrayToXml\Exception\ConversionException
     */
    public function handle($config)
    {
        $xml = new ArrayToXml(['encoding' => 'GBK',]);
        if ($this->onlyHeader) {
            return $xml->buildXML($this->requestHeader, 'FOX')->saveXML();
        }
        $content = [
            'SECURITIES_MSGSRQV1' => [
                $this->requestTag => array_merge([
                    'TRNUID' => $this->requestTrnUid,//最大30位，建议值为YYYYMMDD+序号
                ], $this->requestBody),
            ],
        ];
        return $xml->buildXML(array_merge($this->requestHeader, $content), 'FOX')->saveXML();
    }

    /**
     * Author:LazyBench
     *
     * @param $response
     * @return bool|mixed
     * @throws \LazyBench\Banks\ArrayToXml\Exception\ConversionException
     *
     */
    public function handleResponse($response)
    {
        if ($response['httpCode'] !== '200') {
            $this->error = $response['error'] ?: '未返回错误信息';
            $this->errNo = $response['errNo'] ?: '';
            return false;
        }
        $xml = new XmlToArray(['encoding' => 'GBK',]);
        $responseString = "<?xml version='1.0' encoding='GBK' ?>{$response['content']}";
        $content = $xml->buildArrayFromString($responseString);
        $headerCode = (string)($content['FOX']['SIGNONMSGSRSV1']['SONRS']['STATUS']['CODE'] ?? '300');
        if ($headerCode !== '0') {
            $this->statusMsg = $content['FOX']['SIGNONMSGSRSV1']['SONRS']['STATUS']['MESSAGE'] ?? '未知错误';
            $this->statusCode = $headerCode;
            $this->responseBody = [];
            return false;
        }
        $responseBody = $content['FOX']['SECURITIES_MSGSRSV1'][$this->responseTag] ?? [];
        $this->responseTrnUid = $responseBody['TRNUID'] ?? '';
        $this->statusCode = $responseBody['STATUS']['CODE'] ?? '500';
        if ($this->statusCode !== '0') {
            $this->statusMsg = $responseBody['STATUS']['MESSAGE'] ?? '未知错误';
            if ($this->responseTransferBodyInfoTag) {
                $this->responseBody = $responseBody[$this->responseBodyTag][$this->responseTransferBodyTag][$this->responseTransferBodyInfoTag] ?? [];
            } elseif ($this->responseTransferBodyTag) {
                $this->responseBody = $responseBody[$this->responseBodyTag][$this->responseTransferBodyTag] ?? [];
            } else {
                $this->responseBody = $responseBody[$this->responseBodyTag] ?? [];
            }
            $this->responseBody = $responseBody[$this->responseBodyTag] ?? [];
            return false;
        }
        if ($this->responseTransferBodyInfoTag) {
            $this->payStatus = $responseBody[$this->responseBodyTag][$this->responseTransferBodyTag][$this->responseTransferBodyInfoTag]['XFERPRCSTS'] ?? [];
            $this->responseBody = $responseBody[$this->responseBodyTag][$this->responseTransferBodyTag][$this->responseTransferBodyInfoTag] ?? [];
        } elseif ($this->responseTransferBodyTag) {
            $this->payStatus = $responseBody[$this->responseBodyTag][$this->responseTransferBodyTag]['XFERPRCSTS'] ?? [];
            $this->responseBody = $responseBody[$this->responseBodyTag][$this->responseTransferBodyTag] ?? [];
        } else {
            $this->payStatus = $responseBody['XFERPRCSTS'] ?? [];
            $this->responseBody = $responseBody[$this->responseBodyTag] ?? [];
        }
        return true;
    }


    /**
     * Author:LazyBench
     *
     * @param $trnUid
     */
    public function __construct($trnUid)
    {
        $this->requestTrnUid = $trnUid;
    }
}
