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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsCt = 10;
$pageNum_rsCt = 0;
if (isset($_GET['pageNum_rsCt'])) {
  $pageNum_rsCt = $_GET['pageNum_rsCt'];
}
$startRow_rsCt = $pageNum_rsCt * $maxRows_rsCt;

mysql_select_db($database_cn1, $cn1);
$query_rsCt = "SELECT contratos.id, contratos.numCont, contratos.cliente, contratos.objeto, contratos.dataIni, contratos.dataFim, contratos.aditivos, contratos.proxVcto, contratos.cont1, contratos.cont2, contratos.cont3, contratos.fiscal, contratos.gestor, contratos.docs, contratos.obs, contratos.valor FROM contratos";
$query_limit_rsCt = sprintf("%s LIMIT %d, %d", $query_rsCt, $startRow_rsCt, $maxRows_rsCt);
$rsCt = mysql_query($query_limit_rsCt, $cn1) or die(mysql_error());
$row_rsCt = mysql_fetch_assoc($rsCt);

if (isset($_GET['totalRows_rsCt'])) {
  $totalRows_rsCt = $_GET['totalRows_rsCt'];
} else {
  $all_rsCt = mysql_query($query_rsCt);
  $totalRows_rsCt = mysql_num_rows($all_rsCt);
}
$totalPages_rsCt = ceil($totalRows_rsCt/$maxRows_rsCt)-1;

$queryString_rsCt = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsCt") == false && 
        stristr($param, "totalRows_rsCt") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsCt = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsCt = sprintf("&totalRows_rsCt=%d%s", $totalRows_rsCt, $queryString_rsCt);

