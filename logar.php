<?php
  include ("connect.php");

  $email = $_POST["email"];
  $password = encripta($_POST["password"]);

  $sql = "SELECT u.*, g.expiration FROM users u LEFT JOIN groups g ON g.id = u.group_id WHERE u.email='$email' AND password='$password'";
  $exec = mysqli_query($conn, $sql);
  if(mysqli_num_rows($exec) >0){
    $row = mysqli_fetch_array($exec);

    if($row["status"] == 2)
      echo "<script> alert('Usuário Bloqueado! Entre em contato com a sua gerência!'); window.location='login.php'; </script>";

    if($row["status"] == 3)
      echo "<script> alert('Plano expirado!'); window.location='login.php'; </script>";

    session_start();

    $_SESSION["id"] = $row["id"];
    $_SESSION["name"] = $row["name"];
    $_SESSION["group_id"] = $row["group_id"];
    $_SESSION["email"] = $row["email"];
    $_SESSION["type"] = $row["type"];
    $_SESSION["cpf"] = $row["cpf"];
    $_SESSION["expiration"] = $row["expiration"];
    $_SESSION["status"] = $row["status"];



    $data_atual = new DateTime(date("Y-m-d"));

    $data_expira = new DateTime($row["expiration"]);

    $diferenca = $data_atual->diff($data_expira);

    if ($diferenca->invert) {
      if($row["type"] == 1){
        echo "<script> window.location='home.php?l=".base64_encode(16)."'; </script>";
      }else {
        echo "<script> alert('Conta expirada! Entre em contato com a sua gerência.'); window.location='logout.php'; </script>";
      }

    }

    echo "<script> window.location='home.php'; </script>";

  }else{
    echo "<script> alert('Usuário ou senha incorretos!'); window.location='login.php'; </script>";
  }
?>
