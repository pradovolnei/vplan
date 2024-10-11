<?php
  $plan_id = base64_decode($_GET["p"]);
  $linha = $_GET["li"];
  $group_id = $_SESSION["group_id"];

  $sql = "DELETE dp
  FROM data_plans dp
  INNER JOIN plans p ON p.id = dp.plan_id
  WHERE p.id = $plan_id AND p.group_id = $group_id AND dp.number_line=$linha";
  mysqli_query($conn, $sql);

  $sqlAjuste = "UPDATE data_plans SET number_line=number_line-1 WHERE number_line > $linha";
  mysqli_query($conn, $sqlAjuste);

  $sqlUp = "UPDATE plans SET updated_at=NOW() WHERE id=$plan_id AND group_id=$group_id";
  mysqli_query($conn, $sqlUp);

  echo "<script> history.go(-1); </script>";
?>
