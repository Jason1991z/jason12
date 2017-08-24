<?php
return array(
    //设置默认的模块、控制器、方法
    'DEFAULT_MODULE'        =>  'Admin',  // 默认模块
    'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'index', // 默认操作名称

    //设置数据库信息
    'DB_TYPE'               =>  'mysqli',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'ecshop',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '',        // 端口
    'DB_PREFIX'             =>  '',    // 数据库表前缀
    'DB_FIELDTYPE_CHECK'    =>  false,       // 是否进行字段类型检查
    'DB_FIELDS_CACHE'       =>  false,        // 启用字段缓存

    //系统提示信息页面
    'TMPL_ACTION_ERROR'     =>  'Public:success', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   =>  'Public:success', // 默认成功跳转对应的模板文件

    //url路由
    'URL_MODEL'             =>  1,// URL访问模式,可选参数0、1、2、3,代表以下四种模式：


    'IMG_CONFIG' => array(
        'maxSize' => 1024*1024,
        'exts' => array('jpg', 'gif', 'png', 'jpeg'),
        'rootPath' => './public/uploads/',  // 上传图片的保存路径  -> PHP要使用的路径，硬盘上的路径
        'viewPath' => __ROOT__."/public/uploads/",   // 显示图片时的路径    -> 浏览器用的路径，相对网站根目录
    ),

);