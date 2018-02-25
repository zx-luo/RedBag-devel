<?php

namespace Mana\Controller;
use Think\Controller;
class ZhuanpanController extends CommonController {
public function add(){
$seldata = M('hb')->where("htype=2")->find();
$id = intval($seldata['id']);
$hbgailv = M('hb_gailv')->where("hbid=$id")->select();
$this->seldata = $seldata;
$this->hbgailv = $hbgailv;
$this->display();
}
public function save(){
$data['hzhifue'] = I('hzhifue',0)*100;
$data['htime'] = I('htime',0,'intval');
$id = I('get.id',0,'intval');
if($id >0) {
$data['id']=$id;
M('hb')->save($data);
}else {
$data['htype'] = 2;
$id = M('hb')->add($data);
}
$hjiaodu = I('hjiaodu');
$hmin = I('hmin');
$hmax = I('hmax');
$hgailv = I('hgailv');
$hcishu = I('hcishu');
$hbgailv = M('hb_gailv')->where("hbid=$id")->select();
$gailvnum = ( count($hbgailv) >= count($hmin) ) ?count($hbgailv) : count($hmin);
for($i=0 ;$i <$gailvnum ;$i++){
$data = array(
'hbid'=>$id,
'hjiaodu'=>intval($hjiaodu[$i]),
'hmin'=>intval($hmin[$i] * 100),
'hmax'=>intval($hmax[$i] * 100),
'hgailv'=>intval($hgailv[$i]),
'hcishu'=>intval($hcishu[$i])
);
if(count($hbgailv) >= count($hmin)){
if($i <= count($hmin)-1){
$data['id'] = $hbgailv[$i]['id'];
M('hb_gailv')->save($data);
}else {
$gailvid = $hbgailv[$i]['id'];
M('hb_gailv')->where("id=$gailvid")->delete();
}
}else {
if($i <= count($hbgailv)-1){
$data['id'] = $hbgailv[$i]['id'];
M('hb_gailv')->save($data);
}else {
M('hb_gailv')->add($data);
}
}
unset($data);
}
$this->success('操作成功',U('add'),1);
}
public function ajaxhbcode(){
$id=I('id');
$hb=M('hb')->where("id=$id")->find();
$hcode = $hb['hcode'] == 2 ?1:2;
M('hb')->save(array('id'=>$id,'hcode'=>$hcode));
}
public function ajaxmoni(){
$hzhifue = I('hzhifue',0,'intval');
$hminmoney = I('hminmoney',0)*100 ;
$hmaxmoney = I('hmaxmoney',0)*100 ;
$hgeshu = I('hgeshu',0);
$hmin = I('hmin');
$hmax = I('hmax');
$hgailv = I('hgailv');
for($i=0 ;$i <50 ;$i++){
for($j=0 ;$j <count($hgailv) ;$j++){
$hbarr[] = $this->checkhbjine($hmin[$j]*100,$hmax[$j]*100,$hbarr);
}
$hblist[] = $hbarr;
unset($hbarr);
}
$huaqian = 0;
$chouqian = 0;
foreach($hblist as $v){
for($i=0 ;$i <2;$i++){
$key = get_arr_rand($hgailv);
foreach($v as $s){
if($s >= ($hmin[$key]*100) &&$s <= ($hmax[$key]*100) ){
$huaqian = $huaqian +$hzhifue;
$chouqian = $chouqian +$s;
$chouarr[] = $s*0.01;
break;
}
}
}
}
$html = '模拟转盘<font color="#FF0000"><strong>100</strong></font>次，刷新50次，花费：<font color="#FF0000"><strong>'.$huaqian.'</strong></font>元，发出红包：<font color="#FF0000"><strong>'.($chouqian*0.01).'</strong></font>元，';
$html .= '抽中红包展示：';
$html .= implode('|',$chouarr);
echo $html;
}
public function checkhbjine($a=0,$b=0,$c=array()){
$jine = 0;
$i=0;
while(true){
$jine = rand($a,$b);
$i++;
if(!in_array($jine,$c) ||$i==20 ){
break;
}
}
return $jine;
}
}
?>