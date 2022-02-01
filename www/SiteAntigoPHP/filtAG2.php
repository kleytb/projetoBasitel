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

$ag_rsag = "1";
if (isset($_POST['txtag'])) {
  $ag_rsag = $_POST['txtag'];
}
mysql_select_db($database_cn1, $cn1);
$query_rsag = sprintf("SELECT os.int_OsId, os.str_OsNum, os.str_OsPref, os.str_OsDep, os.str_cliente, os.str_OsDescProb, os.str_OsPri, os.str_OsTecResp, os.str_OsDataCham, os.str_OsDataIni, os.str_OsDataFim, os.str_OsStatus, os.str_OsObs, os.strNumCont FROM os WHERE os.str_OsDep=%s", GetSQLValueString($ag_rsag, "text"));
$rsag = mysql_query($query_rsag, $cn1) or die(mysql_error());
$row_rsag = mysql_fetch_assoc($rsag);
$totalRows_rsag = mysql_num_rows($rsag);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>
<!-- Copyright 2005 Macromedia, Inc. All rights reserved. -->
<title>FILTRAR AG</title>
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
.SEL table tr td {
	font-size: 9px;
}
.SEL table {
	font-size: 10px;
}
-->
</style>
</head>
<body bgcolor="#C0DFFD">
<table width="100%" height="470" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#3366CC">
    <td colspan="3" rowspan="2"><div align="left"><img src="LogoBasitelMenor.png" width="161" height="130" alt="logo basitel menor" /></div></td>
    <td height="63" colspan="3" id="logo" valign="bottom" align="center" nowrap="nowrap">BASITEL TELECOMUNICAÇÕES</td>
    <td width="4">&nbsp;</td>
  </tr>

  <tr bgcolor="#3366CC">
    <td height="31" colspan="3" id="tagline" valign="top" align="center">SISTEMA ADMINISTRATIVO</td>
	<td width="4">&nbsp;</td>
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
    <td width="161" rowspan="2" valign="top" bgcolor="#E6F3FF">
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
    <td height="58" colspan="5"><br />
	&nbsp;
	<table width="100%" border="0">
      <tr>
        <th class="SEL" scope="col">SISTEMA DE GERENCIAMENTO DE ORDENS DE SERVIÇO </th>
      </tr>
    </table>
	<br />
	<table width="100%" border="0">
      <tr>
        <th class="SEL" scope="col"><div align="center">OS ENCONTRADA PELA DEPENDÊNCIA</div></th>
      </tr>
      <tr>
        <th class="SEL" scope="col"><table width="100%" border="1">
          <tr>
            <th width="8%" bgcolor="#CCFFFF" scope="col">ID</th>
            <th width="9%" bgcolor="#CCFFFF" scope="col">NUM OS</th>
            <th width="9%" bgcolor="#CCFFFF" scope="col">PREFIXO</th>
            <th width="9%" bgcolor="#CCFFFF" scope="col">AGÊNCIA</th>
            <th width="14%" bgcolor="#CCFFFF" scope="col">DESCRIÇÃO</th>
            <th width="8%" bgcolor="#CCFFFF" scope="col">PRIORIDADE</th>
            <th width="5%" bgcolor="#CCFFFF" scope="col">TÉCNICO</th>
            <th width="7%" bgcolor="#CCFFFF" scope="col">DATA CHAMADO</th>
            <th width="6%" bgcolor="#CCFFFF" scope="col">INÍCIO ATEND</th>
            <th width="6%" bgcolor="#CCFFFF" scope="col">FIM ATENDIM</th>
            <th width="5%" bgcolor="#CCFFFF" scope="col">STATUS</th>
            <th width="14%" bgcolor="#CCFFFF" scope="col">OBSERVAÇÕES</th>
          </tr>
          <?php do { ?>
            <tr>
              <td bgcolor="#CCFFFF"><?php echo $row_rsag['int_OsId']; ?></td>
              <td bgcolor="#CCFFFF"><?php echo $row_rsag['str_OsNum']; ?></td>
              <td bgcolor="#CCFFFF"><?php echo $row_rsag['str_OsPref']; ?></td>
              <td bgcolor="#CCFFFF"><?php echo $row_rsag['str_OsDep']; ?></td>
              <td bgcolor="#CCFFFF"><?php echo $row_rsag['str_OsDescProb']; ?></td>
              <td bgcolor="#CCFFFF"><?php echo $row_rsag['str_OsPri']; ?></td>
              <td bgcolor="#CCFFFF"><?php echo $row_rsag['str_OsTecResp']; ?></td>
              <td bgcolor="#CCFFFF"><?php echo $row_rsag['str_OsDataCham']; ?></td>
              <td bgcolor="#CCFFFF"><?php echo $row_rsag['str_OsDataIni']; ?></td>
              <td bgcolor="#CCFFFF"><?php echo $row_rsag['str_OsDataFim']; ?></td>
              <td bgcolor="#CCFFFF"><?php echo $row_rsag['str_OsStatus']; ?></td>
              <td bgcolor="#CCFFFF"><?php echo $row_rsag['str_OsObs']; ?></td>
            </tr>
            <?php } while ($row_rsag = mysql_fetch_assoc($rsag)); ?>
        </table></th>
      </tr>
    </table>
	<div align="center">
	  <p>&nbsp;</p>
	  <br />
	  &nbsp;<br />
    </div></td>
    <td width="4" rowspan="2">&nbsp;</td>
  </tr>
 <tr>
   <td colspan="5">&nbsp;</td>
 </tr>
  <tr>
    <td width="161">&nbsp;</td>
    <td width="222">&nbsp;</td>
    <td width="4">&nbsp;</td>
    <td width="1051">&nbsp;</td>
    <td width="72">&nbsp;</td>
    <td width="285">&nbsp;</td>
	<td width="4">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsag);
?>
