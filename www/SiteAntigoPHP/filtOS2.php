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

$numos_rsnumos = "1";
if (isset($_POST['txtnumos'])) {
  $numos_rsnumos = $_POST['txtnumos'];
}
mysql_select_db($database_cn1, $cn1);
$query_rsnumos = sprintf("SELECT os.str_OsNum, os.str_OsPref, os.str_OsDep, os.str_cliente, os.str_OsDescProb, os.str_OsPri, os.str_OsTecResp, os.str_OsDataCham, os.str_OsDataIni, os.str_OsDataFim, os.str_OsStatus, os.str_OsObs, os.strNumCont FROM os WHERE os.str_OsNum=%s", GetSQLValueString($numos_rsnumos, "text"));
$rsnumos = mysql_query($query_rsnumos, $cn1) or die(mysql_error());
$row_rsnumos = mysql_fetch_assoc($rsnumos);
$maxRows_rsnumos = 10;
$pageNum_rsnumos = 0;
if (isset($_GET['pageNum_rsnumos'])) {
  $pageNum_rsnumos = $_GET['pageNum_rsnumos'];
}
$startRow_rsnumos = $pageNum_rsnumos * $maxRows_rsnumos;

$totalRows_rsnumos = "1";
if (isset($_POST['txtnumos'])) {
  $totalRows_rsnumos = $_POST['txtnumos'];
}
$numos_rsnumos = "-1";
if (isset($_POST['txtnumos'])) {
  $numos_rsnumos =  $_POST['txtnumos'] ;
}
mysql_select_db($database_cn1, $cn1);
$query_rsnumos = sprintf("SELECT os.str_OsNum, os.str_OsPref, os.str_OsDep, os.str_cliente, os.str_OsDescProb, os.str_OsPri, os.str_OsTecResp, os.str_OsDataCham, os.str_OsDataIni, os.str_OsDataFim, os.str_OsStatus, os.str_OsObs, os.strNumCont FROM os WHERE os.str_OsNum=%s", GetSQLValueString($numos_rsnumos, "text"));
$query_limit_rsnumos = sprintf("%s LIMIT %d, %d", $query_rsnumos, $startRow_rsnumos, $maxRows_rsnumos);
$rsnumos = mysql_query($query_limit_rsnumos, $cn1) or die(mysql_error());
$row_rsnumos = mysql_fetch_assoc($rsnumos);

