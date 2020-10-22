<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2020/10/21
 * Time: 10:28
 */

namespace LazyBench\Banks\IndustrialBank\Traits;


use LazyBench\Banks\ArrayToXml\XmlToArray;

trait ResponseTrait
{
    /**
     * 响应
     * @var
     */
    protected $error;
    protected $errNo;
    protected $responseTrnUid;
    protected $statusMsg;
    protected $statusCode;
    protected $payStatus;
    protected $responseBody = [];
    protected $responseString;

    /**
     * Author:LazyBench
     *
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Author:LazyBench
     *
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Author:LazyBench
     *
     * @return mixed
     */
    public function getStatusMsg()
    {
        return $this->statusMsg;
    }

    /**
     * Author:LazyBench
     *
     * @return mixed
     */
    public function getErrNo()
    {
        return $this->errNo;
    }

    /**
     * Author:LazyBench
     *
     * @return mixed
     */
    public function getResponseString()
    {
        return $this->responseString;
    }

    /**
     * Author:LazyBench
     * 获取响应内容
     * @return mixed
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * Author:LazyBench
     * 获取支付状态
     * @return mixed
     */
    public function getPayStatus()
    {
        return $this->payStatus;
    }

    /**
     * Author:LazyBench
     *
     * @return mixed
     */
    public function getResponseTrnUid()
    {
        return $this->responseTrnUid;
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
        $this->responseString = "<?xml version='1.0' encoding='GBK' ?>{$response['content']}";
        $content = $xml->buildArrayFromString($this->responseString);
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
        $this->statusMsg = $responseBody['STATUS']['ERROR'] ?? '未知错误';
        $this->handleResponseBody($responseBody);
        return true;
    }

}
