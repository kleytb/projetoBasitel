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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO os (str_OsNum, str_OsPref, str_OsDep, str_cliente, str_OsDescProb, str_OsPri, str_OsTecResp, str_OsDataCham, str_OsDataIni, str_OsDataFim,  str_OsStatus, str_OsObs, strNumCont) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['str_OsNum'], "text"),
                       GetSQLValueString($_POST['str_OsPref'], "text"),
                       GetSQLValueString($_POST['str_OsDep'], "text"),
					   GetSQLValueString($_POST['str_cliente'], "text"),
                       GetSQLValueString($_POST['str_OsDescProb'], "text"),
                       GetSQLValueString($_POST['str_OsPri'], "text"),
                       GetSQLValueString($_POST['str_OsTecResp'], "text"),
                       GetSQLValueString($_POST['str_OsDataCham'], "date"),
                       GetSQLValueString($_POST['str_OsDataIni'], "date"),
                       GetSQLValueString($_POST['str_OsDataFim'], "date"),                     
                       GetSQLValueString($_POST['str_OsStatus'], "text"),
                       GetSQLValueString($_POST['str_OsObs'], "text"),
					   GetSQLValueString($_POST['strNumCont'], "text"));

  mysql_select_db($database_cn1, $cn1);
  $Result1 = mysql_query($insertSQL, $cn1) or die(mysql_error());

  $insertGoTo = "relOS.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_cn1, $cn1);
$query_RecNomeTec = "SELECT str_TecNome FROM tecnicos";
$RecNomeTec = mysql_query($query_RecNomeTec, $cn1) or die(mysql_error());
$row_RecNomeTec = mysql_fetch_assoc($RecNomeTec);
$totalRows_RecNomeTec = mysql_num_rows($RecNomeTec);

mysql_select_db($database_cn1, $cn1);
$query_rsNCont = "SELECT numCont FROM contratos";
$rsNCont = mysql_query($query_rsNCont, $cn1) or die(mysql_error());
$row_rsNCont = mysql_fetch_assoc($rsNCont);
$totalRows_rsNCont = mysql_num_rows($rsNCont);

