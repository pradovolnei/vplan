<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>V-Sheet</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      scroll-behavior: smooth;
    }

    section {
      padding: 60px 0;
    }

    nav .nav-link.active {
      font-weight: bold;
    }

    footer {
      padding: 20px 0;
      background-color: #f8f9fa;
      text-align: center;
    }
  </style>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/jsgrid/jsgrid.min.css">
  <link rel="stylesheet" href="plugins/jsgrid/jsgrid-theme.min.css">
</head>

<body>

  <!-- Menu de navegação -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#"><i>V-Sheet</i></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#sobre-sistema">Sobre o Sistema</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#planos">Planos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#sobre-nos">Sobre Nós</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#fale-conosco">Fale Conosco</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Home -->
  <form id="paymentForm" method="POST" action="confirm_cred.php">
    <section id="home" class="bg-light">
      <div class="container">
        <!-- Conteúdo da home -->
        <div class="container mt-5">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header text-center bg-primary text-white">
                  <h4>Dados da Equipe</h4>
                </div>
                <div class="card-body">

                  <div class="mb-3">
                    <label for="group" class="form-label">Nome da Equipe</label>
                    <input type="text" class="form-control" id="group" name="group" placeholder="Nome da Equipe" required>
                  </div>
                  <div class="mb-3">
                    <label for="prop" class="form-label">Nome do Proprietário da Equipe</label>
                    <input type="text" class="form-control" id="prop" name="prop" placeholder="Nome do Proprietário da Equipe" required>
                  </div>
                  <div class="mb-3">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" required>
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">E-Mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="E-Mail" required>
                  </div>
                  <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="" required>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header text-center bg-primary text-white">
                  <h4>Dados do Cartão</h4>
                </div>
                <div class="card-body">

                  <div class="mb-3">
                    <label for="cardNumber" class="form-label">Número do Cartão</label>
                    <input type="text" onkeyup="getCardBrand(this.value)" class="form-control" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456" required>
                  </div>
                  <div class="mb-3">
                    <label for="cardHolderName" class="form-label">Nome no Cartão</label>
                    <input type="text" class="form-control" id="cardHolderName" name="cardHolderName" placeholder="Nome conforme o cartão" required>
                  </div>
                  <div class="mb-3">
                    <label for="cpf" class="form-label">CPF do Titular</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="" required>
                  </div>
                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <label for="expirationMonth" class="form-label">Mês Validade</label>
                      <select class="form-control" id="expirationMonth" name="expirationMonth" required>
                        <option value=""></option>
                        <?php
                        for ($m = 1; $m <= 12; $m++) {
                          echo "<option value='" . str_pad($m, 2, '0', STR_PAD_LEFT) . "'>" . str_pad($m, 2, '0', STR_PAD_LEFT) . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="expirationYear" class="form-label">Ano Validade</label>
                      <select class="form-control" id="expirationYear" name="expirationYear" required>
                        <option value=""></option>
                        <?php
                        $anoAtual = date("Y");
                        $anoMax = $anoAtual + 15;
                        for ($a = $anoAtual; $a <= $anoMax; $a++) {
                          echo "<option value='$a'>$a</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="securityCode" class="form-label">CVV</label>
                      <input type="text" class="form-control" id="securityCode" placeholder="123" required>
                      <input type="hidden" name="token" id="token">
                      <input type="hidden" name="bandeira" id="bandeira">

                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="amount" class="form-label">Valor</label>
                    <input type="text" class="form-control" id="amount" value="R$ 36,00" readonly>
                  </div>
                  <button type="submit" class="btn btn-primary w-100">Pagar</button>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </form>

  <!-- Rodapé -->
  <footer style="background-color: #EEE">
    <p>VOLNEI LUIZ CAMPOS PRADO 40.905.140/0001-23</p>
    <a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const links = document.querySelectorAll('.nav-link');
    links.forEach(link => {
      link.addEventListener('click', function() {
        links.forEach(link => link.classList.remove('active'));
        this.classList.add('active');
      });
    });

    function solicitaOrcamento() {
      var assunto = document.getElementById("assunto");
      assunto.value = "Orçamento";
    }
  </script>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>

  <!-- DataTables  & Plugins -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="plugins/jszip/jszip.min.js"></script>
  <script src="plugins/pdfmake/pdfmake.min.js"></script>
  <script src="plugins/pdfmake/vfs_fonts.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
  <script src="plugins/jsgrid/jsgrid.min.js"></script>
  <script src="https://sdk.mercadopago.com/js/v2"></script>

  <script>
    const mp = new MercadoPago("APP_USR-e4859647-cd2a-49b9-b8c5-922b3d312936");

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
        identificationNumber: document.getElementById("cpf").value.replace(/\D/g, '') // Deve ser um CPF válido
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
          //console.log(brand);
        }
      }

      return "Bandeira desconhecida";
    }
  </script>
</body>

</html>
