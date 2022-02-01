<?php require_once('Connections/cn1.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "sup,adm,cli";
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

$maxRows_rsOs = 10;
$pageNum_rsOs = 0;
if (isset($_GET['pageNum_rsOs'])) {
  $pageNum_rsOs = $_GET['pageNum_rsOs'];
}
$startRow_rsOs = $pageNum_rsOs * $maxRows_rsOs;

mysql_select_db($database_cn1, $cn1);
$query_rsOs = "SELECT * FROM os";
$query_limit_rsOs = sprintf("%s LIMIT %d, %d", $query_rsOs, $startRow_rsOs, $maxRows_rsOs);
$rsOs = mysql_query($query_limit_rsOs, $cn1) or die(mysql_error());
$row_rsOs = mysql_fetch_assoc($rsOs);

if (isset($_GET['totalRows_rsOs'])) {
  $totalRows_rsOs = $_GET['totalRows_rsOs'];
} else {
  $all_rsOs = mysql_query($query_rsOs);
  $totalRows_rsOs = mysql_num_rows($all_rsOs);
}
$totalPages_rsOs = ceil($totalRows_rsOs/$maxRows_rsOs)-1;

$queryString_rsOs = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsOs") == false && 
        stristr($param, "totalRows_rsOs") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsOs = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsOs = sprintf("&totalRows_rsOs=%d%s", $totalRows_rsOs, $queryString_rsOs);

$currentPage = $_SERVER["PHP_SELF"];

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
<title>OS CADASTRADAS</title>
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
@import url("*");
.style1 {color: #003366}
.SELETOR {
	font-size: 14px;
	text-align: center;
}
.SELETOR {
	font-size: 12px;
}
-->
</style>
</head>
<body bgcolor="#C0DFFD">
<table width="100%" height="357" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#3366CC">
    <td colspan="3" rowspan="2"><img src="LogoBasitelMenor.png" alt="LOGO BASITEL" width="165" height="131" /></td>
    <td height="63" colspan="3" id="logo" valign="bottom" align="center" nowrap="nowrap">BASITEL TELECOMUNICAÇÕES</td>
    <td width="7">&nbsp;</td>
  </tr>

  <tr bgcolor="#3366CC">
    <td height="29" colspan="3" id="tagline" valign="top" align="center">SISTEMA ADMINISTRATIVO</td>
	<td width="7">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="7" bgcolor="#003366"><img src="file:///C|/wamp/mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

  <tr bgcolor="#CCFF99">
  	<td colspan="7" id="dateformat" height="25">&nbsp;&nbsp;
  	  <div align="left">
  	    <script language="JavaScript" type="text/javascript">
      document.write(TODAY);	</script>
    </div></td>
  </tr>
 <tr>
    <td colspan="7" bgcolor="#003366"><img src="file:///C|/wamp/mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

 <tr>
    <td width="169" rowspan="2" align="left" valign="top" bgcolor="#E6F3FF">
	  <div align="left" class="style1">
	    <table width="161" border="0" align="right" cellpadding="0" cellspacing="0" id="navigation">
	      <tr>
	        <td width="161">&nbsp;<br />
            <strong>&nbsp;ORDENS DE SERVIÇO</strong>&nbsp;<br /></td>
          </tr>
	      <tr>
	        <td width="161"><a href="cadOs.php">INCLUIR</a></td>
          </tr>
	      <tr>
	        <td width="161"><a href="buscaOS.php">ALTERAR</a></td>
          </tr>
           <tr>
  	    <td width="161"><a href="excluirOS.php">EXCLUIR</a></td>
	    </tr>
	      <tr>
	        <td width="161"><a href="relOS.php">EXIBIR</a></td>
          </tr>
	     <tr>
          <td width="161" align="left"><div align="left"><a href="filtrar.php" class="navText">FILTRAR</a></div></td>
        </tr>        
	      <tr>
	        <td width="161"><a href="javascript:;" class="navText">CONTATO</a></td>
          <tr>
	        <td width="161"></td>
          </tr>
	      <tr>
	        <td width="161"></a></td>
          </tr>
	      <tr>
	        <td width="161"></td>
          </tr>
	      <tr>
	        <td width="161"></td>
          </tr>
	      <tr>
	        <td width="161"></a></td>
          <tr>
	        <td width="161"></td>
          </tr>
	      <tr>
	        <td width="161"></a></td>
          </tr>
	      <tr>
	        <td width="161"></td>
          </tr>
	      <tr>
	        <td width="161"></td>
          </tr>
	      <tr>
	        <td width="161"></a></td>       
         </tr>
        </table> 
	    <br />
	    &nbsp;<br />
	    &nbsp;<br />
	    &nbsp;<br /> 	
      </div></td>
    <td height="58" colspan="5"><br />
	&nbsp;
	<table width="100%" border="0">
      <tr>
        <th valign="top" class="SELETOR" scope="col">SISTEMA DE GEERENCIAMENTO DE ORDENS DE SERVIÇO</th>
      </tr>
    </table>
	<br />
	<table width="100%" border="0">
      <tr>
        <th class="SELETOR" scope="col">ORDENS DE SERVIÇO CADASTRADAS</th>
      </tr>
    </table>
	<br />
	&nbsp;
	<table width="100%" border="1" align="center" bordercolor="#0066FF">
      <tr>
        <th width="5" bgcolor="#FFFFFF" scope="col">ID</th>
        <th width="7" bgcolor="#FFFFFF" scope="col">NUM OS</th>
        <th width="7" bgcolor="#FFFFFF" scope="col">PREFIXO</th>
        <th width="10" bgcolor="#FFFFFF" scope="col">DEPENDÊNCIA</th>
        <th width="30" bgcolor="#FFFFFF" scope="col">DESCRIÇÃO</th>
        <th width="5" bgcolor="#FFFFFF" scope="col">PRI</th>
        <th width="10" bgcolor="#FFFFFF" scope="col">TÉCNICO</th>
        <th width="10" bgcolor="#FFFFFF" scope="col">DATA CHAM</th>
        <th width="10" bgcolor="#FFFFFF" scope="col">INÌCIO ATEND</th>
        <th width="10" bgcolor="#FFFFFF" scope="col">FIM ATEND</th>
        <th width="15" bgcolor="#FFFFFF" scope="col">STATUS</th>
        <th width="30" bgcolor="#FFFFFF" scope="col">OBSERVAÇÕES</th>
        </tr>
      <?php do { ?>
        <tr>
          <td bgcolor="#FFFFFF"><?php echo $row_rsOs['int_OsId']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsOs['str_OsNum']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsOs['str_OsPref']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsOs['str_OsDep']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsOs['str_OsDescProb']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsOs['str_OsPri']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsOs['str_OsTecResp']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsOs['str_OsDataCham']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsOs['str_OsDataIni']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsOs['str_OsDataFim']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsOs['str_OsStatus']; ?></td>
          <td bgcolor="#FFFFFF"><?php echo $row_rsOs['str_OsObs']; ?></td>
        </tr>
        <?php } while ($row_rsOs = mysql_fetch_assoc($rsOs)); ?>
    </table>
	<div align="center"><br />
    </div></td>
    <td width="7" rowspan="2">&nbsp;</td>
  </tr>
 <tr>
   <td colspan="5" align="center" valign="top">&nbsp;
     <table width="779" border="0" align="center">
       <tr>
         <td width="256"><?php if ($pageNum_rsOs > 0) { // Show if not first page ?>
             <a href="<?php printf("%s?pageNum_rsOs=%d%s", $currentPage, 0, $queryString_rsOs); ?>"><img src="First.gif" /></a>
             <?php } // Show if not first page ?></td>
         <td width="256"><?php if ($pageNum_rsOs > 0) { // Show if not first page ?>
             <a href="<?php printf("%s?pageNum_rsOs=%d%s", $currentPage, max(0, $pageNum_rsOs - 1), $queryString_rsOs); ?>"><img src="Previous.gif" /></a>
             <?php } // Show if not first page ?></td>
         <td width="270"><?php if ($pageNum_rsOs < $totalPages_rsOs) { // Show if not last page ?>
             <a href="<?php printf("%s?pageNum_rsOs=%d%s", $currentPage, min($totalPages_rsOs, $pageNum_rsOs + 1), $queryString_rsOs); ?>"><img src="Next.gif" /></a>
             <?php } // Show if not last page ?></td>
         <td width="329"><?php if ($pageNum_rsOs < $totalPages_rsOs) { // Show if not last page ?>
             <a href="<?php printf("%s?pageNum_rsOs=%d%s", $currentPage, $totalPages_rsOs, $queryString_rsOs); ?>"><img src="Last.gif" /></a>
             <?php } // Show if not last page ?></td>
       </tr>
    </table></td>
 </tr>
  <tr>
    <td width="169">&nbsp;</td>
    <td width="33">&nbsp;</td>
    <td width="4">&nbsp;</td>
    <td width="1087">&nbsp;</td>
    <td width="65">&nbsp;</td>
    <td width="305">&nbsp;</td>
	<td width="7">&nbsp;</td>
  </tr>
</table>
<div align="center"></div>
</body>
</html>
<?php
mysql_free_result($rsOs);
?>
