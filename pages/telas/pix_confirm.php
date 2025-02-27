<?php
$trans_id = base64_decode($_GET["i"]);
$sql = "SELECT * FROM transactions WHERE id=$trans_id AND user_id=" . $_SESSION["id"];
$exec = mysqli_query($conn, $sql);

if (mysqli_num_rows($exec) > 0) {
  $row = mysqli_fetch_array($exec);

  $price = $row["price"];
  $qr_code_base64 = $row["qr_code_base64"];
  $qr_code = $row["qr_code"];
  $ticket_url = $row["ticket_url"];
  $status = $row["status"];
}
?>

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
    fetch("load_pix.php?id_pay=<?= $trans_id ?>")
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
