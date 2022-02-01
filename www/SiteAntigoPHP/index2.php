<?php require_once('Connections/cn1.php'); ?>
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
<script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script><script language="JavaScript" type="text/javascript">
//--------------- LOCALIZEABLE GLOBALS ---------------
var d=new Date();
var monthname=new Array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
//Ensure correct for language. English is "January 1, 2004"
var TODAY = d.getDate() + " de " + monthname[d.getMonth()] + " de " + d.getFullYear();
//---------------   END LOCALIZEABLE   ---------------
</script>
<link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css" />
<style type="text/css" media="screen">
@import url("../../../Users/Gil/Desktop/menu/menu.css");


	

@import url("../../../Users/Gil/Desktop/menu/menu.css");


	

@import url("../../../Users/Gil/Desktop/menu/menu.css");


	

	@import url("../../../Users/Gil/Desktop/menu/menu.css");
</style>
<script language="JavaScript1.2" type="text/javascript" src="mm_css_menu.js"></script>
</head>
<body bgcolor="#C0DFFD">
<div align="center"></div>
<table width="100%" height="400" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#3366CC">
    <td colspan="2" rowspan="2"><img src="LogoBasitelMenor.png" width="161" height="138" /></td>
    <td rowspan="2">&nbsp;</td>
    <td height="63" colspan="3" id="logo" valign="bottom" align="center" nowrap="nowrap">BASITEL TELECOMUNICAÇÕES</td>
    <td width="77">&nbsp;</td>
  </tr>

  <tr bgcolor="#3366CC">
    <td height="52" colspan="3" id="tagline" valign="top" align="center">SISTEMA ADMINISTRATIVO</td>
	<td width="77">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="7" bgcolor="#003366"><img src="file:///C|/wamp/mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

  <tr bgcolor="#CCFF99">
  	<td colspan="7" id="dateformat" height="25">&nbsp;&nbsp;<script language="JavaScript" type="text/javascript">
      document.write(TODAY);	</script>	</td>
  </tr>
 <tr>
    <td colspan="7" bgcolor="#003366"><img src="file:///C|/wamp/mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

 <tr>
    <td width="150" align="center" valign="top" bgcolor="#E6F3FF"><fieldset>
    </fieldset></td>
    <td colspan="5" valign="top">&nbsp;</td>
    <td width="77">&nbsp;</td>
  </tr>
 
  <tr>
    <td width="150" bgcolor="#E6F3FF">&nbsp;</td>
    <td width="8">&nbsp;</td>
    <td width="144">&nbsp;</td>
    <td width="660">&nbsp;</td>
    <td width="44">&nbsp;</td>
    <td width="177">&nbsp;</td>
	<td width="77">&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
<!--
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
//-->
</script>
</body>
</html>
