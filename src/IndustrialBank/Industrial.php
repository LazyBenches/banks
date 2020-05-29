<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/20
 * Time: 9:23
 */

namespace LazyBench\Banks\IndustrialBank;

use LazyBench\Banks\Curl\Curl;
use LazyBench\Banks\IndustrialBank\Config\Config;
use LazyBench\Banks\IndustrialBank\Interfaces\RequestInterface;
use LazyBench\Banks\Interfaces\Bank;

class Industrial implements Bank
{
    /**
     * Author:LazyBench
     *
     * @var Config
     */
    protected $config;
    protected $response;

    /**
     * Author:LazyBench
     *
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * Author:LazyBench
     *
     * @param $key
     * @param $value
     * @return $this|bool
     */
    public function setConfig($key, $value)
    {
        $this->config = $this->config ?: new Config();
        $method = "set{$key}";
        if (!method_exists($this->config, $method)) {
            return false;
        }
        $this->config->$method($value);
        return $this;
    }

    /**
     * Author:LazyBench
     * 生成对应的请求xml
     * @param RequestInterface $structure
     * @return string
     */
    public function handleRequestString(RequestInterface $structure): string
    {
        return $structure->handle($this->config);
    }

    /**
     * Author:LazyBench
     *
     * @param $requestBodyString
     * @param RequestInterface $structure
     * @return bool
     */
    public function request($requestBodyString, RequestInterface $structure): bool
    {
        $logDir = $this->config->getLogDir();
        is_dir($logDir) && $structure->debug($requestBodyString, $logDir.'/request/'.$structure->getRequestTag().'.xhtml');
        $curl = new Curl();
        $response = $curl->setHeader(['Content-Type:text/xml'])->setParams($requestBodyString)
                         ->post($this->config->getUrl());
        return $structure->handleResponse($response);
    }

    /**
     * Author:LazyBench
     *
     * @param RequestInterface $structure
     * @return bool
     */
    public function handleRequest(RequestInterface $structure): bool
    {
        return $this->request($this->handleRequestString($structure), $structure);
    }
}
