<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
</head>

<body>

<?php
$email_destino = "gil@basitel.com.br";

if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['avaliacao']) && isset($_POST['sugestoes']))
{
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $avaliacao = $_POST['avaliacao'];
    $sugestoes = $_POST['sugestoes'];
}


$mensagem = "Nome do usuario: $nome\n";
$mensagem .= "E-mail: $email\n";
$mensagem .= "Avaliacao: $avaliacao\n";
$mensagem .= "Mensagem: $sugestoes";
mail($email_destino, "MENSAGEM ENVIADA PELO SITE DA BASITEL", $mensagem, "From:basitel@basitel.com.br","-r contato@basitel.com.br");

echo "Sua mensagem foi enviada com sucesso!";
?>

</body>
</html>