<?php
  if(isset($_GET["c"]))
    include "cartao.php";
  elseif(isset($_GET["p"]))
    include "pix.php";
  else
    echo "<script>window.location='index.php';</script>";
?>
