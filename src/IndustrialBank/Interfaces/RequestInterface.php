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
     * @param array $param
     * @return array
     */
    public function formatBody(array $param): array;

    /**
     * Author:LazyBench
     *
     * @return string
     */
    public function formatRequestString(): string;

    /**
     * Author:LazyBench
     * 设置请求头
     * @param Config $config
     * @param null $dateTime
     * @return mixed
     */
    public function setRequestHeader(Config $config, $dateTime = null);

    /**
     * Author:LazyBench
     *
     * @return mixed
     */
    public function getResponseBody();

    /**
     * Author:LazyBench
     * 获取标签
     * @return string
     */
    public function getRequestTag(): string;

    /**
     * Author:LazyBench
     * 获取请求串
     * @return string
     */
    public function getRequestString(): string;
}
