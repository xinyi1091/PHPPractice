<?php

namespace Controller\Admin;

use Core\Controller;
use Traits\Jump;

class  BaseController extends Controller
{
    use Jump;

    public function __construct()
    {
        parent::__construct();
        $this->checkLogin();
    }

    //验证是否登录
    private function checkLogin()
    {
        if (CONTROLLER_NAME == 'Login')    //登录控制器不需要验证
            return;
        if (empty($_SESSION['user'])) {
            $this->error('index.php?p=Admin&c=Login&a=login', '您没有登录');
        }
    }
}
 