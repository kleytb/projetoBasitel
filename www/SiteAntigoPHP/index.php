<?php require_once('Connections/cn1.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['txtNome'])) {
  $loginUsername=$_POST['txtNome'];
  $password=$_POST['textSenha'];
  $MM_fldUserAuthorization = "str_UsuLevel";
  $MM_redirectLoginSuccess = "acessoLiberado.php";
  $MM_redirectLoginFailed = "acessoNegado.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_cn1, $cn1);
  	
  $LoginRS__query=sprintf("SELECT str_UsuNome, str_UsuPassWord, str_UsuLevel FROM usuarios WHERE str_UsuNome=%s AND str_UsuPassWord=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $cn1) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'str_UsuLevel');
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>
<!-- Copyright 2005 Macromedia, Inc. All rights reserved. -->
<title>INICIAL</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="mm_travel2.css" type="text/css" />
<script language="JavaScript" type="text/javascript">
//--------------- LOCALIZEABLE GLOBALS ---------------
var d=new Date();
var monthname=new Array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
//Ensure correct for language. English is "January 1, 2004"
var TODAY = d.getDate() + " de " + monthname[d.getMonth()] + " de " + d.getFullYear();
//---------------   END LOCALIZEABLE   ---------------
</script>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>
<body bgcolor="#C0DFFD">
<table width="100%" height="400" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#3366CC">
    <td colspan="3" rowspan="2"><div align="left"><img src="LogoBasitelMenor.png" width="161" height="138" /></div></td>
    <td height="63" colspan="3" id="logo" valign="bottom" align="center" nowrap="nowrap">BASITEL TELECOMUNICAÇÕES</td>
    <td width="89">&nbsp;</td>
  </tr>

  <tr bgcolor="#3366CC">
    <td height="52" colspan="3" id="tagline" valign="top" align="center">SISTEMA ADMINISTRATIVO</td>
	<td width="89">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="7" bgcolor="#003366"><img src="file:///C|/wamp/mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

  <tr bgcolor="#CCFF99">
  	<td height="25" colspan="7" valign="middle" id="dateformat">&nbsp;&nbsp;
    <script language="JavaScript" type="text/javascript">
      document.write(TODAY);	</script>	</td>
  </tr>
 <tr>
    <td colspan="7" bgcolor="#003366"><img src="file:///C|/wamp/mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

 <tr>
    <td width="156" valign="top" bgcolor="#C0DFFD">
   <br />
  	&nbsp;<br />
  	&nbsp;<br />
  	&nbsp;<br /> 	</td>
    <td colspan="5" valign="top"><br />
	<table width="100%" border="0">
      <tr>
        <th scope="col"><div align="center"><span class="style1">LOGAR-SE PARA ACESSAR O SISTEMA</span></div></th>
      </tr>
    </table>
<br />
	<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
	  <table width="21%" border="0" align="center">
	    <tr>
          <th width="24%" align="right" scope="col">Nome:</th>
          <th width="76%" align="left" scope="col"><input type="text" name="txtNome" id="txtNome" /></th>
        </tr>
        <tr>
          <td align="right"><div align="right"><strong>E-Mail</strong>:</div></td>
          <td align="left"><div align="left">
            <input type="text" name="textEmail" id="textEmail" />
          </div></td>
        </tr>
        <tr>
          <td align="right"><div align="right"><strong>Senha</strong>:</div></td>
          <td><div align="left">
            <input type="password" name="textSenha" id="textSenha" />
          </div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><div align="left">
            <input type="submit" name="button" id="button" value="VERIFICA USUÁRIO" />
          </div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
    </table>
	</form>
	</td>
    <td width="89">&nbsp;</td>
  </tr>
 
  <tr>
    <td width="156">&nbsp;</td>
    <td width="151">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="738">&nbsp;</td>
    <td width="51">&nbsp;</td>
    <td width="200">&nbsp;</td>
	<td width="89">&nbsp;</td>
  </tr>
</table>
</body>
</html>
