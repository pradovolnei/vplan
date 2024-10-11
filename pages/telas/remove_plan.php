<?php
  $plan_id = base64_decode($_GET["p"]);
  $user_id = $_SESSION["id"];
  $group_id = $_SESSION["group_id"];


  $sql = "DELETE dp
          FROM data_plans dp
          INNER JOIN plans p ON p.id = dp.plan_id
          WHERE p.id = $plan_id AND p.group_id = $group_id";
  mysqli_query($conn, $sql);

  $sqlUp = "UPDATE plans SET deleted_at=NOW(), deleted_by=$user_id WHERE id=$plan_id AND group_id=$group_id";
  mysqli_query($conn, $sqlUp);

  echo "<script> window.location='home.php' </script>";
?>
