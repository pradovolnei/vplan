<style>
  body {
    background-color: #f8f9fa;
  }

  .card {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .card-header {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    text-align: center;
    border-radius: 10px 10px 0 0;
  }

  .form-group label {
    font-weight: bold;
  }

  .btn-primary {
    width: 100%;
    font-size: 18px;
    border-radius: 5px;
  }
</style>

<?php
  include "pages/telas/parcelas.php";
  include ("connect.php");
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h3>Dados do Cartão</h3>
        </div>
        <div class="card-body">
          <form id="paymentForm" method="POST" action="home.php?l=<?=base64_encode(22)?>">
            <div class="mb-3">
              <label for="cardHolderName">Nome (Como está no Cartão)</label>
              <input type="text" class="form-control" id="cardHolderName" name="cardHolderName" required placeholder="Nome">
            </div>
            <div class="mb-3">
              <label for="cpf">CPF do Titular</label>
              <input type="text" class="form-control" id="cpf" name="cpf" required placeholder="CPF">
            </div>
            <div class="mb-3">
              <label for="payerEmail">E-mail</label>
              <input type="email" class="form-control" id="payerEmail" name="payerEmail" required placeholder="E-mail">
            </div>
            <div class="mb-3">
              <label for="cardNumber">Número do Cartão</label>
              <input type="text" class="form-control" id="cardNumber" name="cardNumber" required placeholder="Número do Cartão" onkeydown="getCardBrand(this.value)" onkeyup="getCardBrand(this.value)">
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="expirationMonth">Mês Validade</label>
                  <select class="form-control" id="expirationMonth" name="expirationMonth" required>
                    <option value=""></option>
                    <?php
                      for($m=1;$m<=12;$m++){
                        echo "<option value='".str_pad($m , 2 , '0' , STR_PAD_LEFT)."'>".str_pad($m , 2 , '0' , STR_PAD_LEFT)."</option>";
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="expirationYear">Ano Validade</label>
                  <select class="form-control" id="expirationYear" name="expirationYear" required>
                    <option value=""></option>
                    <?php
                      $anoAtual = date("Y");
                      $anoMax = $anoAtual+15;
                      for($a=$anoAtual;$a<=$anoMax;$a++){
                        echo "<option value='$a'>$a</option>";
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="securityCode">CVV</label>
                  <input type="text" class="form-control" id="securityCode" name="securityCode" required placeholder="CVV">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <label for="parcelas">Parcelas</label>
                  <select class="form-control" id="parcelas" name="parcelas" required>
                    <?php
                      $totalParcelas = parcelas($valor);
                      /*if($totalParcelas > 1){
                        for($p=2;$p<=$totalParcelas;$p++){
                          $n_parcelas = ($valor/$p) * (1+(0.01*$p));
                          $valor_total = $n_parcelas*$p;
                          echo "<option value='$p'>".$p."x R$ ".number_format($n_parcelas, 2, ',', '.')."  &nbsp;&nbsp;&nbsp; R$ ".number_format($valor_total, 2, ',', '.')."</option>";
                        }
                      }*/

                      foreach($parcelas_mp as $prestacoes){
                        echo "<option value='".$prestacoes["installments"]."'>".$prestacoes["recommended_message"]."</option>";
                      }
                    ?>
                  </select>
                </div>
              </div>

            </div>

            <input type="hidden" name="token" id="token">
            <input type="hidden" name="valor" id="valor" value="<?=$valor?>">
            <input type="hidden" name="bandeira" id="bandeira">
            <button type="submit" class="btn btn-primary">Pagar</button>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const mp = new MercadoPago(<?=$token_id?>);

  document.getElementById("paymentForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Impede o envio imediato do formulário

    // Coleta e sanitiza os dados
    const cardData = {
      cardNumber: document.getElementById("cardNumber").value.replace(/\s/g, ''),
      cardExpirationMonth: document.getElementById("expirationMonth").value.replace(/\s/g, ''),
      cardExpirationYear: document.getElementById("expirationYear").value.replace(/\s/g, ''),
      securityCode: document.getElementById("securityCode").value.replace(/\s/g, ''),
      cardholderName: document.getElementById("cardHolderName").value.trim(),
      identificationType: "CPF", // Pode mudar dependendo do país
      identificationNumber: document.getElementById("cpf").value.replace(/\s/g, '') // Deve ser um CPF válido
    };

    mp.createCardToken(cardData).then(function(response) {
      console.log("Token gerado:", response.id);
      document.getElementById("token").value = response.id;
      document.getElementById("paymentForm").submit();
    }).catch(function(error) {
      console.error("Erro ao gerar token:", error);
      alert("Erro ao gerar token: " + JSON.stringify(error));
    });
  });

  function totalParcelas(parcelas, valor_puro) {
    var campo_valor = document.getElementById("valor");
    var campo_valor_ext = document.getElementById("total");

    // Garantir que parcelas e valor_puro sejam números
    parcelas = Number(parcelas);
    valor_puro = Number(valor_puro);

    // Aplicação de juros, se houver mais de uma parcela
    var novo_valor = parcelas === 1 ? valor_puro : valor_puro * (1 + 0.01 * parcelas);

    // Atualizar campo de valor
    campo_valor.value = novo_valor;

    // Formatar e exibir valor total
    campo_valor_ext.value = "R$ " + new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(novo_valor);
  }

  function getCardBrand(cardNumber) {
    // Remove espaços e caracteres não numéricos
    cardNumber = cardNumber.replace(/\D/g, "");
    var bandeira = document.getElementById("bandeira");

    const brands = {
        visa: /^4[0-9]{12}(?:[0-9]{3})?$/,
        mastercard: /^5[1-5][0-9]{14}$/,
        amex: /^3[47][0-9]{13}$/,
        elo: /^(4011(78|79)|431274|438935|457631|457632|504175|627780|636297|636368|5067[0-9]{2}|4576[0-9]{2}|6504[0-9]{2}|6505[0-9]{2}|6506[0-9]{2}|6507[0-9]{2}|6509[0-9]{2}|6516[0-9]{2}|6550[0-9]{2})[0-9]*$/,
        hipercard: /^(3841[0-9]{12}|606282[0-9]{10}|637095|637568|637599|637609|637612)[0-9]*$/,
        diners: /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
        discover: /^6(?:011|5[0-9]{2})[0-9]{12}$/
    };

    for (let brand in brands) {
        if (brands[brand].test(cardNumber)) {
            //return brand;
            bandeira.value = brand;
            console.log(brand);
        }
    }

    return "Bandeira desconhecida";
  }





</script>
