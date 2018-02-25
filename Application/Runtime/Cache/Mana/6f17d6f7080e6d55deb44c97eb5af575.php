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
   $('#monisub').click(function(){
	   $('#dengdai').show();
	   var options = {
              url: '<?php echo U("ajaxmoni");?>',
              type: 'post',
              dataType: 'html',
              data: $("#fadd").serialize(),
              success: function (data) {
				  $('.install').show();
				  $('.install').html(data);
				  $('#dengdai').hide();
              }
            };
        $.ajax(options);
		return false;
   });
});
function removeFile(e){	$(e).parent().parent().remove();}
</script>
<style>
#dengdai{ position:fixed; top:0; left:0; right:0; bottom:0;background-color: rgba(0,0,0,0.5); z-index:99999;display: none;}
#dengdai .loading { width: 80px; height: 40px; margin: 0 auto; margin-top: 20%; }
#dengdai .loading span { display: inline-block; width: 8px; height: 100%; border-radius: 4px; background: lightgreen; -webkit-animation: load 1s ease infinite; }
 @-webkit-keyframes load {  0%, 100% {
 height: 40px;
 background: lightgreen;
}
 50% {
 height: 70px;
 margin: -15px 0;
 background: lightblue;
}
}
#dengdai .loading span:nth-child(2) { -webkit-animation-delay: 0.2s; }
#dengdai .loading span:nth-child(3) { -webkit-animation-delay: 0.4s; }
#dengdai .loading span:nth-child(4) { -webkit-animation-delay: 0.6s; }
#dengdai .loading span:nth-child(5) { -webkit-animation-delay: 0.8s; }
.install { box-shadow: 5px 5px 5px #f7f7f7 inset; border: 1px solid #bdbcbc; width: 530px; height: 200px; overflow: hidden; display: block; overflow-y: scroll; margin-left:123px; font-size: 12px; margin-bottom: 22px; outline: none; display:none; line-height:30px; word-break:break-all; padding:5px; }
.zhuanimg{ margin-left:123px;}
.zhuanimg img{ width:300px;}
</style>
</head>
<body>
<div id="dengdai">
    <div class="loading">
           <span></span>
           <span></span>
           <span></span>
           <span></span>
           <span></span>
    </div>
</div>
<div class="place"> <span>位置：</span>
  <ul class="placeul">
    <li><a href="<?php echo U('Index/center');?>">首页</a></li>
    <li>转盘设置</li>
  </ul>
</div>
<div class="formbody">
  <div class="formtitle"><span>基本信息</span></div>
  <form id="fadd" name="fadd" method="post" action="<?php echo U('save?id='.$seldata[id]);?>">
    <input type="hidden" name="htime" value="<?php echo ($seldata['htime'] ? $seldata['htime']:time()); ?>">
   <ul class="forminfo">   
    <li>
      <label>转盘价格</label>
      <input name="hzhifue" type="text" value="<?php echo ($seldata['hzhifue']/100); ?>" class="dfinput" >
      <i>元</i></li>
    <li>
      <label>转盘概率</label>角度
      <input name="hjiaodu[]" type="text" value="<?php echo ($hbgailv[0][hjiaodu]); ?>" style="width:80px;" class="dfinput" > &nbsp;&nbsp;&nbsp;&nbsp;红包范围
      <input name="hmin[]" type="text" value="<?php echo ($hbgailv[0][hmin]/100); ?>" style="width:80px;" class="dfinput" > 元 -
      <input name="hmax[]" type="text" value="<?php echo ($hbgailv[0][hmax]/100); ?>" style="width:80px;" class="dfinput" > 元&nbsp;&nbsp;&nbsp;&nbsp;概率
      <input name="hgailv[]" type="text" value="<?php echo (intval($hbgailv[0][hgailv])); ?>" style="width:80px;" class="dfinput" >&nbsp;&nbsp;&nbsp;&nbsp;第
      <input name="hcishu[]" type="text" value="<?php echo (intval($hbgailv[0][hcishu])); ?>" style="width:80px;" class="dfinput" > 次中   
      <i>所有概率的和为分母，填写的值为分子计算概率，第几次可以不填</i></li>
    <?php $__FOR_START_24678__=1;$__FOR_END_24678__=8;for($i=$__FOR_START_24678__;$i < $__FOR_END_24678__;$i+=1){ ?><li>
      <label>&nbsp;</label>角度
      <input name="hjiaodu[]" type="text" value="<?php echo ($hbgailv[$i][hjiaodu]); ?>" style="width:80px;" class="dfinput" > &nbsp;&nbsp;&nbsp;&nbsp;红包范围
      <input name="hmin[]" type="text" value="<?php echo ($hbgailv[$i][hmin]/100); ?>" style="width:80px;" class="dfinput" > 元 -
      <input name="hmax[]" type="text" value="<?php echo ($hbgailv[$i][hmax]/100); ?>" style="width:80px;" class="dfinput" > 元&nbsp;&nbsp;&nbsp;&nbsp;概率
      <input name="hgailv[]" type="text" value="<?php echo (intval($hbgailv[$i][hgailv])); ?>" style="width:80px;" class="dfinput" >&nbsp;&nbsp;&nbsp;&nbsp;第
      <input name="hcishu[]" type="text" value="<?php echo (intval($hbgailv[$i][hcishu])); ?>" style="width:80px;" class="dfinput" > 次中   
      <i></i></li><?php } ?>     
    <li>
      <label>&nbsp;</label>
      <input type="submit" name="button" class="btn" value="确认保存" />&nbsp;&nbsp;&nbsp;<input id="monisub" type="button" name="button" class="btn" value="模拟转盘" style="background-image:url(); background-color:#390; border-radius:5px;" />
    </li>
  </ul>
  </form>
</div>
<div class="install"></div>
<div class="zhuanimg"><img src="/Public/Wap/img/8.png"></div>
</body>
</html>