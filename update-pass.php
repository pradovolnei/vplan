<?php
  include ("connect.php");

  $email = $_POST["email"];
  $token = $_POST["token"];
  $senha = encripta($_POST["password"]);

  $sql = "UPDATE users SET `password`='$senha', updated_at=NOW() WHERE email='$email'";
  mysqli_query($conn, $sql);

  $sqlU = "UPDATE reset_senha SET `status`=2 WHERE token='$token'";
  mysqli_query($conn, $sql);

  echo "<script> alert('Senha atualizada com sucesso!'); window.location='login.php'; </script>";
?>
