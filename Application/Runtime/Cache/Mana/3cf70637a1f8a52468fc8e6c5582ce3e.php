<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>欢迎登录后台管理系统</title>
<link href="/Public/Admin/css/base.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/right.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/Public/js/jquery-2.1.1.min.js"></script>
<script>
$(document).ready(function(){	
   $(function(){
      $('.rightinfo tbody tr:odd').css("backgroundColor","#f5f8fa");	
   })
   $("#picadd").click(function(){
	   $("#picgen").after("<li><label>&nbsp;</label><input name='file[]' type='file' class='dfinput'><i><img src='/Public/Admin/image/t03.png' style='vertical-align:middle; cursor:pointer' onclick='removeFile(this);' /></i></li>");
   });
   $("input[name='cbeicode']").click(function(){
	   if($(this).prop("checked")){
		   $('.beifen').show();
	   } else {
	      $('.beifen').hide();  
	   }
   });
});
function removeFile(e){
	$(e).parent().parent().remove();
}
</script>
<style>
<?php if(($sysconfig[cbeicode] == 2) OR ($sysconfig[cbeicode] == '') ): ?>.beifen{ display:none;}<?php endif; ?>
</style>
</head>
<body>
<div class="place"> <span>位置：</span>
  <ul class="placeul">
    <li><a href="<?php echo U('Index/center');?>">首页</a></li>
    <li>系统配置</li>
  </ul>
</div>
<div class="formbody">
  <form name="fadd" method="post" action="<?php echo U('save');?>" enctype="multipart/form-data">
    <ul class="forminfo">
      <li>
        <label>获取头像</label>
        <cite> <input name="cdenglucode" type="checkbox" value="2" <?php if(($sysconfig['cdenglucode']) == "2"): ?>checked<?php endif; ?> > 
        <i>勾选，带登陆框,可以获取用户信息</i></cite></li>
      <li>
        <label>自动结算佣金</label>
        <cite> <input name="cyongjinfa" type="checkbox" value="1" <?php if(($sysconfig['cyongjinfa']) == "1"): ?>checked<?php endif; ?> > 
        <i>勾选，自动发放代理佣金  <a href="<?php echo U('Yongjin/index');?>"><font color="#FF0000"><strong>点击设置佣金</strong></font></a> </i></cite></li>
      <li>
        <label>自动成为代理</label>
        <cite> <input name="cdailicode" type="checkbox" value="2" <?php if(($sysconfig['cdailicode']) == "2"): ?>checked<?php endif; ?> > 
        <i>勾选，用户自动会成为代理</i></cite></li>
      <li>
        <label>代理自动升级</label>
        <cite> <input name="cdailishengji" type="checkbox" value="1" <?php if(($sysconfig['cdailishengji']) == "1"): ?>checked<?php endif; ?> > 
        <i>勾选，代理自动升级</i></cite></li>
      <li>
        <label>抽中红包展示</label>
        <cite> <input name="cgundong" type="checkbox" value="2" <?php if(($sysconfig['cgundong']) == "2"): ?>checked<?php endif; ?> > 
        <i>勾选，用户抽中红包信息会滚动显示</i></cite></li>
      <li>
        <label>黑名单</label>
        <input name="cpingbie" type="text" value="<?php echo ($sysconfig['cpingbie']/100); ?>" class="dfinput" />
        <i>元，用户赚到多少元加入黑名单（黑名单用户充值不会到帐）</i></cite></li>
      <li>
        <label>推广域名</label>
        <input name="cmaurl" type="text" value="<?php if(empty($sysconfig[cmaurl])): ?>http://<?php echo ($_SERVER[HTTP_HOST]); else: echo ($sysconfig['cmaurl']); endif; ?>" class="dfinput" />
        <i>推广使用，绑定在推广二维码上，末尾不要带’/‘</i></li>
      <li>
        <label>微信域名</label>
        <input name="cfaurl" type="text" value="<?php if(empty($sysconfig[cfaurl])): ?>http://<?php echo ($_SERVER[HTTP_HOST]); else: echo ($sysconfig['cfaurl']); endif; ?>" class="dfinput" />
        <i>需要绑定在公众号上，授权登录和支付路径处，末尾不要带’/‘</i></li>
      <li>
        <label>最低结算佣金</label>
        <input name="cyongjine" type="text" value="<?php echo ($sysconfig['cyongjine']/100); ?>" class="dfinput" />
        <i>元，佣金够多少元才结算发放，自动发佣金有效</i></li>
      <li>
        <label>代理扣量</label>
        <input name="ckouliang" type="text" value="<?php echo (intval($sysconfig['ckouliang'])); ?>" class="dfinput" />
        <i>单位：十分之，比如，这里输入4，就是10个充值会扣掉4个</i></li>
      <li>
        <label>公众号Appid</label>
        <input name="cwxappid" type="text" value="<?php echo ($sysconfig['cwxappid']); ?>" class="dfinput" />
        <i>从公众号处获得</i></li>
      <li>
        <label>公众号secret</label>
        <input name="cwxappsecret" type="text" value="<?php echo ($sysconfig['cwxappsecret']); ?>" class="dfinput" />
        <i>从公众号处获得</i></li>
      <li>
        <label>微信商户号</label>
        <input name="cwxmchid" type="password" value="<?php echo ($sysconfig['cwxmchid']); ?>" class="dfinput" />
        <i></i></li>
      <li>
        <label>微信商户密钥</label>
        <input name="cwxappkey" type="password" value="<?php echo ($sysconfig['cwxappkey']); ?>" class="dfinput" />
        <i>商户后台获得</i></li>
      <li id="picgen">
        <label>微信商户证书</label>
        <input name="file[]" type="file" class="dfinput"><i><img src="/Public/Admin/image/t01.png" style="vertical-align:middle; cursor:pointer"  id="picadd" /> pem格式三个文件全部上传，商户后台下载的证书压缩包解压后获得</i> </li>
      <li>
        <label>站内通知</label>
        <textarea name="ctongzhi" class="textinput" style="width:325px; height:60px;"><?php echo ($sysconfig['ctongzhi']); ?></textarea>
        <i></i></li>
      <li>
        <label>开启数据备份</label>
        <cite> <input name="cbeicode" type="checkbox" value="1" <?php if(($sysconfig['cbeicode']) == "1"): ?>checked<?php endif; ?> > 
        <i>勾选，配置后，更换公众号用户数据不会丢失</i></cite></li>
      <li class="beifen">
        <label>备份域名</label>
        <input name="cbeiurl" type="text" value="<?php if(empty($sysconfig[cbeiurl])): ?>http://<?php echo ($_SERVER[HTTP_HOST]); else: echo ($sysconfig['cbeiurl']); endif; ?>" class="dfinput" />
        <i>绑定在备份公众号的授权登录地方，末尾不要带’/‘</i></li>
      <li class="beifen">
        <label>Appid</label>
        <input name="cbeiappid" type="text" value="<?php echo ($sysconfig['cbeiappid']); ?>" class="dfinput" />
        <i>备份公众号的Appid</i></li>
      <li class="beifen">
        <label>AppSecret</label>
        <input name="cbeiappsecret" type="text" value="<?php echo ($sysconfig['cbeiappsecret']); ?>" class="dfinput" />
        <i>备份公众号的AppSecret</i></li>
      <li>
        <label>&nbsp;</label>
        <input name="button" type="submit" class="btn" value="确认保存"/>
      </li>
    </ul>
  </form>
</div>
</body>
</html>