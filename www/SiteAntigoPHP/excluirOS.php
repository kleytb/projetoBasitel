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

$currentPage = $_SERVER["PHP_SELF"];

if ((isset($_GET['int_OsId'])) && ($_GET['int_OsId'] != "")) {
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

$maxRows_rsexc = 10;
$pageNum_rsexc = 0;
if (isset($_GET['pageNum_rsexc'])) {
  $pageNum_rsexc = $_GET['pageNum_rsexc'];
}
$startRow_rsexc = $pageNum_rsexc * $maxRows_rsexc;

mysql_select_db($database_cn1, $cn1);
$query_rsexc = "SELECT * FROM os";
$query_limit_rsexc = sprintf("%s LIMIT %d, %d", $query_rsexc, $startRow_rsexc, $maxRows_rsexc);
$rsexc = mysql_query($query_limit_rsexc, $cn1) or die(mysql_error());
$row_rsexc = mysql_fetch_assoc($rsexc);

if (isset($_GET['totalRows_rsexc'])) {
  $totalRows_rsexc = $_GET['totalRows_rsexc'];
} else {
  $all_rsexc = mysql_query($query_rsexc);
  $totalRows_rsexc = mysql_num_rows($all_rsexc);
}
$totalPages_rsexc = ceil($totalRows_rsexc/$maxRows_rsexc)-1;

$queryString_rsexc = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsexc") == false && 
        stristr($param, "totalRows_rsexc") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsexc = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsexc = sprintf("&totalRows_rsexc=%d%s", $totalRows_rsexc, $queryString_rsexc);

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
<title>EXCLUSÃO DE OS</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="mm_travel2.css" type="text/css" />

<script language="JavaScript" type="text/javascript">

function confirmaExclusao( url )
{
if ( window.confirm( "Confirma a exclusão?" ) ) window.location.href=url;
}

</script>
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
.style2 {
	font-size: 14px;
	text-align: center;
}
.style3 {
	font-size: 12px;
	color: #3366CC;
	text-align: center;
}
.style4 {color: #FF0000}
.style5 {
	font-size: x-large;
	color: #FF0000;
}
-->
</style>
</head>
<body bgcolor="#C0DFFD">
<table width="100%" height="357" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#3366CC">
    <td colspan="2" rowspan="2"><img src="LogoBasitelMenor.png" alt="LOGO BASITEL" width="165" height="131" /></td>
    <td height="63" id="logo" valign="bottom" align="center" nowrap="nowrap">BASITEL TELECOMUNICAÇÕES</td>
    <td width="5">&nbsp;</td>
  </tr>

  <tr bgcolor="#3366CC">
    <td height="29" id="tagline" valign="top" align="center">SISTEMA ADMINISTRATIVO</td>
	<td width="5">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="5" bgcolor="#003366"><img src="file:///C|/wamp/mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

  <tr bgcolor="#CCFF99">
  	<td colspan="5" id="dateformat" height="25">&nbsp;&nbsp;
  	  <div align="left">
  	    <script language="JavaScript" type="text/javascript">
      document.write(TODAY);	</script>
      </div></td>
  </tr>
 <tr>
    <td colspan="5" bgcolor="#003366"><img src="file:///C|/wamp/mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

 <tr>
    <td width="169" rowspan="2" align="left" valign="top" bgcolor="#E6F3FF">
	  <div align="left">
	    <table width="161" border="0" align="right" cellpadding="0" cellspacing="0" id="navigation">
	      <tr>
	        <td width="161">&nbsp;<br />
            <strong>&nbsp;ORDENS DE SERVIÇO</strong>&nbsp;<br /></td>
          </tr>
	      <tr>
	        <td width="161"><div align="center"><a href="cadOs.php"> INCLUIR</a></div></td>
          </tr>
	      <tr>
	        <td width="161"><div align="center"><a href="buscaOS.php">ALTERAR</a></div></td>
          </tr>
           <tr>
	        <td width="161"><div align="center"><a href="excluirOS.php">EXCLUIR</a></div></td>
          </tr>
	      <tr>
	        <td width="161"><div align="center"><a href="relOS.php">EXIBIR</a></div></td>
          </tr>
	      <tr>
	        <td width="161"><div align="center"><a href="filtrar.php" class="navText">FILTRAR</a></div></td>
          </tr>
	      <tr>
	        <td width="161"><div align="center"><a href="javascript:;" class="navText">CONTATO</a></div></td>
          </tr>
        </table> 
	    <br />
	    &nbsp;<br />
	    &nbsp;<br />
	    &nbsp;<br /> 	
    </div></td>
    <td height="58" colspan="3"><br />
      &nbsp;
      <table width="100%" border="0">
        <tr>
          <th valign="top" scope="col">&nbsp;</th>
          <th valign="top" scope="col"><div align="center"><span class="style2">SISTEMA DE GERENCIAMENTO DE ORDENS DE SERVIÇO</span></div></th>
          <th valign="top" scope="col">&nbsp;</th>
        </tr>
      </table>
      <br />
      <table width="100%" border="0">
        <tr>
          <th height="42" scope="col">&nbsp;</th>
          <th height="42" scope="col"><div align="center"><span class="style3">EXCLUSÃO DE OS </span></div></th>
          <th height="42" scope="col">&nbsp;</th>
        </tr>
        <tr>
          <th width="31%" scope="col">&nbsp;</th>
          <th width="36%" scope="col"><p class="style3"><span class="style3">ATENÇÃO !<br />
          </span><span class="style3">A EXCLUSÃO É IRREVERSÍVEL, CERTIFIQUE-SE DE QUE DESEJA MESMO EXCLUIR A OS ANTES DE CLICAR NO LINK EXCLUIR</span></p></th>
          <th width="33%" scope="col">&nbsp;</th>
        </tr>
      </table>
      <br />
      &nbsp;
      <table width="100%" border="1" align="center" bordercolor="#0066FF">
        <tr bgcolor="#FFFF99">
          <th width="47" height="28" scope="col"><div align="center"><span class="style5">x</span></div></th>
          <th width="48" scope="col"><div align="center">ID</div></th>
          <th width="112" scope="col"><div align="center">NUM CONT</div></th>
          <th width="109" scope="col">CLIENTE</th>
          <th width="109" scope="col">Nº OS</th>
          <th width="148" scope="col">PREFIXO</th>
          <th width="36" scope="col">DEPENDÊNCIA</th>
          <th width="88" scope="col">DESCRIÇÃO</th>
          <th width="62" scope="col">PRIORIDADE</th>
          <th width="75" scope="col">INÍCIO ATEND</th>
          <th width="69" scope="col">FIM ATEND</th>
          <th width="79" scope="col">STATUS</th>
          <th width="75" scope="col">OBSERVAÇÕES</th>
        </tr>
        <?php do { ?>
          <tr bgcolor="#FFFF99">
            <td><div align="center"><a href="excluirOS.php?int_OsId=<?php echo $row_rsexc['int_OsId']; ?>" class="style4">EXCLUIR</a></div></td>
            <td><div align="center"><?php echo $row_rsexc['int_OsId']; ?></div></td>
            <td><div align="center"><?php echo $row_rsexc['strNumCont']; ?></div></td>
            <td><?php echo $row_rsexc['str_cliente']; ?></td>
            <td><?php echo $row_rsexc['str_OsNum']; ?></td>
            <td><?php echo $row_rsexc['str_OsPref']; ?></td>
            <td><?php echo $row_rsexc['str_OsDep']; ?></td>
            <td><?php echo $row_rsexc['str_OsDescProb']; ?></td>
            <td><?php echo $row_rsexc['str_OsPri']; ?></td>
            <td><?php echo $row_rsexc['str_OsDataIni']; ?></td>
            <td><?php echo $row_rsexc['str_OsDataFim']; ?></td>
            <td><?php echo $row_rsexc['str_OsStatus']; ?></td>
            <td><?php echo $row_rsexc['str_OsObs']; ?></td>
          </tr>
          <?php } while ($row_rsexc = mysql_fetch_assoc($rsexc)); ?>
      </table>
    </td>
    <td width="5" rowspan="2">&nbsp;</td>
  </tr>
 <tr>
   <td colspan="3" align="center" valign="top">&nbsp;
     <table width="631" border="0">
       <tr>
         <td width="184"><?php if ($pageNum_rsexc > 0) { // Show if not first page ?>
               <a href="<?php printf("%s?pageNum_rsexc=%d%s", $currentPage, 0, $queryString_rsexc); ?>"><img src="First.gif" border="0" /></a>
               <?php } // Show if not first page ?>
         </td>
         <td width="184"><?php if ($pageNum_rsexc > 0) { // Show if not first page ?>
               <a href="<?php printf("%s?pageNum_rsexc=%d%s", $currentPage, max(0, $pageNum_rsexc - 1), $queryString_rsexc); ?>"><img src="Previous.gif" border="0" /></a>
               <?php } // Show if not first page ?>
         </td>
         <td width="126"><?php if ($pageNum_rsexc < $totalPages_rsexc) { // Show if not last page ?>
               <a href="<?php printf("%s?pageNum_rsexc=%d%s", $currentPage, min($totalPages_rsexc, $pageNum_rsexc + 1), $queryString_rsexc); ?>"><img src="Next.gif" border="0" /></a>
               <?php } // Show if not last page ?>
         </td>
         <td width="119"><?php if ($pageNum_rsexc < $totalPages_rsexc) { // Show if not last page ?>
               <a href="<?php printf("%s?pageNum_rsexc=%d%s", $currentPage, $totalPages_rsexc, $queryString_rsexc); ?>"><img src="Last.gif" border="0" /></a>
               <?php } // Show if not last page ?>
         </td>
       </tr>
     </table></td>
 </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    <td width="5">&nbsp;</td>
  </tr>
</table>
<div align="center"></div>
</body>
</html>
<?php
mysql_free_result($rsexc);
?>
