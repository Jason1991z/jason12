<?php
return array(
    
    'IMG_CONFIG' => array(
        'maxSize' => 1024*1024,
        'exts' => array('jpg', 'gif', 'png', 'jpeg'),
        'rootPath' => './public/uploads/',  // 上传图片的保存路径  -> PHP要使用的路径，硬盘上的路径
        'viewPath' => __ROOT__."/public/uploads/",   // 显示图片时的路径    -> 浏览器用的路径，相对网站根目录
    ),

);