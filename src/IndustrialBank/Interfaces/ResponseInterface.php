<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/21
 * Time: 10:42
 */

namespace LazyBench\Banks\IndustrialBank\Interfaces;


interface ResponseInterface
{

    /**
     * Author:LazyBench
     *
     * @param $response
     * @return mixed
     */
    public function handleResponse($response);

    public function getPayStatus();

    public function getStatusMsg();

    public function getStatusCode();

    public function getResponseTrnUid();

    public function getError();

    public function getErrNo();

    public function getResponseString();

    public function getResponseBody();
}
