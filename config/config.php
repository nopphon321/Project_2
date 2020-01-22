<?php
date_default_timezone_set("Asia/Bangkok");
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "reservation";

 $conn=new mysqli($db_host, $db_user, $db_pass, $db_name);

 if ($conn->connect_errno){
     echo "Fail to connect MySQLI:(".$conn->connect_errno.")".$conn->connect_error;
 }

 $conn->query("SET aql_mode=''");
 
 $conn->set_charset("utf8");
?>