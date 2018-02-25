<?php

namespace Mana\Controller;
use Think\Controller;
class IndexController extends CommonController {
public function index(){
$this->display();
}
public function cleardata(){
dir_del('./Uploads/daili/');
dir_del('./Application/Runtime/');
M()->execute("TRUNCATE __SYS_LOG__");
$this->success('成功',U('center'),1);
}
}
?>