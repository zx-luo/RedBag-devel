<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>欢迎登录后台管理系统</title>
<link href="/Public/Admin/css/base.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/right.css" rel="stylesheet" type="text/css">
<script src="/Public/js/jquery-2.1.1.min.js" language="JavaScript" ></script>
<script>
$(document).ready(function(){
   $(function(){
      $('.rightinfo tbody tr:odd').css("backgroundColor","#f5f8fa");
   });
   $(".btn").click(function(){
	   $.get("<?php echo U('create');?>",{},function(data){
		   if(data=='ok'){
			   alert('创建成功');
			   return false; 
		   } else {
			   alert('创建失败:'+data);   
			   return false;
		   }
	   });
   });
});
function del(){ if(confirm("确定要删除吗？")) {   return true;  }  else  {  return false;  } }
</script>
</head>

<body>
<div class="place"> <span>位置：</span>
  <ul class="placeul">
    <li><a href="<?php echo U('Index/center');?>">首页</a></li>
    <li><a href="<?php echo U('show');?>">微信一级菜单</a></li>
    
    <?php if(($cid) > "0"): ?><li>微信二级菜单</li><?php endif; ?>
    
  </ul>
</div>
<div class="rightinfo">
  <div class="tools"> 
    <ul class="toolbar">
      <li><a href="<?php echo U('edit?cid='.$cid);?>"><span><img src="/Public/Admin/image/t01.png" /></span>添加菜单</a></li>       
    </ul>
    <div style="line-height:40px;"><font color="#FF0000">说明：一级菜单不能超过3个，二级菜单不能超过5个。</font></div>
  </div>
    <table class="tablelist">
    <thead>
      <tr>
        <th width="33%" height="37">菜单名字</th>
        <th width="20%">菜单类型</th>
        <th width="24%">菜单动作</th>
        <th width="23%">操作</th>
      </tr>
    </thead>
    <tbody>
      <?php if(is_array($seldata)): $i = 0; $__LIST__ = $seldata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr height="45" align="center">
        <td><?php echo ($vo['cname']); ?></td>
        <td><?php echo ($vo['cid'] > 0 ? '二级菜单':'一级菜单'); ?></td>
        <td><?php switch($vo['ctype']): case "0": ?>网址<?php break;?>
            <?php case "1": ?>关键词<?php break;?>
            <?php case "2": ?>扫一扫<?php break;?>
            <?php case "3": ?>拍图<?php break; endswitch;?></td>
        <td>
        
        <?php if(($vo['cid']) == "0"): ?><img src="/Public/Admin/image/leftico01.png" width="14"> 
          <a href="<?php echo U('show?cid='.$vo['id']);?>">二级菜单</a>&nbsp;<?php endif; ?>
        
        <img src="/Public/Admin/image/leftico03.png" width="14">
        <a href="<?php echo U('edit?cid='.$vo['cid'].'&nid='.$vo['id']);?>">编辑</a>&nbsp;
        <img src="/Public/Admin/image/t03.png" width="14"> 
        <a href="<?php echo U('del?act=del&cid='.$vo[cid].'&nid='.$vo[id]);?>" onclick='return del()' class="tablelink">删除</a>
        
        </td>
      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
  </table>
</div>
<div style=" width:90%; padding:10px 0 10px 0; text-align:center">
  <?php if(empty($seldata)): ?><font color='#ff0000'>暂无数据</font>
  <?php else: ?>
     <input name='button' type='button' class='btn' value='生成菜单'/><?php endif; ?>
</div>
</body>
</html>