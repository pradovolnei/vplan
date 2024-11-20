<?php
  $plan_id = $_POST["plan_id"];
  $number_column = $_POST["number_column"];
  $campos = $_POST["campos"];
  $id = $_SESSION["id"];

  foreach($campos as $campo){
    $sql = "INSERT INTO listas(plan_id, number_column, value, created_at, created_by) VALUES ($plan_id, $number_column, '$campo', NOW(), $id)";
    mysqli_query($conn, $sql);
  }

  echo "<script> window.location='home.php?l=".base64_encode(5)."&p=".base64_encode($plan_id)."' </script>";

?>