mysql_select_db($database_cn1, $cn1);
$query_rs_cli = "SELECT contratos.cliente FROM contratos";
$rs_cli = mysql_query($query_rs_cli, $cn1) or die(mysql_error());
$row_rs_cli = mysql_fetch_assoc($rs_cli);
$totalRows_rs_cli = mysql_num_rows($rs_cli);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>
<!-- Copyright 2005 Macromedia, Inc. All rights reserved. -->
<title>CADASTRO DE OS</title>
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
.style1 {
	color: #000066;
	font-weight: bold;
}
.style2 {color: #003366}
.style3 {
	font-size: 14px;
	color: #3366CC;
}
.style4 {font-size: 12px}
-->
</style>
</head>
<body bgcolor="#C0DFFD">
<table width="100%" height="470" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#3366CC">
    <td colspan="3" rowspan="2"><img src="LogoBasitelMenor.png" alt="logo basitel menor" width="140" height="115" align="left" /></td>
    <td height="63" colspan="3" id="logo" valign="bottom" align="center" nowrap="nowrap">BASITEL TELECOMUNICAÇÕES</td>
    <td width="55">&nbsp;</td>
  </tr>

  <tr bgcolor="#3366CC">
    <td height="31" colspan="3" id="tagline" valign="top" align="center">SISTEMA ADMINISTRATIVO</td>
	<td width="55">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="7" bgcolor="#003366"><img src="../mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

  <tr bgcolor="#CCFF99">
  	<td colspan="7" id="dateformat" height="25"><div align="right"><span class="style4">&nbsp;&nbsp;
  	  </span>
	  </div>
  	  <div align="left">
  	    <script language="JavaScript" type="text/javascript">
      document.write(TODAY);	</script>
      </div></td>
  </tr>
 <tr>
    <td colspan="7" bgcolor="#003366"><img src="../mm_spacer.gif" alt="" width="1" height="1" border="0" /></td>
  </tr>

 <tr>
    <td width="147" rowspan="2" valign="top" bgcolor="#E6F3FF">
	<table width="143" border="0" align="center" cellpadding="0" cellspacing="0" id="navigation">
        <tr>
          <td width="143">&nbsp;<br />
	      <strong>&nbsp;ORDENS DE SERVIÇO</strong>&nbsp;<br /></td>
        </tr>
        <tr>
          <td width="143" align="left"><span id="navigation"><a href="cadOs.php">INCLUIR</a></span></td>
        </tr>
        <tr>
          <td width="143"><span id="navigation"><a href="buscaOS.php">ALTERAR</a></span></td>
        </tr>
          <tr>
          <td width="143"><span id="navigation"><a href="excluirOS.php">EXCLUIR</a></span></td>
        </tr>
        <tr>
          <td width="143"><span id="navigation"><a href="relOS.php">EXIBIR</a></span></td>
        </tr>
        <tr>
          <td width="143"><span id="navigation"><a href="filtrar.php" class="navText">FILTRAR</a></span></td>
        </tr>
        <tr>
          <td width="143"><span id="navigation"><a href="javascript:;" class="navText">CONTATO</a></span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
 	 <br />
 	 <br />
  	&nbsp;<br />
  	&nbsp;<br /> 	</td>
    <td height="58" colspan="5" align="right"><br />
	&nbsp;
	<table width="100%" border="0">
      <tr>
        <th scope="col"><div align="center"><span class="style3">GERENCIAMENTO DE ORDENS DE SERVIÇO </span></div></th>
      </tr>
    </table>
	<br />
	<table width="100%" border="0">
      <tr>
        <th scope="col"><div align="center"><span class="style4">CADASTRO </span></div></th>
      </tr>
    </table>
	<br />
    
  


	<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <div align="left">
        <table width="82%" border="1" align="right">
          <tr valign="baseline">
            <td width="154" height="25" align="right" valign="middle" nowrap="nowrap"><div align="right"><strong>NÚMERO OS:</strong></div></td>
          <td width="143"><input name="str_OsNum" type="text" size="20" /></td>
          <td width="203" align="right" nowrap="nowrap"><div align="right"><strong>PREF AG:</strong></div></td>
          <td width="140"><div align="left">
            <input type="text" name="str_OsPref" value="" size="20" />
          </div></td>
          <td width="128" align="right" nowrap="nowrap"><div align="right"><strong>AG:</strong></div></td>
          <td width="153"><div align="left">
            <input type="text" name="str_OsDep" value="" size="20" />
          </div></td>
        </tr>
          <tr valign="baseline">
            <td height="85" align="right" valign="middle" nowrap="nowrap"><div align="right"><strong>DESC PROB:</strong></div></td>
          <td colspan="3">
            <div align="left">
              <textarea name="str_OsDescProb" cols="65" rows="5"></textarea>
            </div></td>
          <td valign="middle"><div align="right"><strong>PRIORIDADE:</strong></div></td>
          <td valign="middle">
            <div align="left">
              <select name="str_OsPri">
                <option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>0</option>
                <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>1</option>
                <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>2</option>
              </select>
            </div></td>
        </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap"><strong>TECNICO RESPONSÁVEL:</strong></td>
          <td colspan="5"><div align="left">
            <select name="str_OsTecResp">
              <?php 
do {  
?>
              <option value="<?php echo $row_RecNomeTec['str_TecNome']?>" <?php if (!(strcmp($row_RecNomeTec['str_TecNome'], $row_RecNomeTec['str_TecNome']))) {echo "SELECTED";} ?>><?php echo $row_RecNomeTec['str_TecNome']?></option>
              <?php
} while ($row_RecNomeTec = mysql_fetch_assoc($RecNomeTec));
?>
            </select>
          </div></td>
        </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right" valign="middle"><div align="right"><strong>DATA/HORA CHAMADO:</strong></div></td>
            <td><input name="str_OsDataCham" type="text" size="20" /></td>
            <td><div align="right"><strong>DATA/HORA  INÍCIO  ATENDIMENTO:</strong></div></td>
          <td><div align="left">
            <input name="str_OsDataIni" type="text" size="20" />
          </div></td>
          <td><div align="right"><strong>DATA/HORA FIM ATENDIM:</strong></div></td>
          <td><div align="left">
            <input name="str_OsDataFim" type="text" size="20" />
          </div></td>
        </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap"><div align="right"><strong>STATUS:</strong></div></td>
          <td colspan="3">
            <div align="left">
              <select name="str_OsStatus">
                <option value="Em atendimento">EM ATENDIMENTO</option>
                <option value="Solucionada no prazo">SOLUCIONADA NO PRAZO</option>
                <option value="Solucionada fora do prazo">SOLUCIONADA FORA DO PRAZO</option>
                <option value="Não solucionada">NÃO SOLUCIONADA</option>
              </select>
            </div></td>
          <td valign="middle"><div align="right" class="style1 style2">CLIENTE:</div></td>
          <td><div align="left">
            <select name="str_cliente" id="str_cliente">
              <?php
do {  
?>
              <option value="<?php echo $row_rs_cli['cliente']?>"<?php if (!(strcmp($row_rs_cli['cliente'], $row_rs_cli['cliente']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs_cli['cliente']?></option>
              <?php
} while ($row_rs_cli = mysql_fetch_assoc($rs_cli));
  $rows = mysql_num_rows($rs_cli);
  if($rows > 0) {
      mysql_data_seek($rs_cli, 0);
	  $row_rs_cli = mysql_fetch_assoc($rs_cli);
  }
?>
            </select>
          </div></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap"><div align="right"><strong>OBS:</strong></div></td>
          <td colspan="3"><div align="left">
            <textarea name="str_OsObs" cols="65" rows="5"></textarea>
          </div></td>
          <td valign="middle"><div align="right"><strong>NÚMERO DO CONTRATO</strong></div></td>
          <td valign="middle"><div align="left">
            <select name="strNumCont" id="strNumCont">
              <?php
do {  
?>
              <option value="<?php echo $row_rsNCont['numCont']?>"<?php if (!(strcmp($row_rsNCont['numCont'], $row_rsNCont['numCont']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsNCont['numCont']?></option>
              <?php
} while ($row_rsNCont = mysql_fetch_assoc($rsNCont));
  $rows = mysql_num_rows($rsNCont);
  if($rows > 0) {
      mysql_data_seek($rsNCont, 0);
	  $row_rsNCont = mysql_fetch_assoc($rsNCont);
  }
?>
            </select>
          </div></td>
        </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
          <td colspan="5"><div align="left">
            <input type="submit" value="CADASTRAR OS" />
          </div></td>
        </tr>
        </table>
        <div align="right"></div>
        <label for="strNumCont"></label>
        <input type="hidden" name="MM_insert" value="form1" />
      </div>
	</form>
<p>&nbsp;</p>
<br /></td>
    <td width="55" rowspan="2">&nbsp;</td>
  </tr>
 <tr>
   <td colspan="5">&nbsp;</td>
 </tr>
  <tr>
    <td width="147">&nbsp;</td>
    <td width="201">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="879">&nbsp;</td>
    <td width="57">&nbsp;</td>
    <td width="237">&nbsp;</td>
	<td width="55">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($RecNomeTec);

mysql_free_result($rsNCont);

mysql_free_result($rs_cli);
?>
