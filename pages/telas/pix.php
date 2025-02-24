<?php
  $valor = $_POST["dias"]*1.2;
  $valor = round($valor, 2);
  $email = $_SESSION["email"];
  $user_id = $_SESSION["id"];
  $nome = explode(" ", $_SESSION["name"]);
  $first_name = $nome[0];
  $last_name = $nome[1];
  $cpf = $_SESSION["cpf"];

  $curl = curl_init();

  $json_data = json_encode(array(
      "transaction_amount" => $valor,
      "payment_method_id" => "pix",
      "external_reference" => "1234",
      "notification_url" => "https://vactions.com.br/",
      "description" => "RENOVAÇÃO DE PERÍODO",
      "payer" => array(
          "first_name" => $first_name,
          "last_name" => $last_name,
          "email" => $email,
          "identification" => array(
              "type" => "CPF",
              "number" => $cpf
          ),
          "address" => array(
              "zip_code" => "06233-200",
              "street_name" => "Av. das Nações Unidas",
              "street_number" => "3003",
              "neighborhood" => "Bonfim",
              "city" => "Osasco",
              "federal_unit" => "SP"
          )
      )
  ));


  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data),
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'Authorization: Bearer APP_USR-3159248105241363-022110-66589ec1596ff28a91b3e2b1c6c88ae0-2280185227',
      'X-Idempotency-Key: '.uniqid()
    ),
  ));

  $response = curl_exec($curl);

  $data = json_decode($response, true);

  $qr_code_base64 = $data["point_of_interaction"]["transaction_data"]["qr_code_base64"];
  $qr_code = $data["point_of_interaction"]["transaction_data"]["qr_code"];
  $ticket_url = $data["point_of_interaction"]["transaction_data"]["ticket_url"];

  $sqlCanc = "UPDATE transactions SET `status`=3 WHERE user_id=$user_id AND `status`=1";
  mysqli_query($conn, $sqlCanc);

  $sql = "INSERT INTO transactions VALUES(NULL, $valor, $user_id, '$qr_code_base64', '$qr_code', '$ticket_url', 'pix', NOW(), 1)";
  mysqli_query($conn, $sql);
  $id_solicita = mysqli_insert_id($conn);

  echo "<script> window.location='home.php?l=".base64_encode(20)."&i=".base64_encode($id_solicita)."'; </script>";

?>

