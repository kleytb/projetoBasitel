
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
<title>BUSCAR CONTRATO</title>
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
	        <td width="161">&nbsp;<br />
            &nbsp;<br /></td>
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
	    &nbsp;<br /> 	
      </div></td>
    <td height="58" colspan="5"><br />
	&nbsp;
	<table width="100%" border="0">
      <tr>
        <th valign="top" scope="col"><a href="file:///C|/wamp/www/cadOs.php" class="style1">SISTEMA DE GERENCIAMENTO DE ORDENS DE SERVIÇO DO CONTRATO 2013.7421.2109 MNT CENTRAIS TELEFÔNICAS</a></th>
      </tr>
    </table>
	<br />
	<table width="100%" border="0">
      <tr>
        <th scope="col">ORDENS DE SERVIÇO CADASTRADAS</th>
      </tr>
    </table>
	<br />
	&nbsp;
	<table width="100%" border="1" align="center" bordercolor="#0066FF">
      <tr>
        <th width="5" scope="col">ID</th>
        <th width="7" scope="col">NUM OS</th>
        <th width="7" scope="col">PREFIXO</th>
        <th width="10" scope="col">DEPENDÊNCIA</th>
        <th width="30" scope="col">DESCRIÇÃO</th>
        <th width="5" scope="col">PRI</th>
        <th width="10" scope="col">TÉCNICO</th>
        <th width="10" scope="col">DATA CHAM</th>
        <th width="10" scope="col">INÌCIO ATEND</th>
        <th width="10" scope="col">FIM ATEND</th>
        <th width="15" scope="col">STATUS</th>
        <th width="30" scope="col">OBSERVAÇÕES</th>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
</table>
	<div align="center"><br />
    </div></td>
    <td width="5" rowspan="2">&nbsp;</td>
  </tr>
 <tr>
   <td colspan="5" align="center">&nbsp;
     <table border="0">
       <tr>
         <td width="370"><img src="file:///C|/wamp/www/First.gif" border="0" /> </td>
         <td width="246"><img src="file:///C|/wamp/www/Previous.gif" border="0" /> </td>
       <td width="204"><img src="file:///C|/wamp/www/Next.gif" border="0" /> </td>
       <td width="359"><img src="file:///C|/wamp/www/Last.gif" border="0" /> </td>
       </tr>
     </table></td>
 </tr>
  <tr>
    <td width="165">&nbsp;</td>
    <td width="34">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="1078">&nbsp;</td>
    <td width="65">&nbsp;</td>
    <td width="303">&nbsp;</td>
	<td width="5">&nbsp;</td>
  </tr>
</table>
<div align="center"></div>
</body>
</html>