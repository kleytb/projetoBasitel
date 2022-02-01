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
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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

if ((isset($_GET['int_OsId'])) && ($_GET['int_OsId'] != "") && (isset($_POST['int_OsId']))) {
  $deleteSQL = sprintf("DELETE FROM os WHERE int_OsId=%s",
                       GetSQLValueString($_GET['int_OsId'], "int"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($deleteSQL, $cn1) or die(mysql_error());

  $deleteGoTo = "relOS.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>
<!-- Copyright 2005 Macromedia, Inc. All rights reserved. -->
<title>ALTERAÇÃO DE OS</title>
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
.style2 {font-size: 14px}
-->
</style>
</head>
<body bgcolor="#C0DFFD">
<table width="100%" height="470" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#3366CC">
    <td colspan="3" rowspan="2"><img src="LogoBasitelMenor.png" width="161" height="130" alt="logo basitel menor" /></td>
    <td height="63" colspan="3" id="logo" valign="bottom" align="center" nowrap="nowrap">BASITEL TELECOMUNICAÇÕES</td>
    <td width="108">&nbsp;</td>
  </tr>

  <tr bgcolor="#3366CC">
    <td height="31" colspan="3" id="tagline" valign="top" align="center">SISTEMA ADMINISTRATIVO</td>
	<td width="108">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="7" bgcolor="#003366"><img src="../mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

  <tr bgcolor="#CCFF99">
  	<td colspan="7" id="dateformat" height="25">&nbsp;&nbsp;<script language="JavaScript" type="text/javascript">
      document.write(TODAY);	</script>	</td>
  </tr>
 <tr>
    <td colspan="7" bgcolor="#003366"><img src="../mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

 <tr>
    <td width="165" rowspan="2" valign="top" bgcolor="#E6F3FF">
	<table width="161" border="0" align="left" cellpadding="0" cellspacing="0" id="navigation">
        <tr>
          <td width="161">&nbsp;<br />
		 &nbsp;<strong>&nbsp;ORDENS DE SERVIÇO</strong><br /></td>
        </tr>
        <tr>
          <td width="161"><a href="cadOs.php">INCLUIR</a></td>
        </tr>
        <tr>
          <td width="161"><a href="buscaOS.php">ALTERAR</a></td>
        </tr>
        <tr>
          <td width="161"><a href="relOS.php">EXIBIR</a></td>
        </tr>
        <tr>
          <td width="161"><a href="javascript:;" class="navText">FILTRAR</a></td>
        </tr>
        <tr>
          <td width="161"><a href="javascript:;" class="navText">CONTATO</a></td>
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
        <th scope="col">SISTEMA DE GERENCIAMENTO DE ORDENS DE SERVIÇO </th>
      </tr>
    </table>
	<br />
	<table width="100%" border="0">
      <tr>
        <th scope="col">EXCLUSÃO DE ORDENS DE SERVIÇO</th>
      </tr>
    </table>
	<div align="center">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="56%" border="1" align="center">
          <tr valign="baseline">
            <td width="151" align="right" valign="middle" nowrap="nowrap">ALTERANDO OS ID:</td>
            <td colspan="4"><div align="left"><span class="style2"><?php echo $row_recAltera['int_OsId']; ?></span></div></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">NÚMERO DA OS:</td>
            <td width="245"><input type="text" name="str_OsNum" value="<?php echo htmlentities($row_recAltera['str_OsNum'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            <td width="89" align="right" valign="middle">PRIORIDADE:</td>
            <td colspan="2"><input type="text" name="str_OsPri" value="<?php echo htmlentities($row_recAltera['str_OsPri'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap"><div align="right">PREFIXO:</div></td>
            <td><input type="text" name="str_OsPref" value="<?php echo htmlentities($row_recAltera['str_OsPref'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            <td align="right" valign="middle">DEPEND:</td>
            <td colspan="2"><input type="text" name="str_OsDep" value="<?php echo htmlentities($row_recAltera['str_OsDep'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>

          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">DERCRIÇÃO:</td>
            <td><textarea name="str_OsDescProb" cols="32" rows="6"><?php echo htmlentities($row_recAltera['str_OsDescProb'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
            <td colspan="2" align="right" valign="middle" nowrap="nowrap"><p>OBS:</p>              </td>
            <td width="247" align="left" valign="middle" nowrap="nowrap"><textarea name="str_OsObs" cols="32" rows="6"><?php echo htmlentities($row_recAltera['str_OsObs'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
            </tr>
          
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">DATA DO CHAMADO:</td>
            <td><input type="text" name="str_OsDataCham" value="<?php echo htmlentities($row_recAltera['str_OsDataCham'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            <td height="29" colspan="2" align="right" valign="middle">TÉCNICO:</td>
            <td height="29" valign="middle"><input type="text" name="str_OsTecResp" value="<?php echo htmlentities($row_recAltera['str_OsTecResp'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap"><div align="right">INÍCIO DO ATENDIMENTO</div></td>
            <td><input type="text" name="str_OsDataIni" value="<?php echo htmlentities($row_recAltera['str_OsDataIni'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            <td height="29" align="right" valign="middle">FIM DO ATENDIMENTO:</td>
            <td colspan="2" valign="middle"><input type="text" name="str_OsDataFim" value="<?php echo htmlentities($row_recAltera['str_OsDataFim'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">STATUS:</td>
            <td><input type="text" name="str_OsStatus" value="<?php echo htmlentities($row_recAltera['str_OsStatus'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
            <td colspan="3" align="right">&nbsp;</td>
            </tr>

          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td colspan="2"><div align="left">
              <input type="submit" value="EXCLUIR AGORA" />
            </div></td>
            <td colspan="2">&nbsp;</td>
            </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="int_OsId" value="<?php echo $row_recAltera['int_OsId']; ?>" />
      </form>
      <p>&nbsp;</p>
      <br />
	  &nbsp;<br />
    </div></td>
    <td width="108" rowspan="2">&nbsp;</td>
  </tr>
 <tr>
   <td colspan="5">&nbsp;</td>
 </tr>
  <tr>
    <td width="165">&nbsp;</td>
    <td width="178">&nbsp;</td>
    <td width="6">&nbsp;</td>
    <td width="839">&nbsp;</td>
    <td width="58">&nbsp;</td>
    <td width="227">&nbsp;</td>
	<td width="108">&nbsp;</td>
  </tr>
</table>
</body>
</html>
