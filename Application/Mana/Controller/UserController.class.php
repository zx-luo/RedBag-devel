<?php

namespace Mana\Controller;
use Think\Controller;
class UserController extends CommonController {
public function index(){
$sci = I('sci','');
$ord = I('ord','');
if($sci != ''){
$whe['a.uickname'] = array('like',"%$sci%");
$whe['a.id'] = array('eq',intval($sci));
$whe['a.uopenid'] = array('like',"%$sci%");
}
if(I('ustate')==2){
$whe['a.ustate'] = 2;
}
if(!empty($whe)){
$whe['_logic'] = 'or';
$map['_complex'] = $whe;
}
if($ord != ''){
$order = 'b.'.$ord.' desc';
}else {
$order = 'a.id desc';
}
$count = M()->table('__USER_LIST__ a')->where($whe)->count();
$page = my_page($count,7);
$limit = $page->firstRow .','.$page->listRows;
$user = M()->table('__USER_LIST__ as a')->join('left join __USER_ZHANGHU__ as b on a.id=b.userid')
->field('a.*,b.uqianchong,b.uqianzheng,b.uzhengzong,b.uqianfa')->where($whe)->order($order)->limit($limit)->select();
foreach($user as $k =>$v){
$c = M('user_chongzhi')->where("userid=$v[id] and dcode=2")->sum('djine');
$user[$k][chongzhi]=intval($c);
$c = M('user_hb')->where("userid=$v[id] and tcode=1")->sum('hbe');
$user[$k][hb]=intval($c);
}
$page->parameter['sci']   =   urlencode(I('sci'));
$this->sci = I('sci');
$this->page = $page->show();
$this->nowpage = I('p');
$this->user = $user;
$this->display();
}
public function tixian(){
$sysconfig = M('sys_config')->find();
$whe['a.tcode'] = array('eq',1);
$userid = I('sci',0,'intval');
if($userid >0){
$whe['a.userid'] = array('eq',$userid);
}
$count = M()->table('__USER_TIXIAN__ as a')->where($whe)->count("distinct(userid)");
$page = my_page($count,8);
$limit = $page->firstRow .','.$page->listRows;
$tixian = M()->table('__USER_TIXIAN__ as a')->join('left join __USER_LIST__ as b on a.userid=b.id')
->field('sum(a.tixiane) tixiane,a.ttime,a.userid,b.uopenid,b.uickname,b.uheadimgurl')->where($whe)
->group('a.userid')->order('a.id desc')->limit($limit)->select();
$this->sysconfig = $sysconfig;
$this->tixian = $tixian;
$this->page = $page->show();
$this->display();
}
public function hb(){
$whe['a.tcode'] = array('eq',1);
$userid = I('sci',0,'intval');
if($userid >0){
$whe['a.userid'] = array('eq',$userid);
}
$count = M()->table('__USER_HB__ a')->where($whe)->count();
$page = my_page($count,10);
$limit = $page->firstRow .','.$page->listRows;
$hb = M()->table('__USER_HB__ as a')->join('left join __USER_LIST__ as b on a.userid=b.id')
->join('left join __HB__ c on a.hbid=c.id')->where($whe)
->field('a.*,b.uickname,b.uheadimgurl,b.ustate,c.hzhifue')->order('a.id desc')->limit($limit)->select();
$page->parameter['sci']   =   urlencode(I('sci'));
$this->hb = $hb;
$this->page = $page->show();
$this->display();
}
public function chongzhi(){
if(I('sktime') != ''){
$sktime = strtotime(I('sktime'));
$whe['a.dtime'][] =  array('gt',$sktime);
}
if(I('sjtime') != ''){
$sjtime = strtotime(I('sjtime'));
$whe['a.dtime'][] =  array('lt',$sjtime);
}
$whe['a.dcode'] = array('eq',2);
$userid = I('sci',0,'intval');
if($userid >0){
$whe['a.userid'] = array('eq',$userid);
}
$count = M()->table('__USER_CHONGZHI__ a')->where($whe)->count();
$page  = my_page($count,8);
$limit = $page->firstRow .','.$page->listRows;
$hb = M()->table('__USER_CHONGZHI__ a')->join('left join __USER_LIST__ b on a.userid=b.id')
->field('a.*,b.uickname,b.uheadimgurl')->where($whe)->order('a.id desc')->limit($limit)->select();
$zongkuan = M()->table('__USER_CHONGZHI__ a')->where($whe)->sum('djine');
$page->parameter['sktime']   =   I('sktime');
$page->parameter['sjtime']   =   I('sjtime');
$page->parameter['sci']   =   urlencode(I('sci'));
$this->zongkuan = $zongkuan * 0.01;
$this->sktime = I('sktime');
$this->sjtime = I('sjtime');
$this->hb = $hb;
$this->page = $page->show();
$this->display();
}
public function ajaxjiesuan(){
$userid=I('userid',0);
$pay = A('Wap/Pay');
$json['code'] = $pay->wxtixian($userid);
$this->ajaxReturn($json,'json');
}
public function ajaxuservip(){
$id = I('id');
$user = M('user_list')->where("id=$id")->find();
$uvip = $user['uvip'] >0 ?0:1;
M('user_list')->save(array('id'=>$id,'uvip'=>$uvip));
}
public function ajaxvip(){
$id = I('id');
$uvip = I('uvip',0,'intval');
M('user_list')->save(array('id'=>$id,'uvip'=>$uvip));
}
public function ajaxuserstate(){
$id = I('id');
$user = M('user_list')->where("id=$id")->find();
$ustate = $user['ustate'] == 1 ?2:1;
M('user_list')->save(array('id'=>$id,'ustate'=>$ustate));
}
public function gengxinyongjin(){
$tixian = M('user_tixian')->where("tjisuan=1")->select();
foreach($tixian as $k =>$v){
M()->execute("update __USER_TIXIAN__ set tjisuan=2 where id=$v[id]");
if($v['tcode'] == 1){
$e = $v['tixiane'];
}else {
$e = 0;
}
M()->execute("update __USER_ZHANGHU__ set uzhengzong=uzhengzong+$v[tixiane],uqianzheng=uqianzheng+$e where userid=$v[userid]");
}
$chongzhi = M('user_chongzhi')->where("djisuan=1 and dcode=2")->select();
foreach($chongzhi as $k =>$v){
M()->execute("update __USER_ZHANGHU__ set uchongzong=uchongzong+$v[djine] where userid=$v[userid]");
M()->execute("update __USER_CHONGZHI__ set djisuan=2 where id=$v[id]");
}
}
public function yongjin(){
if(I('sktime') != ''){
$sktime = strtotime(I('sktime'));
$whe['a.ttime'][] =  array('gt',$sktime);
}
if(I('sjtime') != ''){
$sjtime = strtotime(I('sjtime'));
$whe['a.ttime'][] =  array('lt',$sjtime);
}
$userid = I('sci',0,'intval');
if($userid >0){
$whe['a.userid'] = array('eq',$userid);
}
$count = M()->table('__USER_TIXIAN__ a')->where($whe)->count();
$page  = my_page($count,8);
$limit = $page->firstRow .','.$page->listRows;
$yongjin = M()->table('__USER_TIXIAN__ a')->join('left join __USER_LIST__ b on a.userid=b.id')
->field('a.*,b.uickname,b.uheadimgurl')->where($whe)->order('a.id desc')->limit($limit)->select();
$page->parameter['sktime']   =   I('sktime');
$page->parameter['sjtime']   =   I('sjtime');
$page->parameter['sci']   =   urlencode(I('sci'));
$this->sktime = I('sktime');
$this->sjtime = I('sjtime');
$this->yongjin = $yongjin;
$this->page = $page->show();
$this->display();
}
public function jiesuanall(){
@set_time_limit(0);
$this->display();
$count = M('user_zhanghu')->where('uqianzheng>=100')->count();
sp_show_msg('共'.$count.'个代理需要结算');
$userzhanghu = M('user_zhanghu')->where('uqianzheng>=100')->select();
foreach($userzhanghu as $v){
$userid = intval($userzhanghu['userid']);
$pay = A('Wap/Pay');
$code = $pay->wxtixian($userid);
if($code == 2){
$txt = 'ID：'.$userid.' 佣金结算成功！';
}else {
$txt = 'ID：'.$userid.' 佣金结算<font color="#FF0000">失败！</font>';
}
sp_show_msg($txt);
}
sp_show_msg('完成');
}
}

?>