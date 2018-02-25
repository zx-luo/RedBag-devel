<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>程序安装向导</title>
<link rel="stylesheet" href="/Public/Install/css/index.css?v=<?php echo rand(0,20);?>" />
</head>

<body>
<div class="wrap">
  <div class="header">
    <h1 class="logo">程序安装向导</h1>
  </div>
  <div class="step">
    <ul class="unstyled">
      <li class="current"><em>1</em>检测环境</li>
      <li><em>2</em>创建数据</li>
      <li><em>3</em>完成安装</li>
    </ul>
  </div>
  <div class="server">
    <table width="100%">
      <tr>
        <td class="td1">环境检测</td>
        <td class="td1" width="25%">推荐配置</td>
        <td class="td1" width="25%">当前状态</td>
        <td class="td1" width="25%">最低要求</td>
      </tr>
      <tr>
        <td>操作系统</td>
        <td>类UNIX</td>
        <td><i class="fa-rig"><?php echo ($os); ?></i></td>
        <td>不限制</td>
      </tr>
      <tr>
        <td>PHP版本</td>
        <td>>5.3.x</td>
        <td><i class="fa-rig"><?php echo ($phpversion); ?></i></td>
        <td>5.3.0</td>
      </tr>
      <tr>
        <td> PDO</td>
        <td>开启</td>
        <td> <?php echo ($pdo); ?> </td>
        <td>开启</td>
      </tr>
      <tr>
        <td> PDO_MySQL</td>
        <td>开启</td>
        <td> <?php echo ($pdo_mysql); ?> </td>
        <td>开启</td>
      </tr>
      <tr>
        <td>附件上传</td>
        <td>>2M</td>
        <td> <?php echo ($upload_size); ?> </td>
        <td>不限制</td>
      </tr>
      <tr>
        <td>SESSION</td>
        <td>开启</td>
        <td> <?php echo ($session); ?> </td>
        <td>开启</td>
      </tr>
    </table>
    <table width="100%">
      <tr>
        <td class="td1">目录、文件权限检查</td>
        <td class="td1" width="25%">写入</td>
        <td class="td1" width="25%">读取</td>
      </tr>
      <?php if(is_array($folders)): foreach($folders as $dir=>$vo): ?><tr>
          <td> ./<?php echo ($dir); ?> </td>
          <td><?php if($vo['w']): ?><i class="fa-rig">可写</i>
              <?php else: ?>
              <i class="fa-err">不可写</i><?php endif; ?></td>
          <td><?php if($vo['r']): ?><i class="fa-rig">可读</i>
              <?php else: ?>
              <i class="fa-err">不可读</i><?php endif; ?></td>
        </tr><?php endforeach; endif; ?>
    </table>
  </div>
  <div class="bottom text-center"> <a href="<?php echo U('Index/step1');?>" class="btn-primary">重新检测</a> <a href="<?php echo U('Index/step2');?>" class="btn-primary">下一步</a> </div>
</div>
<div class="footer"> &copy; 77768688-<?php echo date('Y');?> </div>
</body>
</html>