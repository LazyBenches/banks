<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/21
 * Time: 10:16
 */

class Socket
{
    public const PKG_EOF = "\r\n\r\n";

    public function requestJson(string $host, string $cmd, $data, $ext = []) {
        $fp = stream_socket_client($host, $errno, $errStr);
        if (!$fp) {
            throw new \Exception("stream_socket_client fail errno={$errno} errStr={$errStr}");
        }
        $req = [
            'cmd'  => $cmd,
            'data' => $data,
            'ext' => $ext,
        ];
        $data = json_encode($req) . self::PKG_EOF;
        fwrite($fp, $data);
        $result = '';
        while (!feof($fp)) {
            $tmp = stream_socket_recvfrom($fp, 1024);
            if ($pos = strpos($tmp, self::PKG_EOF)) {
                $result .= substr($tmp, 0, $pos);
                break;
            }
            $result .= $tmp;
        }
        fclose($fp);
        return json_decode($result, true);
    }
}


$ret = request('tcp://127.0.0.1:18309', 'echo', 'i an client');

var_dump($ret);
