<?php
/**
 * 樱茶幻萌组-API基础配置文件
 * 
 * 本配置文件包含关于API的所有基础配置
 * 关于数据库配置则直接引用 WordPress的配置文件
 * 
 * @package SakuraTya
 * @subpackage API
 */

/*引用WordPress配置文件*/
require_once("../wp-config.php");

/** 数据库表名*/
define("TABLE_NAME", $table_prefix . "acf");

/**
 * API Key
 * 
 * 用于验证连接API的客户端的身份
 * 格式为6个字符，不区分大小写
 */
define('API_KEY', 'tokens');

/**#@+
 * 数据来源类型设置
 * 
 * 定义数据库表中"data_type"列的数据
 */
/*"喜欢"按钮 */
define("DT_LIKE", '1');
/*评分系统*/
define("DT_SCORE", '2');

/**#@-*/