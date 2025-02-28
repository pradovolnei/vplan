<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

$user_id = $_SESSION["id"];

$sql = "INSERT INTO plans(name, group_id, obs, created_at, created_by)
        VALUES('".$_POST["name"]."', ".$_SESSION["group_id"].", '".$_POST["obs"]."', NOW(), ".$user_id.")";
mysqli_query($conn, $sql);

$id_plan = mysqli_insert_id($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['planilha'])) {
    $arquivo = $_FILES['planilha'];

    // Verifica se não houve erro no upload
    if ($arquivo['error'] === UPLOAD_ERR_OK) {
        // Diretório temporário onde o arquivo foi salvo
        $arquivoTemporario = $arquivo['tmp_name'];

        try {
            // Lê o arquivo Excel
            $spreadsheet = IOFactory::load($arquivoTemporario);
            $sheet = $spreadsheet->getActiveSheet();
            $dados = $sheet->toArray();

            $linha_dados = 0;
            // Loop para processar cada linha da planilha
            foreach ($dados as $indiceLinha => $linha) {
                $column = 0;
                foreach ($linha as $indiceColuna => $celula) {
                    $celula = trim($celula); // Remove espaços extras

                    // Tenta identificar o tipo da célula
                    if (is_numeric($celula)) {
                        if (strpos($celula, '.') !== false) {
                            $type_id = 3; // Float
                        } else {
                            $type_id = 2; // Inteiro
                        }
                    } elseif (strtotime($celula) !== false) {
                        $type_id = 4; // Data ou data-hora
                    } else {
                        $type_id = 1; // String
                    }

                    // Insere os dados na tabela 'data_plans'
                    $sql_dados = "INSERT INTO data_plans(plan_id, number_column, number_line, value, type_id, created_at, created_by)
                                  VALUES($id_plan, $column, $linha_dados, '".htmlspecialchars($celula)."', $type_id, NOW(), $user_id)";
                    mysqli_query($conn, $sql_dados);

                    //echo "<br><br><br><br><br><br><br>$sql_dados";

                    $column++;
                }
                $linha_dados++;
            }
        } catch (Exception $e) {
            echo 'Erro ao ler o arquivo: ', $e->getMessage();
        }
    } else {
        echo 'Erro ao fazer o upload do arquivo.';
    }
} else {
    echo 'Nenhum arquivo foi enviado.';
}

echo "<script> window.location='?l=".base64_encode(5)."&p=".base64_encode($id_plan)."'; </script>";

?>
