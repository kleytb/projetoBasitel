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

$maxRows_recTec = 10;
$pageNum_recTec = 0;
if (isset($_GET['pageNum_recTec'])) {
  $pageNum_recTec = $_GET['pageNum_recTec'];
}
$startRow_recTec = $pageNum_recTec * $maxRows_recTec;

mysql_select_db($database_cn1, $cn1);
$query_recTec = "SELECT * FROM tecnicos";
$query_limit_recTec = sprintf("%s LIMIT %d, %d", $query_recTec, $startRow_recTec, $maxRows_recTec);
$recTec = mysql_query($query_limit_recTec, $cn1) or die(mysql_error());
$row_recTec = mysql_fetch_assoc($recTec);

if (isset($_GET['totalRows_recTec'])) {
  $totalRows_recTec = $_GET['totalRows_recTec'];
} else {
  $all_recTec = mysql_query($query_recTec);
  $totalRows_recTec = mysql_num_rows($all_recTec);
}
$totalPages_recTec = ceil($totalRows_recTec/$maxRows_recTec)-1;

$queryString_recTec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_recTec") == false && 
        stristr($param, "totalRows_recTec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_recTec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_recTec = sprintf("&totalRows_recTec=%d%s", $totalRows_recTec, $queryString_recTec);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>
<!-- Copyright 2005 Macromedia, Inc. All rights reserved. -->
<title>TECNICOS CADASTRADOS</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="mm_travel2.css" type="text/css" />
<link rel="stylesheet" href="mm_travel2.css" type="text/css" />
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
<table width="100%" height="470" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#3366CC">
    <td colspan="3" rowspan="2"><img src="LogoBasitelMenor.png" width="161" height="130" alt="logo basitel menor" /></td>
    <td height="63" colspan="3" id="logo" valign="bottom" align="center" nowrap="nowrap">BASITEL TELECOMUNICAÇÕES</td>
    <td width="114">&nbsp;</td>
  </tr>

  <tr bgcolor="#3366CC">
    <td height="31" colspan="3" id="tagline" valign="top" align="center">SISTEMA ADMINISTRATIVO</td>
	<td width="114">&nbsp;</td>
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
	<table width="161" border="0" align="right" cellpadding="0" cellspacing="0" id="navigation">
        <tr>
          <td width="161">&nbsp;<br />
		 &nbsp;<br /></td>
        </tr>
        <tr>
          <td width="161">&nbsp;</td>
        </tr>
        <tr>
          <td width="161">&nbsp;</td>
        </tr>
        <tr>
          <td width="161">&nbsp;</td>
        </tr>
        <tr>
          <td width="161">&nbsp;</td>
        </tr>
        <tr>
          <td width="161">&nbsp;</td>
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
        <th scope="col">RELAÇÃO DE TÉCNICOS CADASTRADOS</th>
      </tr>
    </table>
	<br />
	&nbsp;
	<table width="100%" border="1">
      <tr>
        <th width="11%" scope="col"><div align="center">ID</div></th>
        <th width="19%" scope="col"><div align="center">NOME</div></th>
        <th width="24%" scope="col"><div align="center">E-MAIL</div></th>
        <th width="16%" scope="col"><div align="center">TEL 1</div></th>
        <th width="13%" scope="col"><div align="center">TEL 2</div></th>
        <th width="17%" scope="col"><div align="center">EMPRESA</div></th>
      </tr>
      <?php do { ?>
        <tr>
          <td><div align="center"><?php echo $row_recTec['int_TecId']; ?></div></td>
          <td><div align="center"><?php echo $row_recTec['str_TecNome']; ?></div></td>
          <td><div align="center"><?php echo $row_recTec['str_TecEmail']; ?></div></td>
          <td><div align="center"><?php echo $row_recTec['str_TecTel1']; ?></div></td>
          <td><div align="center"><?php echo $row_recTec['str_TecTel2']; ?></div></td>
          <td><div align="center"><?php echo $row_recTec['str_TecEmpresa']; ?></div></td>
        </tr>
        <?php } while ($row_recTec = mysql_fetch_assoc($recTec)); ?>
    </table>
	
    <table border="0">
      <tr>
        <td width="237"><?php if ($pageNum_recTec > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_recTec=%d%s", $currentPage, 0, $queryString_recTec); ?>"><img src="First.gif" border="0" /></a>
              <?php } // Show if not first page ?>
        </td>
        <td width="116"><?php if ($pageNum_recTec > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_recTec=%d%s", $currentPage, max(0, $pageNum_recTec - 1), $queryString_recTec); ?>"><img src="Previous.gif" border="0" /></a>
              <?php } // Show if not first page ?>
        </td>
        <td width="117"><?php if ($pageNum_recTec < $totalPages_recTec) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_recTec=%d%s", $currentPage, min($totalPages_recTec, $pageNum_recTec + 1), $queryString_recTec); ?>"><img src="Next.gif" border="0" /></a>
              <?php } // Show if not last page ?>
        </td>
        <td width="114"><?php if ($pageNum_recTec < $totalPages_recTec) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_recTec=%d%s", $currentPage, $totalPages_recTec, $queryString_recTec); ?>"><img src="Last.gif" border="0" /></a>
              <?php } // Show if not last page ?>
        </td>
      </tr>
    </table>
    <br /></td>
    <td width="114" rowspan="2">&nbsp;</td>
  </tr>
 <tr>
   <td colspan="5">&nbsp;</td>
 </tr>
  <tr>
    <td width="165">&nbsp;</td>
    <td width="198">&nbsp;</td>
    <td width="6">&nbsp;</td>
    <td width="886">&nbsp;</td>
    <td width="61">&nbsp;</td>
    <td width="240">&nbsp;</td>
	<td width="114">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($recTec);
?>
