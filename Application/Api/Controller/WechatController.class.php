<?php

namespace Api\Controller;
use Think\Controller;
class WechatController extends Controller {
public function index(){
if (isset($_GET['echostr'])) {
$this->valid();
}else {
define('MYUID',I('get.aid/d'));
$this->responseMsg();
}
}
public function responseMsg(){
$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
if (!empty($postStr)){
$postObj = simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);
$fromUsername = $postObj->FromUserName;
$toUsername = $postObj->ToUserName;
$MsgType=$postObj->MsgType;
switch($MsgType){
case "event":
if($postObj->Event == "CLICK"){
$keyword = trim($postObj->EventKey);
$this->getKeyContent($fromUsername,$toUsername,$keyword);
}
if($postObj->Event == "subscribe"){
if(!empty($postObj->EventKey)){
$imgid = intval(substr($postObj->EventKey,8));
$this->maHongbao($imgid,$fromUsername,$toUsername);
}else {
$this->getKeyContent($fromUsername,$toUsername,'',0);
}
}
if($postObj->Event == "SCAN"){
$imgid = intval($postObj->EventKey);
$this->maHongbao($imgid,$fromUsername,$toUsername);
}
if($postObj->Event == "unsubscribe"){
}
break;
case "text":
$keyword = trim($postObj->Content);
$this->getKeyContent($fromUsername,$toUsername,$keyword);
break;
default :
echo '';
break;
}
}else {
echo '';
}
}
private function maHongbao($imgid = 0,$fromUsername,$toUsername){
$this->checkUser($fromUsername);
$huodongimg = M('huodong_img')->where("id=$imgid")->find();
$itemid = intval($huodongimg['itemid']);
$huodong = M('huodong')->where("id=$itemid")->find();
$keyword = $huodong['hhuifu'];
$this->getKeyContent($fromUsername,$toUsername,$keyword);
$data = array ('imgid'=>$imgid,'touser'=>$fromUsername);
$urls = 'http://'.$_SERVER['HTTP_HOST'].U('Admin/Wxhongbao/Index');
http_curl_post($urls,$data);
}
private function getKeyContent($fromUsername,$toUsername,$keytxt='',$stype=1){
$whe['adminid'] = MYUID;
if($stype == 0) {
$whe['stype'] = 0;
$seldata = M('weixin_sendkey')->where($whe)->find();
}else {
$whe['sname'] = array('like',"%$keytxt%");
$seldata = M('weixin_sendkey')->where($whe)->find();
if(!$seldata){
$whe['sname'] = '默认';
$seldata = M('weixin_sendkey')->where($whe)->find();
}
}
if($seldata){
if($seldata['kcode'] == 0){
$this->getTextMsg($fromUsername,$toUsername,$seldata['id']);
}else {
$this->sendListImgMsg($fromUsername,$toUsername,$seldata['id']);
}
}
}
private function checkUser($ucode=''){
$num = M('user_list')->where("ucode='$ucode'")->count();
if($num == 0){
$config = M('sys_config')->find();
$wxtoken = new \Common\Tool\Wxtoken($config['cwxappid'],$config['cwxappsecret']);
$access_token = $wxtoken->getAccessToken();
$ugeturl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$ucode."&lang=zh_CN";
$ugetcon = json_decode(http_curl_get($ugeturl));
$data[ucode]  = $ugetcon->openid;
$data[uickname]  = $ugetcon->nickname;
$data[uheadimgurl]  = $ugetcon->headimgurl;
$data[udizhi]      = $ugetcon->province.$ugetcon->city;
$data[usex] = $ugetcon->sex;
$data[uregtime] = time();
M('user_list')->data($data)->add();
}
}
private function sendListImgMsg($fromUsername,$toUsername,$sendid){
$whe['kid'] = $sendid ;
$picCount = M('weixin_sendcon')->where($whe)->count();
if($picCount >0) {
$time = time();
$newsContent = '';
$newsStart = "<xml>
					   <ToUserName><![CDATA[$fromUsername]]></ToUserName>
					   <FromUserName><![CDATA[$toUsername]]></FromUserName>
					   <CreateTime>$time</CreateTime>
					   <MsgType><![CDATA[news]]></MsgType>
					   <ArticleCount>$picCount</ArticleCount>
					   <Articles>
					";
$newsEnd = "</Articles></xml>";
$seldata = M('weixin_sendcon')->where($whe)->order('snum desc,id desc')->select();
foreach($seldata as $key =>$crow){
$msgtitle = $crow["sname"];
$msgcontent = $crow["sdec"];
$msgpicurl = 'http://'.$this->_server('HTTP_HOST').__ROOT__."/Uploads/".substr($crow["stime"],0,4)."/".substr($crow["stime"],4,2)."/".substr($crow["stime"],6,2)."/".$crow["spic"];
$urls = parse_url($crow['surl']);
$str = $urls['query'];
if($str != '')  {
$str = '&ucode='.$fromUsername.'&uwxid='.$toUsername;
}else {
$str = '?ucode='.$fromUsername.'&uwxid='.$toUsername;
}
$msgclickurl = $crow['surl'].$str;
$newsContent = $newsContent ."
						   <item>
						   <Title><![CDATA[$msgtitle]]></Title> 
						   <Description><![CDATA[$msgcontent]]></Description>
						   <PicUrl><![CDATA[$msgpicurl]]></PicUrl>
						   <Url><![CDATA[$msgclickurl]]></Url>
						   </item>
						   ";
}
$resultStr = $newsStart.$newsContent.$newsEnd;
echo $resultStr;
}else {
echo '';
}
}
private function getTextMsg($fromUsername,$toUsername,$sendid=0){
$whe['kid'] = $sendid;
$seldata = M('weixin_sendcon')->where($whe)->find();
if($seldata){
$msgcontent = $seldata['sdec'];
if($seldata['surl'] != ''){
$urls = parse_url($seldata['surl']);
$str = $urls['query'];
if($str != ''){
$str = '&ucode='.$fromUsername.'&uwxid='.$toUsername;
}else {
$str = '?ucode='.$fromUsername.'&uwxid='.$toUsername;
}
$urls = $seldata['surl'].$str;
$msgcontent = "<a href='".$urls."'>".$msgcontent.'</a>';
}
$this->sendTextOne($fromUsername,$toUsername,$msgcontent);
}else {
echo '';
}
}
private function sendImgOne($fromUsername,$toUsername,$media_id){
$time=time();
$resultStr="<xml>
		         <ToUserName><![CDATA[$fromUsername]]></ToUserName>
		         <FromUserName><![CDATA[$toUsername]]></FromUserName>
		         <CreateTime>$time</CreateTime>
		         <MsgType><![CDATA[image]]></MsgType>
		         <Image>
		         <MediaId><![CDATA[$media_id]]></MediaId>
		         </Image>
		         </xml>";
echo $resultStr;
}
private function sendTextOne($fromUsername,$toUsername,$text=''){
$time = time();
$textTpl="
		         <xml>
				  <ToUserName><![CDATA[$fromUsername]]></ToUserName>
				  <FromUserName><![CDATA[$toUsername]]></FromUserName>
				  <CreateTime>$time</CreateTime>
				  <MsgType><![CDATA[text]]></MsgType>
				  <Content><![CDATA[$text]]></Content>
				 </xml>";
echo $textTpl;
}
public function valid()
{
$echoStr = I('echostr');
if($this->checkSignature()){
echo $echoStr;
}
}
private function checkSignature()
{
$signature = I('signature');
$timestamp = I('timestamp');
$nonce = I('nonce');
$token = C('WX_TOKEN');
$tmpArr = array($token,$timestamp,$nonce);
sort($tmpArr,SORT_STRING);
$tmpStr = implode( $tmpArr );
$tmpStr = sha1( $tmpStr );
if( $tmpStr == $signature ){
return true;
}else {
return false;
}
}
}
?>