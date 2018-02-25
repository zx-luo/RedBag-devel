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
  <div class="main">
    <pre class="agreement">

    </pre>
  </div>
  <div class="bottom text-center"> <a href="<?php echo U('Index/step1');?>" class="btn-primary">同意</a> </div>
</div>
<div class="footer"> &copy; 77768688-<?php echo date('Y');?> </div>
</body>
</html>