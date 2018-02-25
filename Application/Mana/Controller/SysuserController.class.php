<?php

namespace Mana\Controller;
use Think\Controller;
class SysuserController extends CommonController {
public function passsave(){
$data['upass'] = I('upass');
$data['id'] = session('adminid');
M('sys_user')->save($data);
}
public function userlist(){
if(I('uname') != ''){
$whe['uname'] = array('like','%'.I('uname').'%');
}
$whe['utype'] = array('eq',2);
$count = M('sys_user')->where($whe)->count();
$page = my_page($count,8);
$limit = $page->firstRow .','.$page->listRows;
$user =M('sys_user')->where($whe)->limit($limit)->select();
$this->page = $page->show();
$this->nowpage = I('p');
$this->user = $user;
$this->display();
}
public function useredit(){
$id = I('id',0,'intval');
$user = M('sys_user')->where("id=$id")->find();
$this->user = $user;
$this->display();
}
public function usersave(){
$id = I('id',0,'intval');
$data['uname'] = I('uname');
$data['utype'] = I('utype');
$data['upass'] = I('upass');
$user = M('sys_user')->where("id=$id")->find();
if($user){
$data['id'] = $id;
M('sys_user')->save($data);
unset($data);
}else {
$checkuser = M('sys_user')->where("uname='$data[uname]'")->find();
if($checkuser){
echo 1;
}else {
M('sys_user')->add($data);
}
}
}
public function userdel(){
$id = I('id',0);
M('sys_user')->where("id=$id")->delete();
$this->success('操作成功',U('userlist'),1);
}
}

?>