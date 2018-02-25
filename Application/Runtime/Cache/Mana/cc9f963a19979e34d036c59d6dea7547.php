<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
<link href="/Public/Admin/css/base.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/right.css" rel="stylesheet" type="text/css">
<link href="/Public/css/page.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/Public/js/jquery-2.1.1.min.js"></script>
<script>
$(document).ready(function(){
   $(function(){
      $('.rightinfo tbody tr:odd').addClass('odd')
   });
});
function del(){ if(confirm("确定要删除吗？")) {   return true;  }  else  {  return false;  } }
</script>
</head>

<body>
<div class="place"> <span>位置：</span>
  <ul class="placeul">
    <li><a href="<?php echo U('Index/center');?>">首页</a></li>
    <li>系统用户</li>
  </ul>
</div>
<div class="rightinfo">
  <div class="tools">
    <ul class="toolbar">
      <li><a href="<?php echo U('useredit');?>"><span><img src="/Public/Admin/image/t01.png" /></span>添加</a></li>
      <li style="background:#FFF; text-indent:1em; border:0">
        <form name="fsoso1" method="post" action="<?php echo U('userlist');?>">
          账号：<input name="uname" type="text" class="dfinput" style="width:200px">
          <input name="submit" class="btn" value="查询" type="submit">
        </form>
      </li>
    </ul>
  </div>
  <table class="tablelist">
    <thead>
      <tr>
        <th>账号</th>
        <th>分组</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
    <?php if(is_array($user)): foreach($user as $key=>$v): ?><tr align="center">
        <td><?php echo ($v[uname]); ?></td>
        <td><?php if(($v[utype]) == "1"): ?><font color="#FF0000">管理员</font><?php else: ?>用户<?php endif; ?></td>
        <td>
           <img src="/Public/Admin/image/leftico03.png" width="14">
           <a href="<?php echo U('useredit?id='.$v[id]);?>" class="tablelink">编辑</a> &nbsp;
           <?php if(($v[id]) != $_SESSION['adminid']): ?><img src="/Public/Admin/image/t03.png" width="14">           
           <a onClick="return del()" href="<?php echo U('userdel?id='.$v[id].'&nowpage='.$nowpage);?>" class="tablelink"> 删除</a><?php endif; ?>
        </td>
      </tr><?php endforeach; endif; ?>
    </tbody>
  </table>
</div>
<div class="pages">
   <?php echo ($page); if(empty($user)): ?><font color='#ff0000'>暂无数据</font><?php endif; ?>
</div>
</body>
</html>