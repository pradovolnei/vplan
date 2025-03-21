<?php
include("connect.php");
include("functions.php");
session_start(); // Certifique-se de iniciar a sessão
$cpf = str_replace([".", "-"], "", $_POST["cpf"]);
$email = $_POST["email"];
$nameGroup = $_POST["group"];
$prop = $_POST["prop"];
$senha = encripta($_POST["senha"]);
$nome = explode(" ", $prop);
$first_name = $nome[0];
$last_name = $nome[1];

$sqlGroup = "INSERT INTO groups VALUES(NULL, '$nameGroup', NULL, NULL, NULL, NULL)";
mysqli_query($conn, $sqlGroup);

$group_id = mysqli_insert_id($conn);
$_SESSION["group_id"] = $group_id;

$sqlUser = "INSERT INTO users VALUES(NULL, '$prop', $group_id, 1, '$email', '$senha', 0, '$cpf', NOW(), NULL, NULL)";
mysqli_query($conn, $sqlUser);

$user_id = mysqli_insert_id($conn);

$curl = curl_init();

$json_data = json_encode(array(
  "transaction_amount" => 36,
  "payment_method_id" => "pix",
  "external_reference" => "1234",
  "notification_url" => "https://vactions.com.br/",
  "description" => "Cadastro na Plataforma V-Sheet",
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
    'X-Idempotency-Key: ' . uniqid()
  ),
));

$response = curl_exec($curl);

$data = json_decode($response, true);

$qr_code_base64 = $data["point_of_interaction"]["transaction_data"]["qr_code_base64"];
$qr_code = $data["point_of_interaction"]["transaction_data"]["qr_code"];
$ticket_url = $data["point_of_interaction"]["transaction_data"]["ticket_url"];

$sqlCanc = "UPDATE transactions SET `status`=3 WHERE user_id=$user_id AND `status`=1";
mysqli_query($conn, $sqlCanc);

$sql = "INSERT INTO transactions VALUES(NULL, 36, 36, 1, NULL, $user_id, '$qr_code_base64', '$qr_code', '$ticket_url', 'Pix', NOW(), 1, NULL, NULL)";
mysqli_query($conn, $sql);
$id_solicita = mysqli_insert_id($conn);

$price = 36;

?>

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
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      color: white;
      text-align: center;
      padding: 10px;
    }
  </style>


  <style>
    .container {
      max-width: 500px;
    }

    .card {
      border-radius: 10px;
    }

    .btn-success {
      background-color: #28a745 !important;
      border-color: #28a745 !important;
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div class="container mt-5">
    <div class="card shadow-lg">
      <div class="card-header bg-primary text-white text-center">
        <h3>Dados do Pagamento</h3>
      </div>
      <div class="card-body text-center">
        <h4 class="mb-4">Valor: <strong>R$ <?= number_format($price, 2, ',', '.') ?></strong></h4>

        <div class="mb-3">
          <img src='data:image/jpeg;base64,<?= $qr_code_base64 ?>' style='width: 200px;' class="border rounded shadow">
        </div>

        <div class="mb-3">
          <textarea id="codigoPix" class="form-control text-center" rows="4" readonly><?= $qr_code ?></textarea>
        </div>

        <button id="copiarBotao" class="btn btn-primary" onclick="copiarCodigo()">Copiar código PIX</button>

        <div class="mt-3 text-muted">
          <span id="statusPagamento">Aguardando Pagamento...</span>
        </div>
      </div>
    </div>
  </div>

  <script>
    function copiarCodigo() {
      var codigoPix = document.getElementById("codigoPix");
      codigoPix.select();
      document.execCommand("copy");

      var botao = document.getElementById("copiarBotao");
      botao.textContent = "Código copiado ✔";
      botao.classList.add("btn-success");
      setTimeout(() => {
        botao.textContent = "Copiar código PIX";
        botao.classList.remove("btn-success");
      }, 3000);
    }

    function atualizarConteudo() {
      fetch("load_pix2.php?id_pay=<?= $id_solicita ?>")
        .then(response => response.text())
        .then(data => {
          document.getElementById("statusPagamento").textContent = data;
          if (data === "Pagamento Confirmado" || data === "Pagamento Cancelado") {
            window.location.href = 'home.php?l=<?= base64_encode(16) ?>';
          }
        })
        .catch(error => console.error("Erro:", error));
    }

    setInterval(atualizarConteudo, 5000);
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

</body>

</html>
