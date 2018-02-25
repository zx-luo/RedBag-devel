<?php

namespace Wap\Controller;
use Think\Controller;
class CommonController extends Controller {
public function _initialize (){
parse_str($_SERVER['QUERY_STRING'],$canshu);
$urlstr[] = 'm-'.$canshu['m'];
$urlstr[] = 'c-'.$canshu['c'];
$urlstr[] = 'a-'.$canshu['a'];
$urlstr[] = 'utid-'.$canshu['utid'];
$urlstr[] = 'ubeiopenid-'.$canshu['ubeiopenid'];
$urls = implode('|',$urlstr);
$utid = $canshu['utid'];
if($utid >0){
session('utid',intval($utid));
}
if(session('userid') == ''){
$this->redirect('Wxlogin/index?urls='.$urls);
}else {
$userid = session('userid');
$user = M('user_list')->where("id=$userid")->find();
if(!$user){
$this->redirect('Wxlogin/index?urls='.$urls);
}
}
}
}
?>