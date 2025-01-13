<?php
    $status = base64_decode($_GET["s"]);
    $id = base64_decode($_GET["i"]);

    $sql = "UPDATE users SET status=$status, updated_at=NOW() WHERE id=$id";
    mysqli_query($conn, $sql);

    echo "<script> alert('Dados atualizados!'); window.location='home.php?l=MTY=' </script>";
?>