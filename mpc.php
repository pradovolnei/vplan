<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento com Cartão de Crédito</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Formulário de Pagamento</h2>
        <form action="processar_pagamento.php" method="POST">
            <div class="form-group">
                <label for="cardNumber">Número do Cartão</label>
                <input type="text" class="form-control" id="cardNumber" name="cardNumber" required>
            </div>
            <div class="form-group">
                <label for="cardExpiration">Data de Expiração (MM/AA)</label>
                <input type="text" class="form-control" id="cardExpiration" name="cardExpiration" required>
            </div>
            <div class="form-group">
                <label for="cardCVV">Código de Segurança (CVV)</label>
                <input type="text" class="form-control" id="cardCVV" name="cardCVV" required>
            </div>
            <div class="form-group">
                <label for="cardHolderName">Nome do Titular</label>
                <input type="text" class="form-control" id="cardHolderName" name="cardHolderName" required>
            </div>
            <div class="form-group">
                <label for="installments">Número de Parcelas</label>
                <input type="number" class="form-control" id="installments" name="installments" required>
            </div>
            <div class="form-group">
                <label for="transactionAmount">Valor da Transação</label>
                <input type="number" step="0.01" class="form-control" id="transactionAmount" name="transactionAmount" required>
            </div>
            <button type="submit" class="btn btn-primary">Pagar</button>
        </form>
    </div>
</body>
</html>
