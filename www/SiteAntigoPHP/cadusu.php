<?php require_once('Connections/cn1.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "sup,adm";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "acessoNegado.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO usuarios (str_UsuNome, str_UsuEmail, str_UsuPassWord, str_UsuLevel) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['str_UsuNome'], "text"),
                       GetSQLValueString($_POST['str_UsuEmail'], "text"),
                       GetSQLValueString($_POST['str_UsuPassWord'], "text"),
                       GetSQLValueString($_POST['str_UsuLevel'], "text"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "usuarios.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
 
 
 
 
 
  $insertSQL = sprintf("INSERT INTO usuarios (str_UsuNome, str_UsuEmail, str_UsuPassWord, str_UsuLevel, str_UsuKey) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['str_UsuNome'], "text"),
                       GetSQLValueString($_POST['str_UsuEmail'], "text"),
                       GetSQLValueString( $_POST['str_UsuPassWord'], "text"),
                       GetSQLValueString($_POST['str_UsuLevel'], "text"),
                       GetSQLValueString($_POST['str_UsuKey'], "text"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "usuarios.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>
<!-- Copyright 2005 Macromedia, Inc. All rights reserved. -->
<title>CADASTRO DE USUARIO</title>
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


</head>
<body bgcolor="#C0DFFD">
<table width="100%" height="482" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#3366CC">
    <td colspan="3" rowspan="2"><table width="43%" height="57" border="0">
      <tr>
        <th scope="col"><img src="LogoBasitelMenor.png" width="114" height="95" /></th>
      </tr>
    </table></td>
    <td height="63" colspan="3" id="logo" valign="bottom" align="center" nowrap="nowrap">BASITEL TELECOMUNICAÇÕES</td>
    <td width="90">&nbsp;</td>
  </tr>

  <tr bgcolor="#3366CC">
    <td height="19" colspan="3" id="tagline" valign="top" align="center">SISTEMA ADMINISTRATIVO</td>
	<td width="90">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="7" bgcolor="#003366"><img src="../mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

  <tr bgcolor="#CCFF99">
  	<td colspan="7" id="dateformat" height="13">&nbsp;&nbsp;
    <script language="JavaScript" type="text/javascript">
      document.write(TODAY);	</script>	</td>
  </tr>
 <tr>
    <td colspan="7" bgcolor="#003366"><img src="../mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

 <tr>
    <td width="123" rowspan="2" valign="top" bgcolor="#E6F3FF">
	<table width="119" border="0" align="center" cellpadding="0" cellspacing="0" id="navigation">
        <tr>
          <td width="119">&nbsp;<br />
		 &nbsp;<br /></td>
        </tr>
        <tr>
          <td width="119">&nbsp;</td>
        </tr>
        <tr>
          <td width="119">&nbsp;</td>
        </tr>
        <tr>
          <td width="119">&nbsp;</td>
        </tr>
        <tr>
          <td width="119">&nbsp;</td>
        </tr>
        <tr>
          <td width="119">&nbsp;</td>
        </tr>
      </table>
 	 <br />
  	&nbsp;<br />
  	&nbsp;<br />
  	&nbsp;<br /> 	</td>
    <td height="58" colspan="5"><br />
	&nbsp;
	<table width="100%" border="0">
      <tr>
        <th scope="col">SISTEMA DE GERENCIAMENTO DE ORDENS DE SERVIÇO DO CONTRATO 2013.7421.2109 MNT CENTRAIS TELEFÔNICAS</th>
      </tr>
    </table>
	<br />
	<table width="100%" border="0">
      <tr>
        <th scope="col">CADASTRO DE USUÁRIOS (somente suporte)</th>
      </tr>
    </table>
	<br />
	<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap="nowrap">Nome:</td>
          <td><input type="text" name="str_UsuNome" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap="nowrap">Email:</td>
          <td><input type="text" name="str_UsuEmail" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap="nowrap">Senha:</td>
          <td><input type="text" name="str_UsuPassWord" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap="nowrap">Nível:</td>
          <td><select name="str_UsuLevel">
              <option value="cli" <?php if (!(strcmp("cli", ""))) {echo "SELECTED";} ?>>Cliiente</option>
              <option value="fun" <?php if (!(strcmp("fun", ""))) {echo "SELECTED";} ?>>Funcionário</option>
              <option value="adm" <?php if (!(strcmp("adm", ""))) {echo "SELECTED";} ?>>Administrativo</option>
              <option value="sup" <?php if (!(strcmp("sup", ""))) {echo "SELECTED";} ?>>Suporte</option>
            </select>
          </td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
          <td><input type="submit" value="CADASTRAR USUÁRIO" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
    <p>&nbsp;</p>
    <br /></td>
    <td width="90" rowspan="2">&nbsp;</td>
  </tr>
 <tr>
   <td colspan="5">&nbsp;</td>
 </tr>
  <tr>
    <td width="123">&nbsp;</td>
    <td width="152">&nbsp;</td>
    <td width="4">&nbsp;</td>
    <td width="658">&nbsp;</td>
    <td width="44">&nbsp;</td>
    <td width="177">&nbsp;</td>
	<td width="90">&nbsp;</td>
  </tr>
</table>
</body>
</html>
