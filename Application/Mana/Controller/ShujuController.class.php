<?php

namespace Mana\Controller;
use Think\Controller;
class ShujuController extends CommonController {
public function index(){
$chongzong = M('user_chongzhi')->where("dcode=2")->sum('djine');
$fazong = M('user_hb')->where('tcode=1')->sum('hbe');
$dailifa = M('user_tixian')->where('tcode in(2)')->sum('tixiane');
$dailiweifa = M('user_tixian')->where('tcode in(1)')->sum('tixiane');
$dailikou = M('user_tixian')->where('tcode in(4)')->sum('tixiane');
$this->chongzong=$chongzong;
$this->dailikou = $dailikou;
$this->fazong   = $fazong;
$this->dailifa = $dailifa;
$this->dailiweifa = $dailiweifa;
$this->display();
}
public function ajaxtubiao(){
$riqi = I('date',0,'intval');
for($i=$riqi ;$i >0 ;$i--){
$xitem[] = date("m-d",time()-86400*$i);
$t = date("Y-m-d",time()-86400*$i);
$sktime = strtotime($t);
$sjtime = $sktime +86400;
$n = M('user_chongzhi')->where("dtime>$sktime and dtime<$sjtime and dcode =2")->sum('djine');
$chongzhi[]= intval($n)*0.01;
$n = M('user_hb')->where("ttime>$sktime and ttime < $sjtime and tcode=1")->sum('hbe');
$fachu[]=intval($n)*0.01;
}
$data = array(
'date'=>$xitem,
'chongzhi'=>$chongzhi,
'fachu'=>$fachu
);
$this->ajaxReturn($data,'json');
}
}

?>