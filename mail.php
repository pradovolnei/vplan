<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include ("connect.php");
    $nome = htmlspecialchars($_POST["nome"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $assunto = htmlspecialchars($_POST["assunto"]);
    $mensagem = nl2br(htmlspecialchars($_POST["mensagem"]));

    $destinatario = "prado.volnei@gmail.com"; // E-mail da central
    $assunto_email = "[Contato] $assunto - $nome";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $email" . "\r\n";

    $corpo_email = "
    <html>
    <head>
        <title>Contato via Site</title>
    </head>
    <body>
        <h2 style='background:#007bff; color:white; padding:10px; text-align:center;'>Nova Mensagem de Contato</h2>
        <p><strong>Nome:</strong> $nome</p>
        <p><strong>E-mail:</strong> $email</p>
        <p><strong>Assunto:</strong> $assunto</p>
        <p><strong>Mensagem:</strong></p>
        <p style='border:1px solid #ddd; padding:10px;'>$mensagem</p>
        <hr>
        <p style='text-align:center;'>Este e-mail foi enviado através do formulário de contato do site.</p>
    </body>
    </html>
    ";

    // Enviar e-mail para a central
    mail($destinatario, $assunto_email, $corpo_email, $headers);

    // Enviar cópia para o usuário
    $headers_user = "MIME-Version: 1.0" . "\r\n";
    $headers_user .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers_user .= "From: central@seudominio.com" . "\r\n";

    $corpo_usuario = "
    <html>
    <head>
        <title>Confirmação de Contato</title>
    </head>
    <body>
        <h2 style='background:#007bff; color:white; padding:10px; text-align:center;'>Confirmação de Contato</h2>
        <p>Olá, $nome!</p>
        <p>Recebemos sua mensagem com o assunto <strong>$assunto</strong>.</p>
        <p>Em breve, nossa equipe entrará em contato.</p>
        <p><strong>Sua mensagem:</strong></p>
        <p style='border:1px solid #ddd; padding:10px;'>$mensagem</p>
        <hr>
        <p style='text-align:center; font-weight: bold;'>Obrigado por entrar em contato conosco!</p>
        <p style='font-weight: bold;'> Equipe V-Plan </p>
        <p style='font-weight: bold;'> Razão Social VOLNEI LUIZ CAMPOS PRADO </p>
        <p style='font-weight: bold;'> 40.905.140/0001-23 </p>
    </body>
    </html>
    ";

    mail($email, "Confirmação de Contato", $corpo_usuario, $headers_user);

    $sql = "INSERT INTO called VALUES(NULL, '$nome', '$email', '$assunto', '$mensagem', 1, NOW(), NULL)";
    mysqli_query($conn, $sql);

    echo "<script> window.location.href='index.php?c#fale-conosco';</script>";
} else {
    echo "<script>alert('Erro ao enviar mensagem.'); window.location.href='index.php';</script>";
}
?>
