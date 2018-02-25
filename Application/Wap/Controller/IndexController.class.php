<?php

namespace Wap\Controller;
use Think\Controller;
class IndexController extends CommonController {
public function index(){
$hbnum = M('hb')->where('hcode=1 and htype=1')->count();
if($hbnum >1) {
$hb = M('hb')->where('hcode=1 and htype=1')->select();
}else {
$hb = M('hb')->where('hcode=1 and htype=1')->find();
$this->redirect('Chongzhi/chong?ctype=1&hbid='.$hb['id']);
die;
}
$this->hb = $hb;
$this->display();
}
public function hb(){
$userid = session('userid');
$hbid = I('hbid',0,'intval');
$hb = M('hb')->where("id=$hbid")->find();
$hbdata = $hb['hb'];
$hbcon = explode(',',$hb['hb']);
if( (time()-$hb['hlastbian']) >$hb['hbianhua'] * 60 ){
$hbgailv = M("hb_gailv")->where("hbid=$hbid")->select();
$hbarr = array();
for($i=0 ;$i <$hb['hgeshu'] -count($hbgailv) ;$i++){
$hbarr[] = $this->checkhbjine($hb['hminmoney'],$hb['hmaxmoney'],$hbarr);
}
foreach($hbgailv as $v){
$hbarr[] = $this->checkhbjine($v['hmin'],$v['hmax'],$hbarr);
}
shuffle($hbarr);
$hbcon = $hbarr;
$hbdata = implode(',',$hbarr);
M('hb')->save(array('hb'=>$hbdata,'id'=>$hbid,'hlastbian'=>time()));
}
M('user_list')->save(array('uhbcon'=>$hbdata,'id'=>$userid));
$chaihbcon = $hbcon;
shuffle($chaihbcon);
$this->html = $html;
$this->sysconfig = $sysconfig;
$this->hbid = $hbid;
$this->hbcon = $hbcon;
$this->chaihbcon = $chaihbcon;
$this->display();
}
public function yongjin(){
$userid=session("userid");
$user = M('user_list')->where("id=$userid")->find();
$this->cishu = 100 -$user['ufacishu'];
$this->display();
}
public function ajaxchai(){
if(IS_AJAX){
$hbid = I('hbid',0,'intval');
$userid = session('userid');
$user = M('user_list')->where("id=$userid")->find();
$userzhanghu = M('user_zhanghu')->where("userid=$userid")->find();
$hb = M('hb')->where("id=$hbid")->find();
if(!$hb){die;}
if( intval($userzhanghu['uqianchong']) <intval($hb['hzhifue']) ||intval($userzhanghu['uqianchong']) <= 0){
$json['code'] = 1;
}else {
$chounum = M('user_hb')->where("hbid=$hbid and userid=$userid and tcode=1")->count();
$chounum = $chounum +1;
$hbgailv = M('hb_gailv')->where("hbid=$hbid and hcishu=$chounum")->select();
if(!$hbgailv){
$hbgailv = M('hb_gailv')->where("hbid=$hbid")->select();
}
foreach($hbgailv as $k =>$v){
$gailvarr[$k] = $v['hgailv'];
}
$gailvarrkey = get_arr_rand($gailvarr);
$hbcon = explode(',',$user['uhbcon']);
$arr = array();
foreach($hbcon as $v){
if($v >= $hbgailv[$gailvarrkey]['hmin'] &&$v <= $hbgailv[$gailvarrkey]['hmax']){
$arr[] = $v;
}
}
$chounum = rand(0,count($arr)-1);
$hbe = $arr[$chounum];
$userhb = M('user_hb')->where("userid=$userid")->order('id desc')->find();
if( (time()-intval($userhb['ttime'])) >15){
$data=array('userid'=>$userid,'hbid'=>$hbid,'hbe'=>$hbe,'ttime'=>time(),'tcode'=>2);
$userhbid = M('user_hb')->add($data);
$pay = A('Pay');
$json['code'] = $pay->wxtixian($userid,1,$userhbid);
$json['hbe'] = $hbe * 0.01;
}else {
$json['code'] = 5;
}
}
$this->ajaxReturn($json,'json');
}
}
public function ajaxyongjin(){
$page = I('page',0);
$pagesize = 8;
$limit = $page * $pagesize .','.$pagesize;
$userid = session('userid');
$tongji = M('user_tixian')->field("FROM_UNIXTIME(ttime,'%Y-%m-%d') days,count(id) yejishu")->where("userid = $userid and tcode in(1,2)")->group('days')->limit($limit)->order("days desc")->select();
$json['totalnum'] = count($tongji);
foreach($tongji as $v){
$html = '';
$zhifue = M('user_tixian')->where("FROM_UNIXTIME(ttime,'%Y%-%m-%d') = '$v[days]' and userid=$userid and tcode in(1,2)")->sum('uchong');
$yijiesuan = M('user_tixian')->where("FROM_UNIXTIME(ttime,'%Y-%m-%d') = '$v[days]' and userid=$userid and tcode=2")->sum('tixiane');
$weijiesuan = M('user_tixian')->where("FROM_UNIXTIME(ttime,'%Y-%m-%d') = '$v[days]' and userid=$userid and tcode=1")->sum('tixiane');
$yeji = M('user_tixian')->where("FROM_UNIXTIME(ttime,'%Y%-%m-%d') = '$v[days]' and userid=$userid")->select();
$html = '<li><p>业绩额</p><p>佣金</p><p>状态</p></li>';
foreach($yeji as $val){
$html .='<li>
                     <p>'.($val['uchong']==0 ?'奖励': $val['uchong']*0.01).'</p>
                     <p>'.($val['tixiane']*0.01).'</p>
                     <p>'.($val['tcode']==1 ?'未结算':'已结算').'</p>
                     </li>';
}
$json['html'] .= '<div class="items">
                     <p class="title"><strong>日期：</strong>'.$v['days'].' &nbsp;&nbsp;&nbsp;业绩数：'.$v['yejishu'].' </p>
                     <p>业绩额：￥'.($zhifue*0.01).' <span class="xiang">详情</span></p>
                     <p>已发佣金：<font class="qian">￥'.($yijiesuan*0.01).'</font> 待发佣金：<font class="qian">￥'.($weijiesuan*0.01).'</font></p>
                     <ul>'.$html.'</ul></div>';
}
$this->ajaxReturn($json,'json');
}
public function checkhbjine($a=0,$b=0,$c=array()){
$jine = 0;
$i=0;
while(true){
$jine = rand($a,$b);
$i++;
if(!in_array($jine,$c) ||$i==30 ){
break;
}
}
return $jine;
}
public function daili(){
$userid = session('userid');
$news = M('news')->where('ntype=2')->find();
$this->news = $news;
$config = M('sys_config')->find();
$drpath = './Uploads/daili';
$imgma = 'ma'.$userid.'.png';
if(!file_exists($drpath.'/'.$imgma)){
sp_dir_create($drpath);
vendor("phpqrcode.phpqrcode");
$phpqrcode = new \QRcode();
$hurl = $config['cmaurl'].U('Wap/Wxlogin/mainfo?utid='.$userid);
$size = "5";
$errorLevel = "L";
$phpqrcode->png($hurl,$drpath.'/'.$imgma,$errorLevel,$size);
$picpath = './Public/Wap/img/6.png';
$image = new \Think\Image();
$image->open($picpath)->water($drpath.'/'.$imgma,array(130,210),90)->save($drpath.'/t'.$imgma);
$image->open($drpath.'/t'.$imgma)->text('ID:'.$userid,'./Public/font/msyh.ttf',15,'#FFFFFF',array(210,685))->save($drpath.'/t'.$imgma);
}
$this->news = $news;
$this->display();
}
public function kefu(){
$news = M('news')->where('ntype=1')->find();
$this->news = $news;
$this->display();
}
}
?>