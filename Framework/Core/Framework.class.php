<?php

class Framework
{
    private static function initConst()
    {
        define('DS', DIRECTORY_SEPARATOR);                    //定义目录分隔符
        define('ROOT_PATH', getcwd() . DS);                   //入口文件所在的目录
        define('APP_PATH', ROOT_PATH . 'Application' . DS);   //application目录
        define('CONFIG_PATH', APP_PATH . 'Config' . DS);
        define('CONTROLLER_PATH', APP_PATH . 'Controller' . DS);
        define('MODEL_PATH', APP_PATH . 'Model' . DS);
        define('VIEW_PATH', APP_PATH . 'View' . DS);
        define('FRAMEWORK_PATH', ROOT_PATH . 'Framework' . DS);
        define('CORE_PATH', FRAMEWORK_PATH . 'Core' . DS);
        define('LIB_PATH', FRAMEWORK_PATH . 'Lib' . DS);
        define('TRAITS_PATH', ROOT_PATH . 'Traits' . DS);
        define('PUBLIC_PATH', ROOT_PATH . 'Public' . DS);
    }

    // 配置文件
    private static function initConfig()
    {
        $GLOBALS['config'] = require CONFIG_PATH . 'config.php';
    }

    // 确定路由
    private static function initRoutes()
    {
        $p = $_GET['p'] ?? $GLOBALS['config']['app']['dp'];
        $c = $_GET['c'] ?? $GLOBALS['config']['app']['dc'];
        $a = $_GET['a'] ?? $GLOBALS['config']['app']['da'];
        $p = ucfirst(strtolower($p));
        $c = ucfirst(strtolower($c));                   //首字母大写
        $a = strtolower($a);                            //转成小写
        define('PLATFROM_NAME', $p);                    //平台名常量
        define('CONTROLLER_NAME', $c);                  //控制器名常量
        define('ACTION_NAME', $a);                      //方法名常量
        define('__URL__', CONTROLLER_PATH . $p . DS);   //当前请求控制器的目录地址
        define('__VIEW__', VIEW_PATH . $p . DS);        //当前视图的目录地址
    }

    // 自动加载类
    private static function initAutoLoad()
    {
        spl_autoload_register(function ($class_name) {
            $class_name = str_replace("\\", "/", $class_name);// dirname的路径需要"/"
            $namespace  = dirname($class_name);               //命名空间(和路径一致)
            $class_name = basename($class_name);              //类名
            if (in_array($namespace, ['Core', 'Lib']))   //命名空间在Core和Lib下
                $path = FRAMEWORK_PATH . $namespace . DS . $class_name . '.class.php';
            elseif ($namespace == 'Model')     //文件在Model下
                $path = MODEL_PATH . $class_name . '.class.php';
            elseif ($namespace == 'Traits')    //文件在Traits下
                $path = TRAITS_PATH . $class_name . '.class.php';
            else   //控制器
                $path = CONTROLLER_PATH . PLATFROM_NAME . DS . $class_name . '.class.php';
            if (file_exists($path) && is_file($path))
                require $path;
        });
    }

    // 请求分发
    private static function initDispatch()
    {
        $controller_name = '\Controller\\' . PLATFROM_NAME . '\\' . CONTROLLER_NAME . 'Controller';    //拼接控制器类名
        $action_name     = ACTION_NAME . 'Action';                                                     //拼接方法名
        $obj             = new $controller_name();
        $obj->$action_name();
    }

    //启动框架
    public static function run()
    {
        self::initConst();
        self::initConfig();
        self::initRoutes();
        self::initAutoLoad();
        self::initDispatch();
    }

    public static function logResult($word = '', $remarks = '')
    {
        $fp = fopen("log.txt", "a");
        flock($fp, LOCK_EX);
        fwrite($fp, $remarks . "  执行日期：" . strftime("%Y-%m-%d %H:%M:%S", time()) . "\n" . var_export($word, true) . "\n\n");//fwrite(file,string,length)
        flock($fp, LOCK_UN);
        fclose($fp);
    }
}
 