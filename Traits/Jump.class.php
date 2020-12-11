<?php

namespace Traits;
/*
 * 页面跳转
 * */

trait Jump
{
    //封装成功的跳转
    public function success($url, $info = '', $time = 1)
    {
        $this->redirect($url, $info, $time, 'success');
    }

    //封装失败跳转
    public function error($url, $info = '', $time = 3)
    {
        $this->redirect($url, $info, $time, 'error');
    }

    /**
     * @desc 跳转的方法
     *
     * @param $url  string 跳转的地址
     * @param $info string 显示信息
     * @param $time int    停留时间
     * @param $flag string 显示模式  success|error
     */
    private function redirect($url, $info, $time, $flag)
    {
        if ($info == '')
            header("location:{$url}");
        else {
            echo <<<str
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
<style>
body{
	text-align: center;
	font-family: "Arial","Microsoft YaHei","黑体","宋体",sans-serif;;
	font-size: 18px;
}
#success,#error{
	font-size: 36px;
	margin: 10px auto;
}
#success{
	color: #090;
}
#error{
	color: #F00;
}
</style>
</head>
<body>
	<img src="/Public/Images/{$flag}.fw.png" alt="{$flag}.fw.png">
	<div id='{$flag}'>{$info}</div>
	<div><span id='t'>{$time}</span>秒以后跳转</div>
</body>
</html>
<script>
window.onload=function(){
	var t={$time};
	setInterval(function(){
		document.getElementById('t').innerHTML=--t;
		if(t==0)
			location.href="{$url}";
	},1000)
}
</script>
str;
            exit;
        }
    }
}
 
 