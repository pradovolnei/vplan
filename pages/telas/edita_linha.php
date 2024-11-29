<?php
  $user_id = $_SESSION["id"];
  $plan_id = $_POST["id"];
  $line = $_POST["line"];
  $tipos = $_POST["tipos"];
  $old_valor = $_POST["old_valor"];

  foreach($_POST["valor"] AS $campos => $valores){
    if($old_valor[$campos] != $valores){
      $type_id = $tipos[$campos];

      $sqlUpdate = "UPDATE data_plans SET value='$valores', updated_at = NOW() WHERE plan_id=$plan_id AND number_line=$line AND number_column=$campos ";
      mysqli_query($conn, $sqlUpdate);
    }
  }

  echo "<script> history.go(-1); </script>";
?>
