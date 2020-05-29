<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/20
 * Time: 20:31
 */

namespace LazyBench\Banks\IndustrialBank\Interfaces;


use LazyBench\Banks\IndustrialBank\Config\Config;

interface RequestInterface
{
    /**
     * Author:LazyBench
     *
     * @param Config $config
     * @return mixed
     */
    public function handle(Config $config);

    /**
     * Author:LazyBench
     *
     * @param $body
     * @return RequestInterface
     */
    public function setRequestBody(array $body): RequestInterface;

    /**
     * Author:LazyBench
     *
     * @return mixed
     */
    public function getResponseBody();

    /**
     * Author:LazyBench
     *
     * @param $response
     * @return mixed
     */
    public function handleResponse($response);

    public function setRequestHeader(Config $config, $dateTime = null);

    public function getPayStatus();

    public function getStatusMsg();

    public function getStatusCode();

    public function getResponseTrnUid();

    public function isQuery(): bool;

    public function getError();

    public function getErrNo();

    public function getRequestTag(): string;
}
