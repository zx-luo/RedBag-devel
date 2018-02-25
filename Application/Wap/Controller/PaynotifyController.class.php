<?php

namespace Wap\Controller;
use Think\Controller;
class PaynotifyController extends Controller {
public function wxchongzhi(){
$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
$postObj = simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);
if($postObj->result_code=='SUCCESS'&&$postObj->return_code=='SUCCESS'){
vendor("wxjiaoyi.JsApiPay");
$sysconfig = M('sys_config')->find();
define('WXCERTPATH',substr(THINK_PATH,0,-9));
define('WXAPPID',$sysconfig['cwxappid']);
define('WXMCHID',$sysconfig['cwxmchid']);
define('WXKEY',$sysconfig['cwxappkey']);
define('WXAPPSECRET',$sysconfig['cwxappsecret']);
$input = new \WxPayOrderQuery();
$input->SetTransaction_id($postObj->transaction_id);
$result = \WxPayApi::orderQuery($input);
if(array_key_exists("return_code",$result) &&array_key_exists("result_code",$result)
&&$result["return_code"] == "SUCCESS"&&$result["result_code"] == "SUCCESS")		{
$danhao = $postObj->out_trade_no;
$danrow = M('user_chongzhi')->where("ddanhao='$danhao' and dcode=1")->find();
if($danrow) {
$userid = $danrow['userid'];
$djine = $danrow['djine'];
$user = M('user_list')->where("id=$userid")->find();
if($user['ustate']==1){
M()->execute("update __USER_ZHANGHU__ set uqianchong=uqianchong+$djine,
				                   uchongzong=uchongzong+$djine where userid=$userid");
}
M()->execute("update __USER_CHONGZHI__ set dcode=2 where ddanhao='$danhao'");
if($user['utid'] >0){
$this->chongyongjin($user['utid'],$danrow['id']);
}
echo "success";
}
}
}
}
public function chongyongjin($utid=0,$danid=0){
if(intval($utid) == 0) die;
$danrow = M('user_chongzhi')->where("id=$danid and djisuan=1 and dcode=2")->find();
if($danrow){
M()->execute("update __USER_CHONGZHI__ set djisuan=2 where id=$danid");
$djine = $danrow['djine'];
$sysconfig = M('sys_config')->find();
if($sysconfig['ckouliang'] >0 ){
$tixiannum = M('user_tixian')->where("userid=$utid")->count();
if( ($tixiannum %10) >= (10-$sysconfig['ckouliang']) ){
$data['tcode'] = $tcode = 4;
}
}
$utuser = M('user_list')->where("id=$utid")->find();
$yongjindengji = intval($utuser['uvip']);
$yongjinset = M('yongjin_set')->where("ydengji=$yongjindengji")->find();
if($yongjinset){
$tixiane = $djine * 0.01 * intval($yongjinset['ybaifenbi']);
$data['userid'] = $utid;
$data['uchong'] = $djine;
$data['tixiane'] = $tixiane;
$data['tjisuan'] = 2;
$data['ttime'] = time();
M('user_tixian')->add($data);
unset($data);
if(intval($tcode) != 4 ) {
M()->execute("update __USER_ZHANGHU__ set uqianzheng=uqianzheng+$tixiane,
						 uzhengzong=uzhengzong+$tixiane where userid=$utid");
}
}
$yongjinset = M('yongjin_set')->where("ydengji=($yongjindengji+1)")->find();
if($yongjinset){
$tixiane = M('user_tixian')->where("userid=$utid and tcode in(1,2)")->sum('uchong');
if($tixiane >= $yongjinset['yjine']) {
M()->execute("update __USER_LIST__ set uvip=uvip+1 where id=$utid");
}
}
}
}
}
?>