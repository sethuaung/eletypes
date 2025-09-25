<?php
//自定义连接内容
$host = "hk.xero.run";
$user = "class";
$password = "Chi123..@";
$database = "class";
$charset = "utf8mb4";
$port=3306;
@$link = mysqli_connect($host, $user, $password, $database,$port);
if (!$link) {
    die("数据库连接失败! <br/>错误号：" . mysqli_connect_errno() . "<br/>错误信息：" . mysqli_connect_error());
}
mysqli_set_charset($link, $charset);
echo "连接成功";
return $link;           //返回连接信息
?>
