<?php

namespace Core;

use Lib\Session;

// 基础控制器
class Controller
{
    public function __construct()
    {
        $this->initSession();
    }

    // 初始化session
    private function initSession()
    {
        new Session();
    }
}
 
 