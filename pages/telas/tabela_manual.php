<?php
    $user_id = $_SESSION["id"];

    $sql = "INSERT INTO plans(name, group_id, obs, created_at, created_by)
            VALUES('".$_POST["name"]."', ".$_SESSION["group_id"].", '".$_POST["obs"]."', NOW(), ".$user_id.")";
    mysqli_query($conn, $sql);

    $id_plan = mysqli_insert_id($conn);

    $tipos = $_POST["tipo_coluna"];

    $array_tipos = ["texto" => 1, "número inteiro" => 2, "número decimal" => 3, "data" => 4, "data/hora" => 5, "lista suspensa" => 6];

    foreach($_POST["coluna_manual"] AS $campos => $valores){
        $tipo = $array_tipos[$tipos[$campos]];
        $sql = "INSERT INTO data_plans VALUES(NULL, $id_plan, $campos, 0, '$valores', $tipo, NOW(), $user_id, NULL)";
        mysqli_query($conn, $sql);
    }

    echo "<script> window.location='?l=".base64_encode(5)."&p=".base64_encode($id_plan)."' </script>";
?>
