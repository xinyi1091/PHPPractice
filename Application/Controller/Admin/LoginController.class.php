<?php

namespace Controller\Admin;

//引入基础控制器
use Core\Model;
use Model\UserModel;
use Traits\Jump;
use Lib\Captcha;

class LoginController extends BaseController
{
    use Jump;

    //登录
    public function loginAction()
    {
        //第二步：执行登陆逻辑
        if (!empty($_POST)) {
            //校验验证码
            $captcha = new Captcha();
            if (!$captcha->check($_POST['passcode'])) {
                $this->error('index.php?p=Admin&c=Login&a=login', '验证码错误');
            }

            $model = new UserModel();
            if ($info = $model->getUserByNameAndPwd($_POST['username'], $_POST['password'])) {
                $_SESSION['user'] = $info;   //将用户信息保存到会话中
                $model->updateLoginInfo();   //更新登陆信息
                $this->success('index.php?p=Admin&c=Admin&a=admin', '登陆成功');
            } else {
                $this->error('index.php?p=Admin&c=Login&a=login', '登陆失败，请重新登陆');
            }
        }
        //第一步：显示登陆界面
        require __VIEW__ . 'login.html';
    }

    //注册
    public function registerAction()
    {
        //第二步：执行注册逻辑
        if (!empty($_POST)) {
            $data['user_name'] = $_POST['username'];
            $data['user_pwd']  = md5(md5($_POST['password']) . $GLOBALS['config']['app']['salt']);
            $model             = new Model('user');
            if ($model->insert($data))
                $this->success('index.php?p=Admin&c=Login&a=login', '注册成功，您可以去登陆了');
            else
                $this->error('index.php?p=Admin&c=Login&a=register', '注册失败，请重新注册');
        }
        //第一步：显示注册界面
        require __VIEW__ . 'register.html';
    }

    // ajax 检查用户名是否存在
    public function checkUserAction()
    {
        $model = new UserModel();
        echo $model->isExists($_GET['username']);
    }

    public function verifyAction()
    {
        $captcha = new Captcha();
        $captcha->entry();
    }
}
 