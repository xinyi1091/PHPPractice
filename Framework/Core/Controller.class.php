<?php

namespace Core;

use Lib\Session;
use Smarty;

// 基础控制器
class Controller
{
    protected $smarty;

    public function __construct()
    {
        $this->initSession();
        $this->initSmarty();
    }

    // 初始化session
    private function initSession()
    {
        new Session();
    }

    // 初始化Smarty
    private function initSmarty()
    {
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(__VIEW__);    //设置模板目录
        $this->smarty->setCompileDir(__VIEWC__);    //设置混编目录
    }
}
 
 