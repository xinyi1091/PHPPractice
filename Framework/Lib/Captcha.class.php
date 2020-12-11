<?php

namespace Lib;

class Captcha
{
    private $width;
    private $height;

    public function __construct($width = 80, $height = 32)
    {
        $this->width  = $width;
        $this->height = $height;
    }

    //生成随机字符串
    private function generalCode()
    {
        $all_array = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));    //所有字符数组
        $div_array = ['1', 'l', '0', 'o', 'O', 'I'];                                //去除容易混淆的字符
        $array     = array_diff($all_array, $div_array);                            //剩余的字符数组
        unset($all_array, $div_array);                                              //销毁不需要使用的数组
        $index = array_rand($array, 4);                                             //随机取4个字符,返回字符下标，按先后顺序排列
        shuffle($index);                                                            //打乱字符
        $code = '';
        foreach ($index as $i)
            $code .= $array[$i];
        $_SESSION['code'] = $code;        //保存到会话中
        return $code;
    }

    //创建验证码
    public function entry()
    {
        $code = $this->generalCode();

        /*   带背景图的验证码
               $path = PUBLIC_PATH . 'Admin/captcha/captcha_bg' . rand(1, 5) . '.jpg';
               $background =  imagecreatefromjpeg($path);
               $imageRes   = imagecreatetruecolor($this->width, $this->height);// 新建一个真彩色图像资源，默认是黑色，
               $color      = imagecolorallocate($imageRes, 0, 0, 0);// 为一幅图像分配颜色
               imagefill($imageRes, 0, 0, $color);
               // 重采样拷贝部分图像并调整大小
               imagecopyresampled($imageRes, $background, 0, 0, 0, 0, $this->width, $this->height, $this->width, $this->height);

               //第三步：将字符串写到图片上
               $font = 5;                                           //内置5号字体
               $x    = ($this->width - imagefontwidth($font) * strlen($code)) / 2;
               $y    = ($this->height - imagefontheight($font)) / 2;
               //随机前景色
               if (rand(1, 100) % 2)
                   $color = imagecolorallocate($imageRes, 255, 0, 0);    //设置背景色

               imagestring($imageRes, $font, $x, $y, $code, $color);
               //显示验证码
               header('content-type:image/gif');
               imagegif($imageRes);*/

        $img = imagecreate($this->width, $this->height);

        imagecolorallocate($img, 255, 0, 0);                 //分配背景色
        $color = imagecolorallocate($img, 255, 255, 255);    //分配前景色
        $font  = 5;                                          //内置5号字体
        $x     = (imagesx($img) - imagefontwidth($font) * strlen($code)) / 2;
        $y     = (imagesy($img) - imagefontheight($font)) / 2;
        imagestring($img, $font, $x, $y, $code, $color);
        //显示验证码
        header('content-type:image/gif');
        imagegif($img);
    }

    //验证码比较
    public function check($code)
    {
        return strtoupper($code) == strtoupper($_SESSION['code']);
    }
}
 
 