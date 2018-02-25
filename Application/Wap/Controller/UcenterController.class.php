<?php

namespace Wap\Controller;
use Think\Controller;
class UcenterController extends CommonController {
public function index(){
$userid = session('userid');
$userzhanghu = M('user_zhanghu')->where("userid=$userid")->find();
$jiazhunum = M('user_list')->where("utid=$userid")->count();
$this->jiazhunum = $jiazhunum;
$this->userzhanghu = $userzhanghu;
$this->display();
}
}
?>