<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token']; // O token do cartão gerado pelo front-end
    $access_token = $secret_token;
    $cpf = $_POST["cpf"];
    $bandeira = $_POST["bandeira"];
    $cpf = str_replace(".", "", $cpf);
    $cpf = str_replace("-", "", $cpf);
    $valor = floatval($_POST["valor"]);
    $parcelas = intval($_POST["parcelas"]);
    $user_id = $_SESSION["id"];
    $cardNumber = str_replace(" ", "", $_POST["cardNumber"]);
    $card_final = $cardNumber[12].$cardNumber[13].$cardNumber[14].$cardNumber[15];
    //echo $valor;

    // Dados do pagamento
    $data = [
        "transaction_amount" => $valor, // Valor da compra
        "token" => $token, // Token do cartão vindo do front-end
        "description" => "Renovação de período V-Sheet",
        "installments" => $parcelas, // Número de parcelas
        "payment_method_id" => "$bandeira", // Método de pagamento (ex: visa, mastercard, etc.)
        "payer" => [
            "email" => $_POST["payerEmail"],
            "first_name" => "Volnei",
            "last_name" => "Prado",
            "identification" => [
                "type" => "CPF",
                "number" => "$cpf"
            ]
        ]
    ];

    // Inicializar cURL para enviar requisição para API do Mercado Pago
    $ch = curl_init("https://api.mercadopago.com/v1/payments");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $access_token"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Executar requisição e capturar resposta
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Captura o código HTTP da resposta
    curl_close($ch);

    // Decodificar resposta JSON
    $result = json_decode($response, true);

    // Verificar status da resposta
    if ($http_code == 200 || $http_code == 201) {
        //echo "<h3 style='color: green;'>Pagamento aprovado! ID da transação: " . $result["id"] . "</h3>";
        //print_r($result);
        $id_pay = $result["id"];
        $nsu = $result["additional_info"]["nsu_processadora"];
        $total = $result["transaction_details"]["total_paid_amount"];

        $sql = "INSERT INTO `transactions` VALUES(NULL, $valor, $total, $parcelas, '$card_final', $user_id, NULL, NULL, NULL, 'Cartão', NOW(), 2, $nsu, $id_pay)";
        mysqli_query($conn, $sql);
        $id_trans = mysqli_insert_id($conn);

        $group_id = $_SESSION["group_id"];
        $sqlG = "SELECT * FROM groups WHERE id= $group_id";
        $execG = mysqli_query($conn, $sqlG);
        $rowG = mysqli_fetch_array($execG);
        $expiration = new DateTime($rowG["expiration"]);
        $data_atual = new DateTime(date("Y-m-d"));

        $sqlGroups = "SELECT * FROM users WHERE group_id=$group_id";
        $execGroups = mysqli_query($conn, $sqlGroups);
        $total_g_2 = mysqli_num_rows($execGroups);
        $total_g = $total_g_2 - 1;

        $days = round($valor / (1.2 + ($total_g*0.4)));

        if ($expiration > $data_atual) {
          $nova_data = " expiration + INTERVAL $days DAY";
        } else {
          $nova_data = "CURRENT_DATE + INTERVAL $days DAY";
        }

        $sqlUp = "UPDATE groups SET expiration = $nova_data WHERE id=$group_id";
        mysqli_query($conn, $sqlUp);

        $sqlG2 = "SELECT * FROM groups WHERE id= $group_id";
        $execG2 = mysqli_query($conn, $sqlG2);
        $rowG2 = mysqli_fetch_array($execG2);

        $_SESSION["expiration"] = $rowG2["expiration"];

        echo "<script> window.location='home.php?l=".base64_encode(23)."&i=".base64_encode($id_trans)."' </script>";

    } else {
        echo "<h3 style='color: red;'>Erro no pagamento!</h3>";
        echo "Código HTTP: $http_code <br>";
        echo "Mensagem de erro: " . ($result["message"] ?? "Erro desconhecido") . "<br>";

        // Exibir erros adicionais, se houver
        if (isset($result["cause"])) {
            echo "<h4>Detalhes do erro:</h4>";
            foreach ($result["cause"] as $cause) {
                echo "Causa: " . ($cause["description"] ?? "Sem descrição") . "<br>";
            }
        }
    }


} else {
    echo "<h3 style='color: red;'>Método inválido!</h3>";
}
?>
