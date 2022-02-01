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

mysql_select_db($database_cn1, $cn1);
$query_rsId = "SELECT os.int_OsId FROM os";
$rsId = mysql_query($query_rsId, $cn1) or die(mysql_error());
$row_rsId = mysql_fetch_assoc($rsId);
$totalRows_rsId = mysql_num_rows($rsId);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>
<!-- Copyright 2005 Macromedia, Inc. All rights reserved. -->
<title>BUSCA OS</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="mm_travel2.css" type="text/css" />
<style type="text/css">
.SELETOR {
	font-size: 14px;
}
.SELETOR {
	font-size: 14px;
}
</style>
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
<table width="100%" height="470" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#3366CC">
    <td colspan="3" rowspan="2"><div align="left"><img src="LogoBasitelMenor.png" width="161" height="130" alt="logo basitel menor" /></div></td>
    <td height="63" colspan="3" id="logo" valign="bottom" align="center" nowrap="nowrap">BASITEL TELECOMUNICAÇÕES</td>
    <td width="113">&nbsp;</td>
  </tr>

  <tr bgcolor="#3366CC">
    <td height="31" colspan="3" id="tagline" valign="top" align="center">SISTEMA ADMINISTRATIVO</td>
	<td width="113">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="7" bgcolor="#003366"><img src="../mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

  <tr bgcolor="#CCFF99">
  	<td colspan="7" id="dateformat" height="25">&nbsp;&nbsp;
  	  <div align="left">
  	    <script language="JavaScript" type="text/javascript">
      document.write(TODAY);	</script>
    </div></td>
  </tr>
 <tr>
    <td colspan="7" bgcolor="#003366"><img src="../mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

 <tr>
    <td width="161" rowspan="2" valign="top" bgcolor="#E6F3FF"><br />
  	&nbsp; <table width="161" border="0" align="center" cellpadding="0" cellspacing="0" id="navigation">
  	  <tr>
  	    <td width="161" height="75">&nbsp;<br />
  	      <strong>&nbsp;ORDENS DE SERVIÇO</strong><br /></td>
	    </tr>
  	  <tr>
  	    <td width="161" style="text-align: center"><a href="cadOs.php">INCLUIR</a></td>
	    </tr>
  	  <tr>
  	    <td width="161" style="text-align: center"><a href="buscaOS.php">ALTERAR</a></td>
	    </tr>
  	  <tr>
  	    <td width="161" style="text-align: center"><a href="relOS.php">EXIBIR</a></td>
	    </tr>
  	  <tr>
  	    <td width="161" style="text-align: center"><a href="excluirOS.php">EXCLUIR</a></td>
	    </tr>
          <tr>
  	    <td width="161" style="text-align: center"><a href="filtrar.php">FILTRAR</a></td>
	    </tr>
  	  <tr>
  	    <td width="161" style="text-align: center"><a href="javascript:;" class="navText">CONTATO</a></td>
	    </tr>
	  </table>
  	<br />
  	&nbsp;<br />
  	&nbsp;<br /> 	</td>
    <td height="58" colspan="5"><br />
	&nbsp;
	<table width="100%" border="0">
      <tr>
        <th scope="col"><div align="center" class="SELETOR">SISTEMA DE GERENCIAMENTO DE ORDENS DE SERVIÇO </div></th>
      </tr>
    </table>
	<div align="center">
	  <table width="20%" height="68" border="0" align="center">
        <tr>
          <th height="30" class="SELETOR" scope="col">ALTERAR DADOS DAS OS</th>
        </tr>
        <tr>
          <td><p align="center">DIGITE A ID DA OS A ALTERAR</p>
            </td>
        </tr>
      </table>
	  <br />
	  </div>
	<table width="100%" border="0">
      <tr>
        <th scope="col"><div align="center">
          <form id="form1" name="form1" method="post" action="altera.php">
            <label>
            <input type="text" name="txtid" id="txtid" />
            </label>
                    <input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $row_rsId['int_OsId']; ?>" />
                    <label></label>
                    <input type="submit" name="btnBuscar" id="btnBuscar" value="BUSCAR OS" />
          </form>
          </div></th>
      </tr>
    </table>
	<table width="100%" border="0">
      <tr>
        <th scope="col">&nbsp;</th>
        <th valign="top" scope="col">&nbsp;<br /></th>
        <th scope="col">&nbsp;</th>
      </tr>
    </table>	<p>&nbsp;</p></td>
    <td width="113" rowspan="2">&nbsp;</td>
  </tr>
 <tr>
   <td colspan="5">&nbsp;</td>
 </tr>
  <tr>
    <td width="161">&nbsp;</td>
    <td width="186">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="849">&nbsp;</td>
    <td width="58">&nbsp;</td>
    <td width="230">&nbsp;</td>
	<td width="113">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsId);
?>
