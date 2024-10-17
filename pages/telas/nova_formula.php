<?php
  $id_plan = $_POST["id"];
  $formula = $_POST["formula"];
  $nome_coluna = $_POST["nome_coluna"];

  $sql = "INSERT INTO formulas VALUES(NULL, '$formula', $id_plan, '$nome_coluna', NOW())";
  mysqli_query($conn, $sql);

  echo "<script> history.go(-1); </script>";
?>
