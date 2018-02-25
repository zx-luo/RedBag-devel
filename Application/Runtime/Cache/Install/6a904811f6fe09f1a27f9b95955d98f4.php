<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>程序安装向导</title>
<link rel="stylesheet" href="/Public/Install/css/index.css?v=<?php echo rand(0,20);?>" />
<script>
function check(){
	var str = document.install ;
	if(str.dbname.value == '') {
	    alert('数据库名不能为空');	
		str.dbname.focus();
		return false;
	}
	if(str.manager_pwd.value == '') {
	    alert('密码不能为空');	
		str.manager_pwd.focus();
		return false;
	}
	if(str.manager_ckpwd.value == '') {
	    alert('重复密码不能为空');	
		str.manager_ckpwd.focus();
		return false;
	}
	if(str.manager_ckpwd.value != str.manager_pwd.value) {
	    alert('两次密码不一致');	
		str.manager_pwd.focus();
		return false;
	}
	return true;
}
</script>
</head>

<body>
<div class="wrap">
  <div class="header">
    <h1 class="logo">程序安装向导</h1>
  </div>
  <div class="step">
    <ul class="unstyled">
      <li class="on"><em>1</em>检测环境</li>
      <li class="current"><em>2</em>创建数据</li>
      <li><em>3</em>完成安装</li>
    </ul>
  </div>
  <form name="install" action="<?php echo U('Index/step3');?>" method="post" onSubmit="return check()">
    <div class="server">
      <table width="100%">
        <tr>
          <td class="td1" width="100">数据库信息</td>
          <td class="td1" width="200">&nbsp;</td>
          <td class="td1">&nbsp;</td>
        </tr>
        <tr>
          <td class="text-left">数据库服务器：</td>
          <td><input type="text" name="dbhost" value="127.0.0.1" class="input"></td>
          <td><span class="gray">数据库服务器地址，一般为127.0.0.1</span></td>
        </tr>
        <tr>
          <td class="text-left">数据库端口：</td>
          <td><input type="text" name="dbport" value="3306" class="input"></td>
          <td><span class="gray">数据库服务器端口，一般为3306</span></td>
        </tr>
        <tr>
          <td class="text-left">数据库用户名：</td>
          <td><input type="text" name="dbuser" value="root" class="input"></td>
          <td></td>
        </tr>
        <tr>
          <td class="text-left">数据库密码：</td>
          <td><input type="password" name="dbpw" class="input" autoComplete="off"></td>
          <td></td>
        </tr>
        <tr>
          <td class="text-left">数据库名：</td>
          <td><input type="text" name="dbname" class="input"></td>
          <td></td>
        </tr>
        <tr>
          <td class="text-left">数据库表前缀：</td>
          <td><input type="text" name="dbprefix" value="77768688_" class="input"></td>
          <td><span class="gray">建议使用默认，同一数据库安装多个时需修改</span></td>
        </tr>
      </table>
      <table width="100%">
        <tr>
          <td class="td1" width="100">创始人信息</td>
          <td class="td1" width="200">&nbsp;</td>
          <td class="td1">&nbsp;</td>
        </tr>
        <tr>
          <td class="text-left">管理员帐号：</td>
          <td><input type="text" name="manager" value="admin" class="input"></td>
          <td></td>
        </tr>
        <tr>
          <td class="text-left">密码：</td>
          <td><input type="password" name="manager_pwd" class="input" autoComplete="off"></td>
          <td></td>
        </tr>
        <tr>
          <td class="text-left">重复密码：</td>
          <td><input type="password" name="manager_ckpwd" class="input" autoComplete="off"></td>
          <td></td>
        </tr>
      </table>
    </div>
    <div class="bottom text-center"> <a href="<?php echo U('Index/step1');?>" class="btn-primary">上一步</a>
      <button type="submit" class="btn-primary">创建数据</button>
    </div>
  </form>
</div>
<div class="footer"> &copy; 77768688-<?php echo date('Y');?> </div>
</body>
</html>