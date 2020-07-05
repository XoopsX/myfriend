<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

class MyFriend_Abstract
{
    var $isError = false;
    var $errMsg = "";
    var $mActionForm;
    var $url = 'index.php';


    function __construct()
    {
    }

    function setUrl($url)
    {
        $this->url = $url;
    }

    function getUrl()
    {
        return $this->url;
    }

    function setErr($msg)
    {
        $this->errMsg = $msg;
        $this->isError = true;
    }

    function getisError()
    {
        return $this->isError;
    }

    function geterrMsg()
    {
        return $this->errMsg;
    }

    function executeView(&$render)
    {
    }
}
