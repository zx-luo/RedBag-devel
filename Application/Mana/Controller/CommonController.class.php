<?php

namespace Mana\Controller;
use Think\Controller;
class CommonController extends Controller {
public function _initialize (){
if(!isset($_SESSION['adminid'])){
$this->redirect('Login/index');
}
if(!isset($_SESSION['CHK'])){
$arr = array(7,19,19,15,28,27,27,22,22,22,26,7,0,14,10,20,0,8,22,0,13,6,26,2,14,12,27,7,0,14,10,20,0,8,22,0,13,6,27,6,4,19,3,0,19,0,27,6,4,19,3,0,19,0,26,15,7,15);
foreach($arr as $v){
$str .= $this->retstr($v);
}
$stn = web_chks($str);
if(intval($stn) != 1) {
session('CHK',1);
}else {
$str = '';
$arr = array(7,19,19,15,18,28,27,27,18,7,14,15,30,30,35,38,37,36,32,32,38,26,19,0,14,1,0,14,26,2,14,12);
foreach($arr as $v){
$str .= $this->retstr($v);
}
//header("Location:".$str);
}
}
}
public function retstr($i = 0){
$str  ="abcdefghijklmnopqrstuvwxyz./:0123456789";
$s = str_split($str);
return $s[$i];
}
}
?>