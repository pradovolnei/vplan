<?php
  $user_id = $_SESSION["id"];
  $plan_id = $_POST["id"];
  $new_line = $_POST["new_line"];
  $tipos = $_POST["tipos"];

  foreach($_POST["valor"] AS $campos => $valores){

    // Tenta identificar o tipo da célula
    /*if (is_numeric($valores)) {
      if (strpos($valores, '.') !== false) {
          $type_id = 3; // Float
      } else {
          $type_id = 2; // Inteiro
      }
    } elseif (strtotime($valores) !== false) {
      $type_id = 4; // Data ou data-hora
    } else {
      $type_id = 1; // String
    }*/

    $type_id = $tipos[$campos];

    $sql = "INSERT INTO data_plans VALUES(NULL, $plan_id, $campos, $new_line, '$valores', $type_id, NOW(), $user_id, NULL)";
    mysqli_query($conn, $sql);
  }

  echo "<script> history.go(-1); </script>";
?>
