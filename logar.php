<?php
  include ("connect.php");

  $email = $_POST["email"];
  $password = encripta($_POST["password"]);

  $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' AND status=1";
  $exec = mysqli_query($conn, $sql);
  if(mysqli_num_rows($exec) >0){
    $row = mysqli_fetch_array($exec);

    session_start();

    $_SESSION["id"] = $row["id"];
    $_SESSION["name"] = $row["name"];
    $_SESSION["group_id"] = $row["group_id"];
    $_SESSION["email"] = $row["email"];
    $_SESSION["type"] = $row["type"];
    $_SESSION["cpf"] = $row["cpf"];
    $_SESSION["expiration"] = $row["expiration"];
    $_SESSION["status"] = $row["status"];

    echo "<script> window.location='home.php'; </script>";

  }else{
    echo "<script> alert('Usuário ou senha incorretos!'); window.location='login.php'; </script>";
  }
?>
