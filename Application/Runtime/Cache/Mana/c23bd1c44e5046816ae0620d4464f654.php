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
   
   $("input[name='ctype']").click(function(){
	   var ctype=parseInt($("input[name='ctype']:checked").val());
	   if(ctype==0){$("#guanjianci").hide();$("#weburl").show();}
	   if(ctype==1){$("#guanjianci").show();$("#weburl").hide();}
	   if(ctype==2 || ctype==3){$("#guanjianci").hide();$("#weburl").hide();}
   });   
});
</script>
</head>
<body>
<div class="place"> <span>位置：</span>
  <ul class="placeul">
    <li><a href="<?php echo U('Index/center');?>">首页</a></li>
    <li><a href="<?php echo U('show');?>">微信一级菜单</a></li>
    
    <?php if(($cid) > "0"): ?><li><a href="<?php echo U('show?cid='.$cid);?>">微信二级菜单</a></li><?php endif; ?>
    
    <li>编辑</li>
  </ul>
</div>
<div class="formbody">
  <div class="formtitle"><span>基本信息</span></div>
  <form name="fadd" method="post" action="<?php echo U('save?cid='.$cid.'&nid='.$seldata['id']);?>">
  <ul class="forminfo">
    <li>
      <label>菜单名字</label>
      <input name="cname" type="text" value="<?php echo ($seldata['cname']); ?>" class="dfinput" />
      <i></i></li>
    <li>
      <label>菜单顺序</label>
      <input name="cnum" type="text" value="<?php echo ($seldata['cnum']); ?>" class="dfinput" />
      <i>数字越大越靠前</i></li>
    
    <li>
      <label>菜单类型</label>
      <input name="ctype" type="radio" value="0" <?php if(($seldata['ctype'] == 0) OR ($seldata['ctype'] == '') ): ?>checked<?php endif; ?> > 网址跳转&nbsp;
      <input name="ctype" type="radio" value="1" <?php if(($seldata['ctype']) == "1"): ?>checked<?php endif; ?> > 关键词推送
      <input name="ctype" type="radio" value="2" <?php if(($seldata['ctype']) == "2"): ?>checked<?php endif; ?> > 扫一扫
      <input name="ctype" type="radio" value="3" <?php if(($seldata['ctype']) == "3"): ?>checked<?php endif; ?> > 拍照
      <i></i></li>
    
    <li id="weburl" <?php if(($seldata['ctype'] != 0) and ($seldata['ctype'] != '') ): ?>style="display:none"<?php endif; ?> >
      <label>跳转网址</label>
      <input name="curl" type="text" value="<?php echo ($seldata['curl']); ?>" class="dfinput" />
      <i>如果菜单类型选择了网址跳转，此项必填，网址以http开头</i></li>
    
    <li id="guanjianci"  <?php if(($seldata['ctype']) != "1"): ?>style="display:none"<?php endif; ?> >
      <label>关键词</label>
      <div class="vocation">
      <select name="ckey" class="select1">
      
          <?php if(is_array($optiondata)): foreach($optiondata as $key=>$vo): ?><option value="<?php echo ($vo["sname"]); ?>" <?php if(($vo['sname']) == $seldata['ckey']): ?>selected<?php endif; ?> >
		  <?php echo ($vo["sname"]); ?></option><?php endforeach; endif; ?>

        </select>
        </div>
      <i><a href="<?php echo U('Wxhuifu/keylist?stype=1');?>"><font color="#FF0000">关键词管理</font></a> 如果菜单类型选择了关键词推送，此项必选</i></li>
    <li>
      <label>&nbsp;</label>
      <input name="button" type="submit" class="btn" value="确认保存"/>
    </li>
  </ul>
  </form>
</div>
</body>
</html>