<?php
  $id = base64_decode($_GET["i"]);
  $group_id = $_SESSION["group_id"];

  $sql = "DELETE dp
  FROM formulas dp
  INNER JOIN plans p ON p.id = dp.plan_id
  WHERE p.group_id = $group_id AND dp.id=$id";
  mysqli_query($conn, $sql);

  echo "<script> history.go(-1); </script>";
?>
