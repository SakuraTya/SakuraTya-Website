<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>......</title></head>
<body>
<?php
$users = file('/home/cat/userdata.csv');
$usersary = array();
foreach ($users as $user) {
	list($name, $pass) = explode(',', $user);
	$usersary[$name] = array(name => $name, pass => $pass);
}
$userfound = 0;
foreach ($usersary as $userary){
	if ($userary['name'] == $_POST['username']){
		$userfound = 1;
		$username = $userary['name'];
	}
}
if ($userfound == 1){
	if (strcmp($usersary[$name]['pass'], $_POST['passwd']) == 0){
		echo "登录成功！";
		printf ("%s     %s <br />",$usersary[$name]['pass'],   $_POST['passwd']);
	}else{
		echo "密码错误！";
		printf ("%s     %s <br />",$usersary[$name]['pass'],   $_POST['passwd']);
	}
}else{
	echo "用户名错误！";
}
print_r($usersary);
?>
</body>
</html>