<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/2
 * Time: 19:39
 */
header("content-type:text/html;charset=utf-8");

define("BIND_MODULE","Home");
define("APP_PATH","application/");
define("APP_DEBUG",true);
define("BUILD_DIR_SECURE",false);

include_once 'library/ThinkPHP/ThinkPHP.php';