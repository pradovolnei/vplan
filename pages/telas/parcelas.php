<?php

$access_token = "APP_USR-3159248105241363-022110-66589ec1596ff28a91b3e2b1c6c88ae0-2280185227";
$amount = $valor;
$payment_method_id = "visa"; // Verifique se o método é válido
$url = "https://api.mercadopago.com/v1/payment_methods/installments?amount=$amount&payment_method_id=$payment_method_id";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $access_token"
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$parcelas_mp = $data[0]["payer_costs"];

?>
