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
use LazyBench\Banks\IndustrialBank\Interfaces\ResponseInterface;
use LazyBench\Banks\Interfaces\Bank;

class Industrial implements Bank
{
    /**
     * Author:LazyBench
     *
     * @var Config
     */
    protected $config;

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
     *
     * @param RequestInterface|ResponseInterface $structure
     * @return bool
     */
    public function request(RequestInterface $structure): bool
    {
        $curl = new Curl();
        $response = $curl->setHeader(['Content-Type:text/xml'])->setParams($structure->getRequestString())
                         ->post($this->config->getUrl());
        return $structure->handleResponse($response);
    }
}
