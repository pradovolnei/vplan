<?php

  $valor = $_POST["dias"]*(1.2 + (0.4*$_POST["assistentes"]));
  $valor = round($valor, 2);

  if(!isset($_POST["pagamento"]))
    echo "<script> window.location='home.php?l=MTY='; </script>";

  if($_POST["pagamento"] == "pix")
    include "pages/telas/pix.php";
  else
    include "pages/telas/cred.php";
?>
