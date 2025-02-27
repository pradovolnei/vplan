<?php

use Dompdf\Dompdf;
use Dompdf\Options;

$id_trans = base64_decode($_GET["i"]);
$user_id = $_SESSION["id"];

$sql = "SELECT * FROM transactions WHERE id=$id_trans AND user_id=$user_id";
$exec = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($exec);
$valor = $row["price"];
$total = $row["total"];
$type = $row["type"];
$card_final = $row["card_final"];
$created_at = $row["created_at"];
$parcelas = $row["installments"];

if(isset($_GET['export_pdf'])) {
  $options = new Options();
  $options->set('defaultFont', 'Helvetica');
  $dompdf = new Dompdf($options);

  $html = "<h2>Comprovante de Pagamento</h2>
            <p><strong>Valor Pago:</strong> R$ ".number_format($valor, 2, ',', '.')."</p>
            <p><strong>Forma de Pagamento:</strong> $type</p>";

  if($type == "Cartão") {
      $html .= "<p><strong>Parcelas:</strong> $parcelas</p>
                <p><strong>Total a Pagar:</strong> R$ ".number_format($total, 2, ',', '.')."</p>
                <p><strong>Cartão Utilizado:</strong> **** **** **** $card_final</p>";
  }

  $html .= "<p><strong>Data e Hora do Pagamento:</strong> ".date("d/m/Y H:i", strtotime($created_at))."</p>";

  $dompdf->loadHtml($html);
  $dompdf->setPaper('A4', 'portrait');
  $dompdf->render();
  ob_end_clean();
  $dompdf->stream("comprovante_pagamento.pdf", array("Attachment" => 1));
  exit;
}

?>

<div class="container mt-5" style="margin-top: 10px;;">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm border-success">
        <div class="card-header bg-success text-white text-center">
          <h4 class="mb-0">Pagamento Confirmado</h4>
        </div>
        <div class="card-body">
          <p class="mb-1"><strong>Valor Pago:</strong> R$ <?= number_format($valor, 2, ',', '.') ?></p>
          <p class="mb-1"><strong>Forma de Pagamento:</strong> <?= $type ?></p>

          <?php if ($type == "Cartão"): ?>
            <p class="mb-1"><strong>Parcelas:</strong> <?= $parcelas ?></p>
            <p class="mb-1"><strong>Total a Pagar:</strong> R$ <?= number_format($total, 2, ',', '.') ?></p>
            <p class="mb-1"><strong>Cartão Utilizado:</strong> **** **** **** <?= $card_final ?></p>
          <?php endif; ?>

          <p class="mb-0"><strong>Data e Hora do Pagamento:</strong> <?= date("d/m/Y H:i", strtotime($created_at)) ?></p>
        </div>
        <div class="card-footer text-center">
          <a href="home.php" class="btn btn-primary">Voltar para Home</a>
          <a href="?l=<?= $_GET['l'] ?>&i=<?= $_GET['i'] ?>&export_pdf=1" class="btn btn-danger">Baixar Comprovante (PDF)</a>
        </div>
      </div>
    </div>
  </div>
</div>
