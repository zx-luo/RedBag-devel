<?php

namespace Wap\Controller;
use Think\Controller;
class AjaxController extends CommonController {
public function getfaqiancishu(){
$userid = session('userid');
$user = M('user_list')->where("id=$userid")->find();
if( $user['ugengxin'] >strtotime(date("Ymd")) ) {
$json['cishu'] =  $user['ufacishu'];
}else {
M('user_list')->save(array('id'=>$user['id'],'ufacishu'=>0,'ugengxin'=>time()));
$json['cishu'] = 0;
}
$this->ajaxReturn($json,'json');
}
public function checkuserhb(){
$userid = session('userid');
$sysconfig = M('sys_config')->find();
if($sysconfig['cpingbie']>0){
$totalhb = 	M('user_hb')->where("userid = $userid and tcode in(1)")->sum('hbe');
$userzhanghu = M('user_zhanghu')->where("userid=$userid")->find();
if( (intval($totalhb) -$userzhanghu['uchongzong']) >= $sysconfig['cpingbie']){
M('user_list')->save(array('id'=>$userid,'ustate'=>2));
}
}
}
public function gethbid(){
$hbid = I('hbid',0,'intval');
if($hbid == 0){
$hb = M('hb')->where("hcode=1 and htype=1")->order('hzhifue asc')->find();
$hbid = intval($hb['id']);
}
$json['hbid'] = $hbid;
$this->ajaxReturn($json,'json');
}
public function checkdaili(){
$userid = session('userid');
$user = M('user_list')->where("id=$userid")->find();
$json['code']    = $user['uvip'];
$this->ajaxReturn($json,'json');
}
public function fayongjin(){
$userid = session('userid');
$user = M('user_list')->where("id=$userid")->find();
$sysconfig = M('sys_config')->find();
if($sysconfig['cyongjinfa']==1){
$jine = M('user_tixian')->where("userid=$user[utid] and tcode=1")->sum('tixiane');
if( intval($jine) >= intval($sysconfig['cyongjine']) ){
$pay = A('Pay');
$pay->wxtixian($user['utid']);
}
}
}
public function checkzhanghu(){
$userid = session('userid');
$hbid = I('hbid',0,'intval');
$user = M('user_list')->where("id=$userid")->find();
$userzhanghu = M('user_zhanghu')->where("userid=$userid")->find();
$json['code'] = 0;
if($user['ufacishu'] <99){
if($hbid == 0 ){
$hb = M('hb')->where('hcode=1 and htype=1')->order('hzhifue asc')->find();
}else {
$hb = M('hb')->where("id=$hbid")->find();
}
if($userzhanghu['uqianchong'] >= $hb['hzhifue']){
$json['code'] = 1;
}
}
$this->ajaxReturn($json,'json');
}
public function chongzhi(){
$page = I('page',0);
$pagesize = 10;
$limit = $page * $pagesize .','.$pagesize;
$userid = session('userid');
$chongzhi = M('user_chongzhi')->where("userid = $userid and dcode in(2)")->limit($limit)->order("id desc")->select();
foreach($chongzhi as $v){
$json['html'] .= '<li>'.($v['djine']*0.01).'元<span><font class="font12">充值成功</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date("Y-m-d H:i",$v['dtime']).'</span></li>';
}
$this->ajaxReturn($json,'json');
}
public function hblist(){
$page = I('page',0);
$pagesize = 10;
$limit = $page * $pagesize .','.$pagesize;
$userid = session('userid');
$hblist = M('user_hb')->where("userid = $userid and tcode in(1)")->limit($limit)->order("id desc")->select();
foreach($hblist as $v){
$json['html'] .= '<li>'.($v['hbe']*0.01).'元<span><font class="font12">已领取</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date("Y-m-d H:i",$v['ttime']).'</span></li>';
}
$this->ajaxReturn($json,'json');
}
public function zhanshibox(){
$sysconfig = M('sys_config')->find();
$json['code'] = $sysconfig['cgundong'];
$cwxchoutxt = explode(',',$sysconfig['cwxchoutxt']);
array_filter($cwxchoutxt);
$arr = array('好运','爆发','走大运','鸿运当头','天降洪福','时来运转','财运亨通','洪福齐天','天赐良机');
if(count($cwxchoutxt) >0){
$arrnum = rand(0,count($arr)-1);
$cwxchoutxtnum = rand(0,count($cwxchoutxt)-1);
$json['html'] ='<span>'.$arr[$arrnum].'</span>&nbsp;&nbsp;&nbsp;'.$cwxchoutxt[$cwxchoutxtnum];
}else {
$json['code'] = 1;
}
$this->ajaxReturn($json,'json');
}
}
?>