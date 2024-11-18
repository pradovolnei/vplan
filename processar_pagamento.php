<?php
require 'vendor/autoload.php';


MercadoPago\SDK::setAccessToken('APP_USR-2231983626109454-100916-ff559f46a9f6c3277e7908ea176b13f9-268837322');

// Captura os dados enviados pelo formulário
$cardNumber = $_POST['cardNumber'];
$cardExpiration = $_POST['cardExpiration'];
$cardCVV = $_POST['cardCVV'];
$cardHolderName = $_POST['cardHolderName'];
$installments = $_POST['installments'];
$transactionAmount = $_POST['transactionAmount'];

// Divide a data de expiração em mês e ano
list($cardExpirationMonth, $cardExpirationYear) = explode('/', $cardExpiration);

// Cria a preferência de pagamento
$payment = new MercadoPago\Payment();
$payment->transaction_amount = (float) $transactionAmount;
$payment->token = ''; // Gere o token usando a API de cartão de crédito
$payment->description = "Pagamento teste";
$payment->installments = (int) $installments;
$payment->payment_method_id = "visa";
$payment->payer = array(
    "email" => "volneifjv@gmail.com",
    "identification" => array(
        "type" => "CPF",
        "number" => "12345678909"
    )
);

// Salva o pagamento e lida com a resposta
$payment->save();

if ($payment->status == 'approved') {
    echo "Pagamento realizado com sucesso!";
} else {
    echo "Erro no pagamento: " . $payment->status_detail;
}
?>