if (isset($_GET['totalRows_rsnumos'])) {
  $totalRows_rsnumos = $_GET['totalRows_rsnumos'];
} else {
  $all_rsnumos = mysql_query($query_rsnumos);
  $totalRows_rsnumos = mysql_num_rows($all_rsnumos);
}
$totalPages_rsnumos = ceil($totalRows_rsnumos/$maxRows_rsnumos)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>
<!-- Copyright 2005 Macromedia, Inc. All rights reserved. -->
<title>FILTRAR OS</title>
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
.SEL {
	font-size: 14px;
}
.SEL {
	font-size: 12px;
	text-align: center;
}
.SELETOR {
	text-align: center;
}
.SELETOR {
	text-align: center;
}
.sel {
	font-size: 9px;
}
.sel {
	font-weight: bold;
}
sel {
	font-weight: bold;
}
.sel th {
	font-weight: bold;
}
.sel th {
	color: #000000;
	font-weight: bold;
}
.sel {
	font-weight: bold;
}
.sel {
	font-weight: bold;
}
.sel {
	font-weight: normal;
}
-->
</style>
</head>
<body bgcolor="#C0DFFD">
<table width="100%" height="470" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#3366CC">
    <td colspan="3" rowspan="2"><div align="left"><img src="LogoBasitelMenor.png" width="161" height="130" alt="logo basitel menor" /></div></td>
    <td height="63" colspan="3" id="logo" valign="bottom" align="center" nowrap="nowrap">BASITEL TELECOMUNICAÇÕES</td>
    <td width="51">&nbsp;</td>
  </tr>

  <tr bgcolor="#3366CC">
    <td height="31" colspan="3" id="tagline" valign="top" align="center">SISTEMA ADMINISTRATIVO</td>
	<td width="51">&nbsp;</td>
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
    <td width="164" rowspan="2" valign="top" bgcolor="#E6F3FF">
	<table width="161" border="0" align="center" cellpadding="0" cellspacing="0" id="navigation">
        <tr>
          <td width="161">&nbsp;<br />
		 &nbsp;<strong>&nbsp;ORDENS DE SERVIÇO</strong><br /></td>
        </tr>
        <tr>
          <td width="161"><div align="center"><a href="cadOs.php">INCLUIR</a></div></td>
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
  	&nbsp;<br /> 	</td>
    <td height="58" colspan="5" valign="top"><br />
	&nbsp;
	<table width="100%" border="0">
      <tr>
        <th class="SEL" scope="col">SISTEMA DE GERENCIAMENTO DE ORDENS DE SERVIÇO </th>
      </tr>
    </table>
	<br />
	<table width="100%" border="0">
      <tr>
        <th class="SEL" scope="col"><div align="center">OS ENCONTRADA PELO NÚMERO</div></th>
      </tr>
    </table>
	<div align="center">
	  <table width="92%" border="1">
	    <tr bgcolor="#CCFFCC" class="sel">
	      <th scope="col"><span class="SELETOR">NUM OS</span></th>
	      <th scope="col"><span class="SELETOR">PREFIXO</span></th>
	      <th scope="col"><span class="SELETOR">DEPENDÊNCIA</span></th>
	      <th scope="col"><span class="SELETOR">CLIENTE</span></th>
	      <th scope="col"><span class="SELETOR">DESCRIÇÃO</span></th>
	      <th scope="col"><span class="SELETOR">PRIORIDADE</span></th>
	      <th scope="col"><span class="SELETOR">TÉCNICO</span></th>
	      <th scope="col"><span class="SELETOR">DATA DO CHAMADO</span></th>
	      <th scope="col"><span class="SELETOR">INÍCIO ATENDIM</span></th>
	      <th scope="col"><span class="SELETOR">FIM ATENDIM</span></th>
	      <th scope="col"><span class="SELETOR">STATUS</span></th>
	      <th scope="col"><span class="SELETOR">OBSERVAÇÕES</span></th>
	      </tr>
	    <?php do { ?>
	      <tr bgcolor="#CCFFCC" class="sel">
	        <th width="111" scope="col"><strong><?php echo $row_rsnumos['str_OsNum']; ?></strong></th>
	        <th width="121" scope="col"><strong><?php echo $row_rsnumos['str_OsPref']; ?></strong></th>
	        <th width="108" scope="col"><strong><?php echo $row_rsnumos['str_OsDep']; ?></strong></th>
	        <th width="110" scope="col"><strong><?php echo $row_rsnumos['str_cliente']; ?></strong></th>
	        <th width="146" scope="col"><strong><?php echo $row_rsnumos['str_OsDescProb']; ?></strong></th>
	        <th width="136" scope="col"><strong><?php echo $row_rsnumos['str_OsPri']; ?></strong></th>
	        <th width="147" scope="col"><strong><?php echo $row_rsnumos['str_OsTecResp']; ?></strong></th>
	        <th width="140" scope="col"><strong><?php echo $row_rsnumos['str_OsDataCham']; ?></strong></th>
	        <th width="127" scope="col"><strong><?php echo $row_rsnumos['str_OsDataIni']; ?></strong></th>
	        <th width="131" scope="col"><strong><?php echo $row_rsnumos['str_OsDataFim']; ?></strong></th>
	        <th width="149" scope="col"><strong><?php echo $row_rsnumos['str_OsStatus']; ?></strong></th>
	        <th width="236" scope="col"><strong><?php echo $row_rsnumos['str_OsObs']; ?></strong></th>
	        </tr>
	      <?php } while ($row_rsnumos = mysql_fetch_assoc($rsnumos)); ?>
       
      </table>
      <br />
	  &nbsp;<br />
    </div></td>
    <td width="51" rowspan="2">&nbsp;</td>
  </tr>
 <tr>
   <td colspan="5">&nbsp;</td>
 </tr>
  <tr>
    <td width="164">&nbsp;</td>
    <td width="177">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="837">&nbsp;</td>
    <td width="57">&nbsp;</td>
    <td width="286">&nbsp;</td>
	<td width="51">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsnumos);
?>
