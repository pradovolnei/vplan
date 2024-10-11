<?php
  include ("connect.php");

  if($_POST["password"] != $_POST["password2"]){
    echo "<script> alert('Senhas diferentes!'); history.go(-1); </script>";
    die();
  }

  $nome = $_POST["name"];
  $email = $_POST["email"];
  $password = encripta($_POST["password"]);
  $cpf = $_POST["cpf"];
  $grupo = $_POST["grupo"];

  $sqlVerif = "SELECT * FROM users WHERE email='$email'";
  $execVerif = mysqli_query($conn, $sqlVerif);
  if(mysqli_num_rows($execVerif) > 0){
    echo "<script> alert('Esse email já está sendo usado por outro usuário!'); history.go(-1); </script>";
    die();
  }

  $sqlInsert = "INSERT INTO users (name, group_id, type, email, password, status, cpf, created_at)
                  VALUES ('$nome', $grupo, 1, '$email', '$password', 1, '$cpf', NOW())";
  mysqli_query($conn, $sqlInsert);

  echo "<script> alert('Usuário cadastrado com sucesso!'); window.location='login.php'; </script>";

?>