$queryString_RecOs = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecOs") == false && 
        stristr($param, "totalRows_RecOs") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecOs = "&" . htmlentities(implode("&", $newParams));
  }
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>
<!-- Copyright 2005 Macromedia, Inc. All rights reserved. -->
<title>CONTRATOS CADASTRADOS</title>
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
.style1 {color: #003366}
-->
</style>
</head>
<body bgcolor="#C0DFFD">
<table width="100%" height="357" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#3366CC">
    <td colspan="3" rowspan="2"><img src="LogoBasitelMenor.png" alt="LOGO BASITEL" width="165" height="131" /></td>
    <td height="63" colspan="3" id="logo" valign="bottom" align="center" nowrap="nowrap">BASITEL TELECOMUNICAÇÕES</td>
    <td width="5">&nbsp;</td>
  </tr>

  <tr bgcolor="#3366CC">
    <td height="29" colspan="3" id="tagline" valign="top" align="center">SISTEMA ADMINISTRATIVO</td>
	<td width="5">&nbsp;</td>
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
    <td width="165" rowspan="2" align="left" valign="top" bgcolor="#E6F3FF">
	  <div align="left">
	    <table width="161" border="0" align="right" cellpadding="0" cellspacing="0" id="navigation">
	      <tr>
	        <td width="161" bgcolor="#F0F0F0"height="92"><div align="center"><strong>GERENCIAMENTO DE CONTRATOS</strong></div></td>
          </tr>
	      <tr>
	        <td width="161" bgcolor="#F0F0F0"><a href="cadCont.php">INCLUIR</a></td>
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
    <td height="58" colspan="5"><table width="100%" border="0">
      <tr>
        <th valign="top" scope="col"><a href="file:///C|/wamp/www/cadOs.php" class="style1">GERENCIAMENTO DE CONTRATOS</a></th>
      </tr>
    </table>
	<br />
	<table width="100%" border="0">
      <tr>
        <th scope="col">CONTRATOS CADASTRADOS</th>
      </tr>
    </table>
	<br />
	&nbsp;
	<table width="100%" border="1" align="center" bordercolor="#0066FF">
      <tr>
        <th width="5" bgcolor="#FFFFFF" scope="col">id</th>
        <th width="15" bgcolor="#FFFFFF" scope="col">NÚM CONT</th>
        <th width="25" bgcolor="#FFFFFF" scope="col">CLIENTE</th>
        <th width="50" bgcolor="#FFFFFF" scope="col">OBJETO</th>
        <th width="10" bgcolor="#FFFFFF" scope="col">INÍCIO</th>
        <th width="10" bgcolor="#FFFFFF" scope="col">TÉRMINO</th>
        <th width="50" bgcolor="#FFFFFF" scope="col">ADITIVOS</th>
        <th width="10" bgcolor="#FFFFFF" scope="col">PROX VCTO</th>
        <th width="50" bgcolor="#FFFFFF" scope="col">CONTATO 1</th>
        <th width="50" bgcolor="#FFFFFF" scope="col">CONTATO 2</th>
        <th width="50" bgcolor="#FFFFFF" scope="col">FISCAL</th>
        <th width="50" bgcolor="#FFFFFF" scope="col">GESTOR</th>
        <th width="65" bgcolor="#FFFFFF" scope="col">DOCUMENTOS</th>
        <th width="50" bgcolor="#FFFFFF" scope="col">OBS</th>
        <th width="15" bgcolor="#FFFFFF" scope="col">VALOR</th>
        </tr>
      <?php do { ?>
        <tr>
            <td bgcolor="#FFFFFF"><?php echo $row_rsCt['id']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsCt['numCont']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsCt['cliente']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsCt['objeto']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsCt['dataIni']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsCt['dataFim']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsCt['aditivos']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsCt['proxVcto']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsCt['cont1']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsCt['cont2']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsCt['fiscal']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsCt['gestor']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsCt['docs']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsCt['obs']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsCt['valor']; ?></td>
        </tr>
        <?php } while ($row_rsCt = mysql_fetch_assoc($rsCt)); ?>
    </table>
	<div align="center"><br />
    </div></td>
    <td width="5" rowspan="2">&nbsp;</td>
  </tr>
 <tr>
   <td colspan="5" align="center">&nbsp;
     <table width="492" border="0" align="left">
       <tr>
         <td width="134"><?php if ($pageNum_rsCt > 0) { // Show if not first page ?>
               <a href="<?php printf("%s?pageNum_rsCt=%d%s", $currentPage, 0, $queryString_rsCt); ?>"><img src="First.gif" border="0" /></a>
               <?php } // Show if not first page ?>         </td>
         <td width="142"><?php if ($pageNum_rsCt > 0) { // Show if not first page ?>
               <a href="<?php printf("%s?pageNum_rsCt=%d%s", $currentPage, max(0, $pageNum_rsCt - 1), $queryString_rsCt); ?>"><img src="Previous.gif" border="0" /></a>
               <?php } // Show if not first page ?>         </td>
         <td width="99"><?php if ($pageNum_rsCt < $totalPages_rsCt) { // Show if not last page ?>
               <a href="<?php printf("%s?pageNum_rsCt=%d%s", $currentPage, min($totalPages_rsCt, $pageNum_rsCt + 1), $queryString_rsCt); ?>"><img src="Next.gif" border="0" /></a>
               <?php } // Show if not last page ?>         </td>
         <td width="99"><?php if ($pageNum_rsCt < $totalPages_rsCt) { // Show if not last page ?>
               <a href="<?php printf("%s?pageNum_rsCt=%d%s", $currentPage, $totalPages_rsCt, $queryString_rsCt); ?>"><img src="Last.gif" border="0" /></a>
               <?php } // Show if not last page ?>         </td>
       </tr>
     </table></td>
 </tr>
   <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td width="5" colspan="5" rowspan="10">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td colspan="5" rowspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
  </tr>
  <tr>
    <td width="165" bgcolor="#F0F0F0">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td colspan="5" rowspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
  </tr>
  <tr>
    <td width="165" bgcolor="#F0F0F0">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td width="5" colspan="5" rowspan="10">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td colspan="5" rowspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
  </tr>
  <tr>
    <td width="165" bgcolor="#F0F0F0">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
    <td colspan="5" rowspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F0F0F0">&nbsp;</td>
  </tr>
  <tr>
    <td width="165" bgcolor="#F0F0F0">&nbsp;</td>
  </tr>
</table>
<div align="center"></div>
</body>
</html>
<?php
mysql_free_result($rsCt);
?>