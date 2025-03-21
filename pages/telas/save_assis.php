<?php
  $nome = $_POST["nome"];
  $group = $_POST["group"];
  $email = $_POST["email"];
  $permissao = $_POST["permissao"];
  $senha = encripta($_POST["senha"]);
  $cpf = $_POST["cpf"];

  $sql = "INSERT INTO users VALUES (NULL, '$nome', $group, $permissao, '$email', '$senha', 1, '$cpf', NOW(), NULL, NULL)";
  mysqli_query($conn, $sql);

  echo "<script> window.location='?l=".base64_encode(16)."'; </script>";
?>
