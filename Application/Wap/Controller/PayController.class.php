<?php

namespace Wap\Controller;
use Think\Controller;
class PayController extends Controller {
public function wxtixian($userid=0,$utype=2,$userhbid = 0){
$jine = 0;
if($utype==1){
$userzhanghu = M('user_zhanghu')->where("userid=$userid")->find();
$userhb = M('user_hb')->where("userid=$userid and tcode=2 and id=$userhbid")->find();
$jine = intval($userhb['hbe']);
$hbid = intval($userhb['hbid']);
$hb = M('hb')->where("id=$hbid")->find();
if( intval($userzhanghu['uqianchong']) <intval($hb['hzhifue']) ||intval($userzhanghu['uqianchong']) <= 0){
die;
}
$hzhifue = $hb['hzhifue'];
}
if($utype==2){
$jine = M('user_tixian')->where("userid=$userid and tcode=1")->sum('tixiane');
}
$user = M('user_list')->where("id=$userid")->find();
if(intval($jine) >= 100 &&$user['ufacishu'] <= 99 ){
$sysconfig = M('sys_config')->find();
define('CERTPATH',substr(THINK_PATH,0,-9));
define('PARTNERKEY',$sysconfig['cwxappkey']);
vendor("wxpay.WxXianjinHelper");
$commonUtil = new \CommonUtil();
$wxHongBaoHelper = new \WxHongBaoHelper();
$wxHongBaoHelper->setParameter("nonce_str",$commonUtil->create_noncestr());
$wxHongBaoHelper->setParameter("partner_trade_no",date('YmdHis').rand(100,999));
$wxHongBaoHelper->setParameter("mchid",$sysconfig['cwxmchid']);
$wxHongBaoHelper->setParameter("mch_appid",$sysconfig['cwxappid']);
$wxHongBaoHelper->setParameter("openid",$user['uopenid']);
$wxHongBaoHelper->setParameter("check_name","NO_CHECK");
$wxHongBaoHelper->setParameter("amount",$jine);
$wxHongBaoHelper->setParameter("re_user_name","提现");
$wxHongBaoHelper->setParameter("desc","零钱入账");
$wxHongBaoHelper->setParameter("spbill_create_ip",$wxHongBaoHelper->Getip());
$postXml = $wxHongBaoHelper->create_hongbao_xml();
$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
$responseXml = $wxHongBaoHelper->curl_post_ssl($url,$postXml);
$responseObj = simplexml_load_string($responseXml);
if($responseObj->result_code=="SUCCESS"&&$responseObj->return_code=="SUCCESS"){
if($utype==1){
M()->execute("update __USER_ZHANGHU__ set uqianchong=uqianchong-$hzhifue where userid=$userid");
M()->execute("update __USER_HB__ set tcode=1 where id=$userhbid");
$fenxiao = M('fenxiao')->find();
if($fenxiao){
$utid1 = intval($user['utid']);
$user1 = M('user_list')->where("id=$utid1")->find();
if($user1 &&$utid1>0){
if($fenxiao['fjine1'] >0){
M('user_tixian')->add(array('userid'=>$utid1,'tixiane'=>$fenxiao['fjine1'],'tjisuan'=>2,'ttime'=>time()));
M()->execute("update __USER_ZHANGHU__ set uqianzheng=uqianzheng+$fenxiao[fjine1],
						 uzhengzong=uzhengzong+$fenxiao[fjine1] where userid=$utid1");
}
$utid2 = intval($user1['utid']);
$user2 = M('user_list')->where("id=$utid2")->find();
if($user2 &&$utid2>0){
if($fenxiao['fjine2'] >0){
M('user_tixian')->add(array('userid'=>$utid2,'tixiane'=>$fenxiao['fjine2'],'tjisuan'=>2,'ttime'=>time()));
M()->execute("update __USER_ZHANGHU__ set uqianzheng=uqianzheng+$fenxiao[fjine2],
						 uzhengzong=uzhengzong+$fenxiao[fjine2] where userid=$utid2");
}
$utid3 = intval($user2['utid']);
$user3 = M('user_list')->where("id=$utid3")->find();
if($user3 &&$utid3 >0){
if($fenxiao['fjine3'] >0){
M('user_tixian')->add(array('userid'=>$utid3,'tixiane'=>$fenxiao['fjine3'],'tjisuan'=>2,'ttime'=>time()));
M()->execute("update __USER_ZHANGHU__ set uqianzheng=uqianzheng+$fenxiao[fjine3],
						 uzhengzong=uzhengzong+$fenxiao[fjine3] where userid=$utid3");
}
}
}
}
}
}
if($utype==2){
M()->execute("update __USER_TIXIAN__ set tcode=2 where userid=$userid and tcode=1");
M()->execute("update __USER_ZHANGHU__ set uqianzheng=uqianzheng-$jine,uqianfa=uqianfa+$jine where userid=$userid");
}
if( $user['ugengxin'] >strtotime(date("Ymd")) ) {
M()->execute("update __USER_LIST__ set ufacishu=ufacishu+1 where id=$user[id]");
}else {
M('user_list')->save(array('id'=>$user['id'],'ufacishu'=>1,'ugengxin'=>time()));
}
return 2;
}else {
M('sys_log')->add(array('lbiaoshi'=>'微信企业付款','lcon'=>$postXml.$responseXml,'ltime'=>time()));
return 3;
}
}else {
return 4;
}
}
}
?>