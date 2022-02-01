<?php require_once('Connections/cn1.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "sup";
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
  $insertSQL = sprintf("INSERT INTO contratos (numCont, cliente, objeto, dataIni, dataFim, aditivos, proxVcto, cont1, cont2, cont3, fiscal, gestor, docs, obs, valor) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['numCont'], "text"),
                       GetSQLValueString($_POST['cliente'], "text"),
                       GetSQLValueString($_POST['objeto'], "text"),
                       GetSQLValueString($_POST['dataIni'], "date"),
                       GetSQLValueString($_POST['dataFim'], "date"),
                       GetSQLValueString($_POST['aditivos'], "text"),
                       GetSQLValueString($_POST['proxVcto'], "date"),
                       GetSQLValueString($_POST['cont1'], "text"),
                       GetSQLValueString($_POST['cont2'], "text"),
                       GetSQLValueString($_POST['cont3'], "text"),
                       GetSQLValueString($_POST['fiscal'], "text"),
                       GetSQLValueString($_POST['gestor'], "text"),
                       GetSQLValueString($_POST['docs'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['valor'], "text"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "relCont";
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
<title>CADASTRAR CONTRATO</title>
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
<div align="left">
  <table width="100%" height="470" border="0" cellpadding="0" cellspacing="0">
    <tr bgcolor="#3366CC">
      <td colspan="3" rowspan="2"><img src="../LogoBasitelMenor.png" width="149" height="130" alt="logo basitel menor" /></td>
      <td height="63" colspan="3" id="logo" valign="bottom" align="center" nowrap="nowrap">BASITEL TELECOMUNICAÇÕES</td>
      <td width="49">&nbsp;</td>
    </tr>
    
    <tr bgcolor="#3366CC">
      <td height="31" colspan="3" id="tagline" valign="top" align="center">SISTEMA ADMINISTRATIVO</td>
	  <td width="49">&nbsp;</td>
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
      <td width="157" valign="top" bgcolor="#F0F0F0">
        <div align="center">
          <table width="149" height="304" border="0" align="left" cellpadding="0" cellspacing="0" id="navigation">
            <tr>
              <td width="161" height="94" bgcolor="#F0F0F0"><div align="center"><br />
                  &nbsp;<strong>GERENCIAMENTO DE CONTRATOS</strong><br />
              </div></td>
            </tr>
            <tr>
              <td width="161" height="64" bgcolor="#F0F0F0"><a href="cadCont.php">INCLUIR</a></td>
            </tr>
            <tr>
              <td width="161" bgcolor="#F0F0F0"><a href="buscaCont.php">ALTERAR</a></td>
            </tr>
            <tr>
              <td width="161" bgcolor="#F0F0F0"><a href="relCont.php">EXIBIR</a></td>
            </tr>
            <tr>
              <td width="161" bgcolor="#F0F0F0"><a href="javascript:;" class="navText">FILTRAR</a></td>
            </tr>
            <tr>
              <td width="161" bgcolor="#F0F0F0"><a href="javascript:;" class="navText">CONTATO</a></td>
            </tr>
          </table> 
	      <br />
          &nbsp;<br />
          &nbsp;<br />
          &nbsp;<br /> 	
        </div></td>
      <td colspan="5" valign="top"><br />
        <table width="100%" border="0">
          <tr>
            <th scope="col">GERENCIAMENTO DE CONTRATOS</th>
        </tr>
        </table>
	  <br />
        <table width="100%" border="0">
          <tr>
            <th scope="col">CADASTRO</th>
        </tr>
        </table>
	  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
	    <table width="1054" border="1" align="center">
	      <tr valign="baseline">
	        <td width="95" align="right" valign="middle" nowrap="nowrap">Nº CONTRATO:</td>
            <td width="245" valign="middle"><input name="numCont" type="text" id="numCont" value="" size="32" /></td>
            <td width="83" align="right" valign="middle">CLIENTE:</td>
            <td width="245" valign="middle"><input type="text" name="cliente" value="" size="32" /></td>
            <td width="113">DATA INÍCIOi:</td>
            <td width="245"><input type="text" name="dataIni" value="" size="12" /></td>
          </tr>
	      <tr valign="baseline">
	        <td rowspan="2" align="right" valign="middle" nowrap="nowrap">ADITIVOS:</td>
            <td rowspan="2" valign="middle"><textarea name="aditivos" cols="32" rows="4"></textarea></td>
            <td rowspan="2" align="right" valign="middle">OBJETO:</td>
            <td rowspan="2"><textarea name="objeto" cols="32" rows="4"></textarea></td>
            <td height="44" align="right" valign="middle">DATA 1º VCTO:</td>
            <td height="44" valign="middle"><input type="text" name="dataFim" value="" size="12" /></td>
          </tr>
	      <tr valign="baseline">
	        <td height="31" align="right" valign="middle">PRÓXIMO VCTO:</td>
            <td valign="middle"><input type="text" name="proxVcto" value="" size="12" /></td>
          </tr>
	      <tr valign="middle">
	        <td align="right" nowrap="nowrap">CONTATO 1:</td>
            <td><textarea name="cont1" cols="32" rows="4"></textarea></td>
            <td align="right">CONTATO 2:</td>
            <td><textarea name="cont2" cols="32" rows="4"></textarea></td>
            <td align="right">CONTATO 3:</td>
            <td><textarea name="cont3" cols="32" rows="4"></textarea></td>
          </tr>
	      <tr valign="baseline">
	        <td align="right" valign="middle" nowrap="nowrap">FISCAL:</td>
            <td><textarea name="fiscal" cols="32" rows="4"></textarea></td>
            <td align="right" valign="middle" nowrap="nowrap">GESTOR ADM:</td>
            <td><textarea name="gestor" cols="32" rows="4"></textarea></td>
            <td align="right" valign="middle">DOCS PARA NFE:</td>
            <td valign="middle"><textarea name="docs" cols="32" rows="4"></textarea></td>
          </tr>
	      <tr valign="baseline">
	        <td align="right" valign="middle" nowrap="nowrap">OBSERVAÇÕES:</td>
            <td><textarea name="obs" cols="32" rows="4"></textarea></td>
            <td align="right" valign="middle">VALOR:</td>
            <td valign="middle"><input type="text" name="valor" value="" size="32" /></td>
            <td colspan="2">&nbsp;</td>
          </tr>
	      
	      <tr valign="baseline">
	        <td nowrap="nowrap" align="right">&nbsp;</td>
            <td colspan="5"><input type="submit" value="CADASTRAR CONTRATO" /></td>
          </tr>
	      </table>
        <input type="hidden" name="MM_insert" value="form1" />
	    </form>
      <p>&nbsp;</p>
      <br />
      &nbsp;<br /></td>
      <td width="49">&nbsp;</td>
    </tr>
    
    <tr>
      <td width="157">&nbsp;</td>
      <td width="180">&nbsp;</td>
      <td width="6">&nbsp;</td>
      <td width="889">&nbsp;</td>
      <td width="60">&nbsp;</td>
      <td width="240">&nbsp;</td>
	  <td width="49">&nbsp;</td>
    </tr>
  </table>
</div>
</body>
</html>
