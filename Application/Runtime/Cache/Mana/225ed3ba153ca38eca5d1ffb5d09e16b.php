<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>欢迎登录后台管理系统</title>
<link href="/Public/Admin/css/base.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/right.css" rel="stylesheet" type="text/css">
<script src="/Public/js/jquery-2.1.1.min.js"></script>
<script>
$(document).ready(function(){	
   $(function(){
      $('.rightinfo tbody tr:odd').css("backgroundColor","#f5f8fa");	
   })
   $(".btn").click(function(){
	  var upass = $("input[name='upass']").val();
	  var upasss = $("input[name='upasss']").val();
	  if(upass!=upasss || upass==''){
		 alert("密码填写错误");
		 return false;
      }
	   $.post("<?php echo U('Sysuser/passsave');?>",{upass:upass},function(data){
		   alert("修改成功");
	   });
   });
});
</script>
</head>
<body>
<div class="place"> <span>位置：</span>
  <ul class="placeul">
    <li><a href="<?php echo U('Index/center');?>">首页</a></li>
    <li>帐号设置</li>
  </ul>
</div>
<div class="formbody">
  <div class="formtitle"><span>基本信息</span></div>
  <ul class="forminfo">
    <li>
      <label>帐号</label>
      <cite><?php echo (session('uname')); ?></cite><i></i></li>
    <li>
      <label>密码</label>
      <input name="upass" type="password" class="dfinput" />
      <i></i></li>
    <li>
      <label>确认密码</label>
      <input name="upasss" type="password" class="dfinput" />
      <i></i></li>
    <li>
      <label>&nbsp;</label>
      <input name="button" type="button" class="btn" value="确认保存"/>
    </li>
  </ul>
</div>
</body>
</html>