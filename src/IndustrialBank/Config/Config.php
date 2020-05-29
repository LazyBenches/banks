<?php
/**
 * Created by PhpStorm.
 * Email:jwy226@qq.com
 * User: LazyBench
 * Date: 2019/11/20
 * Time: 12:38
 */

namespace LazyBench\Banks\IndustrialBank\Config;

class Config
{
    protected $url;
    protected $logDir = '';
    protected $encoding = 'GBK';
    protected $cid;//企业网银客户号，10位数字字符必输
    protected $userId;//登录用户名，最长：20位必输
    protected $userPass;//登录密码，最长：30位;必输
    protected $genUserKey = 'N';//否需要服务器产生USERKEY,，填Y、N; 必输
    protected $appId;//客户端应用程序编码，五个字符 非必输
    protected $appVer;//客户端应用程序版本 ; 非必输
    protected $mainAccount;//18位主账户

    /**
     * Author:LazyBench
     *
     * @param $mainAccount
     */
    public function setMainAccount($mainAccount)
    {
        $this->mainAccount = $mainAccount;
    }

    /**
     * Author:LazyBench
     *
     * @param $cid
     */
    public function setCid($cid)
    {
        $this->cid = $cid;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setUserPass($userPass)
    {
        $this->userPass = $userPass;
    }

    public function setGenUserKey($genUserKey)
    {
        $this->genUserKey = $genUserKey;
    }

    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    public function setAppVer($appVer)
    {
        $this->appVer = $appVer;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    public function setLogDir($logDir)
    {
        $this->logDir = $logDir;
    }

    public function getEncoding()
    {
        return $this->encoding;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getCid()
    {
        return $this->cid;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getUserPass()
    {
        return $this->userPass;
    }

    public function getGenUserKey()
    {
        return $this->genUserKey;
    }

    public function getAppId()
    {
        return $this->appId;
    }

    public function getAppVer()
    {
        return $this->appVer;
    }

    public function getMainAccount()
    {
        return $this->mainAccount;
    }

    public function getLogDir()
    {
        return $this->logDir;
    }

    public function checkVar()
    {
        if (!$this->cid) {
            throw new \Exception('cid 信息不存在');
        }
        if (!$this->userId) {
            throw new \Exception('userId 信息不存在');
        }
        if (!$this->userPass) {
            throw new \Exception('userPass 信息不存在');
        }
        if (!$this->genUserKey) {
            throw new \Exception('genUserKey 信息不存在');
        }
        if (!$this->mainAccount) {
            throw new \Exception('mainAccount 信息不存在');
        }
        return true;
    }
}
