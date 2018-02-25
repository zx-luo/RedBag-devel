<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>欢迎登录后台管理系统</title>
<link href="/Public/Admin/css/base.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/right.css" rel="stylesheet" type="text/css">
<link href="/Public/Admin/css/select.css" rel="stylesheet" type="text/css">

<script src="/Public/js/jquery-2.1.1.min.js"></script>
<script src="/Public/js/select-ui.min.js"></script>

<script>
$(document).ready(function(){	
   $(".select1").uedSelect({
		width : 345		  
   });
});
function removeFile(e){	$(e).parent().parent().remove();}
</script>
</head>
<body>
<div class="place"> <span>位置：</span>
  <ul class="placeul">
    <li><a href="<?php echo U('Index/center');?>">首页</a></li>
    <li><a href="<?php echo U('index');?>">代理等级</a></li>
    <li>编辑</li>
  </ul>
</div>
<div class="formbody">
  <div class="formtitle"><span>基本信息</span></div>
  <form id="fadd" name="fadd" method="post" action="<?php echo U('save?id='.$seldata[id]);?>">
   <ul class="forminfo">   
    <li>
      <label>代理等级</label>
      <div class="vocation">
      <select name="ydengji" class="select1">
        <option value="1" <?php if(($seldata[ydengji]) == "1"): ?>selected<?php endif; ?> > 1</option>
        <option value="2" <?php if(($seldata[ydengji]) == "2"): ?>selected<?php endif; ?> > 2</option>
        <option value="3" <?php if(($seldata[ydengji]) == "3"): ?>selected<?php endif; ?> > 3</option>
      </select>
      </div>
      <i>等级越高，佣金越高，目前最高3级</i></li>
    <li>
      <label>提成比例</label>
      <input name="ybaifenbi" type="text" value="<?php echo ($seldata['ybaifenbi']); ?>" class="dfinput" >
      <i></i></li>
    <li>
      <label>推广充值满</label>
      <input name="yjine" type="text" value="<?php echo ($seldata['yjine']/100); ?>" class="dfinput" >
      <i>元，自动升级有效，如果设置代理自动升级，到达充值额会自动升级</i></li>
    <li>
      <label>&nbsp;</label>
      <input type="submit" name="button" class="btn" value="确认保存" />
    </li>
  </ul>
  </form>
</div>
<div class="install"></div>
</body>
</html>