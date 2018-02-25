<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>欢迎登录后台管理系统</title>
<link href="/Public/Admin/css/base.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/right.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="place"> <span>位置：</span>
  <ul class="placeul">
    <li><a href="<?php echo U('Index/center');?>">首页</a></li>
    <li>接口信息</li>
  </ul>
</div>
<div class="formbody">
  <div class="formtitle"><span>微信接口地址</span></div>
  <ul class="forminfo">
    <li>
      <label>接口URL</label>
      <input type="text" value="http://<?php echo ($_SERVER['HTTP_HOST']); echo U('Api/Wechat/index?aid='.$_SESSION[adminid]);?>" class="dfinput" style="width:430px" />
      <i>token：<?php echo C('WX_TOKEN');?></i></li>
  </ul>
</div>
</body>
</html>