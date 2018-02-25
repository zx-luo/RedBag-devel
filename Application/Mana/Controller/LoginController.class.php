<?php

namespace Mana\Controller;
use Think\Controller;
class LoginController extends Controller {
public function ajaxlogin(){
if($_SESSION['cishu'] >3) {
$data['status'] = 2;
}else {
$uma = I('post.uma','');
$verify = new \Think\Verify();
if($verify->check($uma)){
$uname = I('post.uname','');
$upass = I('post.upass','');
$user = M('sys_user')->where("uname='$uname'")->find();
if($user &&$user['upass'] == $upass){
$data = array('id'=>$user['id'],'utime'=>time());
M('sys_user')->save($data);
session('adminid',$user['id']);
session('uname',$user['uname']);
session('utype',$user['utype']);
session('utime',$user['utime']);
$data['status']=1;
}else {
$data['status'] = 3;
$_SESSION['cishu'] = $_SESSION['cishu'] +1;
}
}else {
$data['status'] = 4;
}
}
$this->ajaxReturn($data,'json');
}
public function logout(){
session_destroy();
$this->redirect('Login/index');
}
public function ma(){
$Verify = new \Think\Verify();
$Verify->length   = 4;
$Verify->fontSize = 30;
$Verify->useNoise = true;
$Verify->entry();
}
}

?>