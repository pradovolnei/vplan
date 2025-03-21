<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
    include("connect.php");
    include("functions.php");
    session_start(); // Certifique-se de iniciar a sessão
    $token = $_POST['token']; // O token do cartão gerado pelo front-end
    $access_token = $secret_token;
    $cpf = str_replace([".", "-"], "", $_POST["cpf"]);
    $bandeira = $_POST["bandeira"];
    $valor = floatval(36);
    $parcelas = intval(1);
    $cardNumber = str_replace(" ", "", $_POST["cardNumber"]);
    $card_final = substr($cardNumber, -4); // Pegando os últimos 4 dígitos do cartão
    $email = $_POST["email"];

    // Dados do pagamento
    $data = [
      "transaction_amount" => $valor,
      "token" => $token,
      "description" => "Cadastro na Plataforma V-Sheet",
      "installments" => $parcelas,
      "payment_method_id" => $bandeira,
      "payer" => [
        "email" => $email,
        "first_name" => "Volnei",
        "last_name" => "Prado",
        "identification" => [
          "type" => "CPF",
          "number" => $cpf
        ]
      ]
    ];

    // Inicializar cURL
    $ch = curl_init("https://api.mercadopago.com/v1/payments");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Content-Type: application/json",
      "Authorization: Bearer $access_token"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Executar requisição
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($response === false) {
      throw new Exception("Erro na requisição cURL: " . curl_error($ch));
    }
    curl_close($ch);

    // Decodificar resposta JSON
    $result = json_decode($response, true);
    if ($http_code != 200 && $http_code != 201) {
      throw new Exception("Erro no pagamento: " . ($result["message"] ?? "Erro desconhecido"));
    }

    // Conectar ao banco de dados
    $conn = new mysqli("localhost", "root", "", "vplan");
    if ($conn->connect_error) {
      throw new Exception("Erro ao conectar ao banco de dados: " . $conn->connect_error);
    }

    // Inserir transação no banco
    $id_pay = $result["id"];
    $nsu = $result["additional_info"]["nsu_processadora"] ?? null;
    $total = $result["transaction_details"]["total_paid_amount"] ?? $valor;

    $nameGroup = $_POST["group"];
    $sqlGroup = "INSERT INTO groups VALUES(NULL, '$nameGroup', NULL, NULL, NULL, CURRENT_DATE + INTERVAL 30 DAY)";
    if (!$conn->query($sqlGroup)) {
      throw new Exception("Erro ao inserir transação: " . $conn->error);
    }
    $group_id = $conn->insert_id;
    $_SESSION["group_id"] = $group_id;

    $senha = encripta($_POST["senha"]);

    $prop = $_POST["prop"];
    $sqlUser = "INSERT INTO users VALUES(NULL, '$prop', $group_id, 1, '$email', '$senha', 1, '$cpf', NOW(), NULL, NULL)";
    if (!$conn->query($sqlUser)) {
      throw new Exception("Erro ao inserir transação: " . $conn->error);
    }
    $user_id = $conn->insert_id;

    $sql = "INSERT INTO `transactions` VALUES(NULL, $valor, $total, $parcelas, '$card_final', $user_id, NULL, NULL, NULL, 'Cartão', NOW(), 2, $nsu, $id_pay)";
    if (!$conn->query($sql)) {
      throw new Exception("Erro ao inserir transação: " . $conn->error);
    }
    $id_trans = $conn->insert_id;

    $sql = "SELECT u.*, g.expiration FROM users u LEFT JOIN groups g ON g.id = u.group_id WHERE u.id=$user_id";
    $exec = mysqli_query($conn, $sql);
    if (mysqli_num_rows($exec) > 0) {
      $row = mysqli_fetch_array($exec);

      $_SESSION["id"] = $row["id"];
      $_SESSION["name"] = $row["name"];
      $_SESSION["group_id"] = $row["group_id"];
      $_SESSION["email"] = $row["email"];
      $_SESSION["type"] = $row["type"];
      $_SESSION["cpf"] = $row["cpf"];
      $_SESSION["expiration"] = $row["expiration"];
      $_SESSION["status"] = $row["status"];
    }

    sendWelcomeEmail($email, $prop);
    echo "<script> window.location='home.php' </script>";
  } catch (Exception $e) {
    echo "<h3 style='color: red;'>Erro!</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
  }
} else {
  echo "<h3 style='color: red;'>Método inválido!</h3>";
}
