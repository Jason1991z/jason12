<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>系统提示信息</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link href="/ECshop/public/css/bbs.css" type="text/css" rel="stylesheet">
    <script type="text/javascript">
        var index = 5;
        function changeTime()
        {
            document.getElementById("timeSpan").innerHTML = index;
            index--;
            if(index < 0){
                window.location = "<?php echo ($jumpUrl); ?>";
            }
            else{
                window.setTimeout("changeTime()",1000);
            }
        }
    </script>
</head>
<body onload="changeTime()">


<table border="1" align="center" width="600">
    <tr>
        <td><b>系统提示信息</b></td>
    </tr>
    <tr>
        <td align="center">
            <br/><?php echo ($message); ?> 页面将在 <span id="timeSpan">5</span> 秒钟内自动跳转！<br/>
            <br/>如果没有自动跳转，<a href="<?php echo ($jumpUrl); ?>">请点击这里</a>。<br/><br/>
        </td>
    </tr>
</table>

</body>
</html>