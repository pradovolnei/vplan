<?php
// Configurações do e-mail
$email_remetente = 'prado.volnei@gmail.com';
$nome_remetente = 'Equipe V-Sheet';
$assunto = 'Recuperação de Senha';

// Recupera dados do POST
$email_destinatario = $_POST['email'];

include ("connect.php");

$sql = "SELECT * FROM users WHERE email='$email_destinatario'";
$exec = mysqli_query($conn, $sql);
if(mysqli_num_rows($exec) > 0){
  $row = mysqli_fetch_array($exec);

  $user_id = $row["id"];
  $status = $row["status"];

  $token = "$user_id - ".date("Y-m-d H:i:s");
  $token_en = md5($token);

  if($status != "1"){
    echo "<script> alert('Encontramos problemas com o seu perfil! Entre em contato com o suporte técnico.'); window.location='index.php'; </script>";
    die();
  }

  $sql_senha = "INSERT INTO reset_senha VALUES(NULL, $user_id, NOW(), '$token_en', 1)";
  mysqli_query($conn, $sql_senha);
}else{
  echo "<script> alert('E-mail não encontrado na nossa base!'); window.location='forgotpassword.php'; </script>";
}

$mensagem = "Esqueceu sua senha? Não se preocupe. Você pode criar uma nova senha.";
$link_recuperacao = "http://localhost/vplan/pass-reset.php?token=".$token_en;

// Cabeçalho do e-mail
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: " . $nome_remetente . " <" . $email_remetente . ">" . "\r\n";

// Corpo do e-mail (HTML com CSS)
$corpo_email = '
<!DOCTYPE html>
<html>
<head>
<title>Recuperação de Senha</title>
<style>
body {
font-family: sans-serif;
line-height: 1.6;
color: #333;
}
.container {
width: 80%;
margin: 0 auto;
padding: 20px;
border: 1px solid #ddd;
}
.header {
background-color: #f0f0f0;
padding: 10px;
text-align: center;
}
.footer {
background-color: #f0f0f0;
padding: 10px;
text-align: center;
}
.button {
background-color: #007bff;
color: white;
padding: 10px 20px;
text-decoration: none;
border-radius: 5px;
}
</style>
</head>
<body>
<div class="container">
<div class="header">
<h1>Recuperação de Senha</h1>
</div>
<p>' . $mensagem . '</p>
<p><a href="' . $link_recuperacao . '" class="button" style="color: #FFF;">Clique aqui para recuperar sua senha</a></p>
<div class="footer">
<p>Este e-mail foi enviado automaticamente. Por favor, não responda.</p>
</div>
</div>
</body>
</html>
';

// Envia o e-mail
if (mail($email_destinatario, $assunto, $corpo_email, $headers)) {
echo "<script> alert('Alteração de senha solicitada! Verifique o seu e-mail.'); window.location='login.php'; </script>";
} else {
echo "Falha ao enviar o e-mail.";
}
?>
