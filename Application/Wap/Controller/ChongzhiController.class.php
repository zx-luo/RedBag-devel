<?php

namespace Wap\Controller;
use Think\Controller;
class ChongzhiController extends CommonController {
public function chong(){
$ctype = I('ctype',1,'intval');
$hbid = I('hbid',0,'intval');
$djine = I('djine',0,'intval');
$userid= session('userid');
$user=M('user_list')->where("id=$userid")->find();
if($ctype == 1 ||$ctype == 2){
$hb = M('hb')->where("id=$hbid")->find();
$djine = intval($hb['hzhifue']);
}
$data['ddanhao'] = $danhao = date('YmdHis').rand(100,999);
$data['userid'] = $userid;
$data['djine'] = $djine;
$data['dtime'] = time();
M('user_chongzhi')->add($data);
unset($data);
$sysconfig = M('sys_config')->find();
define('WXCERTPATH',substr(THINK_PATH,0,-9));
define('WXAPPID',$sysconfig['cwxappid']);
define('WXMCHID',$sysconfig['cwxmchid']);
define('WXKEY',$sysconfig['cwxappkey']);
define('WXAPPSECRET',$sysconfig['cwxappsecret']);
vendor("wxjiaoyi.JsApiPay");
$input = new \WxPayUnifiedOrder();
$input->SetBody("ЁДж╣");
$input->SetOut_trade_no($danhao);
$input->SetTotal_fee($djine);
$input->SetNotify_url('http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/index.php/Wap/Paynotify/wxchongzhi.html');
$input->SetTrade_type("JSAPI");
$input->SetOpenid($user['uopenid']);
$order = \WxPayApi::unifiedOrder($input);
if($order[return_code] == 'FAIL'){
M('sys_log')->add(array('lbiaoshi'=>'н╒пеж╖╦╤','lcon'=>var_export($order,true),'ltime'=>time()));
}
$jsapipay = new \JsApiPay();
$jsApiParameters = $jsapipay->GetJsApiParameters($order);
$this->hb=$hb;
$this->hbid=$hb['id'];
$this->sysconfig=$sysconfig;
$this->jsApiParameters=$jsApiParameters;
if($ctype == 1){
$this->display('Index:pay');
}
if($ctype == 2){
$this->display('Zhuanpan:pay');
}
if($ctype == 3){
$this->display('Ucenter:chongzhi');
}
}
}
?>