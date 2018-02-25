<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>程序安装</title>
<link rel="stylesheet" href="/Public/Install/css/index.css?v=<?php echo rand(0,20);?>" />
</head>

<body>
<div class="wrap">
  <div class="header">
    <h1 class="logo">程序安装</h1>
  </div>
  <div style="padding: 40px 20px;">
    <div class="text-center"> <a style="font-size: 18px;color: #1abc9c;">恭喜您，安装完成！</a> <br>
      <br>
      <a class="btn-success" href="/">进入前台</a> <a class="btn-success" href="<?php echo U('Mana/Index/index');?>">进入后台</a> </div>
  </div>
</div>
<div class="footer"> &copy; 77768688-<?php echo date('Y');?></div>
</body>
</html>