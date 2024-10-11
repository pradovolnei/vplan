<?php
  $obs = $_POST["obs"];
  $name = $_POST["name"];
  $sql = "UPDATE plans SET name='$name', obs='$obs' WHERE id=".$_POST["id"];
  mysqli_query($conn, $sql);

  echo "<script> window.location='home.php' </script>";
?>
