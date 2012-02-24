<?php
include("xmlrpc.inc"); // 这里要改成xmlrpc.inc所在的路径
$GLOBALS['xmlrpc_internalencoding'] = 'UTF-8';

define ('DOMAIN', 'localhost'); // 博客的域名
define ('BLOGID', 1); // 博客ID，一般为1
define ('USER', 'admin'); // 博客登录的用户名
define ('PASSWORD', 'secret'); // 博客登录的密码

// 创建 xml-rpc client
$cl = new xmlrpc_client ( "/xmlrpc.php", DOMAIN, 80);

// 准备请求
$req = new xmlrpcmsg('metaWeblog.newPost');
// 逐个列出请求的参数:
$req->addParam ( new xmlrpcval ( BLOGID, 'int')); // 博客ID
$req->addParam ( new xmlrpcval ( USER, 'string' )); // 用户名
$req->addParam ( new xmlrpcval ( PASSWORD, 'string' )); // 密码
$struct = new xmlrpcval (
    array (
        "title" => new xmlrpcval ( '标题', 'string' ), // 标题
        "description" => new xmlrpcval ( '正文内容', 'string'), // 内容
    ), "struct"
);
$req->addParam ( $struct );
$req->addParam ( new xmlrpcval (1, 'int')); // 立即发布

// 发送请求
$ans = $cl->send($req);

var_dump ( $ans );
?>
