<?php 
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];

    $sql = "UPDATE users SET name='$nome', cpf='$cpf', updated_at=NOW() WHERE id=".$_SESSION["id"];
    mysqli_query($conn, $sql);

    $_SESSION["name"] = $nome;
    $_SESSION["cpf"] = $cpf;

    echo "<script> alert('Dados atualizados!'); window.location='home.php?l=MTY=' </script>";
?>