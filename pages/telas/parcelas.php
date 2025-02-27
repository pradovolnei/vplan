<?php

$access_token = "TEST-2231983626109454-100916-9b3f0b3430745b1fb823bd06adf5c218-268837322";
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
