<?php
  $user_id = $_SESSION["id"];
  $plan_id = $_POST["id"];
  $new_line = $_POST["new_line"];

  foreach($_POST["valor"] AS $campos => $valores){
    $sql = "INSERT INTO data_plans VALUES(NULL, $plan_id, $campos, $new_line, '$valores', 1, NOW(), $user_id, NULL)";
    mysqli_query($conn, $sql);
  }

  echo "<script> history.go(-1); </script>";
?>
