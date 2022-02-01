<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cn1 = "mysql.basitel.com.br";
$database_cn1 = "basitel";
$username_cn1 = "basitel";
$password_cn1 = "phoenix24";
$cn1 = mysql_pconnect($hostname_cn1, $username_cn1, $password_cn1) or trigger_error(mysql_error(),E_USER_ERROR); 
?>