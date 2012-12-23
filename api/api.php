<?php
header('Content-Type: text/plain');
require("api-config.php");
$data=restUtils::processRequest();
$reqvar=$data->getRequestVars();
if(!isset($reqvar['api'])){
	error('没有指定API名称');
}
$have_data=isset($reqvar['data']);
if($have_data){
	$func_param[0]=$reqvar;
	$func_param[1]=$reqvar['data'];
}else{
	$func_param[0]=$reqvar;
}
try{
	$class=new ReflectionClass($apis[$reqvar['api']]);
}
catch (ReflectionException $e){
	error('没有此接口');
}

$instance=$class->newInstance();
if(!is_callable(array(&$instance,$data->getMethod()))){
	error('没有此接口');
}
$method=$class->getMethod($data->getMethod())->getParameters();
if (count($method)==1){
	if($have_data){
		error('非法参数');
	}
}
if(count($method)==2){
	if(!$have_data){
		error('非法参数');
	}
}
$rep=call_user_func_array(array(&$instance,$data->getMethod()),$func_param);
restUtils::sendResponse($rep['status'],$rep['body']);
function error($msg){
	restUtils::sendResponse(403,array('msg'=>$msg));
	exit;
}


