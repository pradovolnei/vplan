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
} else {
}

//echo "<img src='data:image/jpeg;base64,$qr_code_base64' style='width: 20%;'>";
?>

<div class="content-header">
  <div class="container">
    <div class="wrapper">
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Dados do Pagamento</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <h3> &emsp; R$ <?= number_format($price, 2, ',', '.') ?> </h3>
                      </div>
                      <div class="form-group">
                        <img src='data:image/jpeg;base64,<?= $qr_code_base64 ?>' style='width: 40%;'>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <?= $qr_code ?>
                      </div>

                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <div class="card-body">
                          <button id="copiarBotao" class="btn btn-block btn-primary" onclick="copiarCodigo('<?= $qr_code ?>')"> Copiar código PIX </button>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div id="conteudo"></div>
                  <script>
                      function atualizarConteudo() {
                          var url = "load_pix.php?id_pay=<?=$trans_id?>";
                          console.log(url);
                          fetch(url)
                              .then(response => response.text())
                              .then(data => {
                                  document.getElementById("conteudo").innerHTML = data;
                                  if(data === "Pagamento Confirmado"){
                                  window.location.href ='home.php?l=<?=base64_encode(16)?>';
                                  }
                              })
                              .catch(error => {
                                  console.error("Erro:", error);
                              });
                      }

                      // Chame a função a cada intervalo de tempo (por exemplo, a cada 5 segundos)
                      setInterval(atualizarConteudo, 5000); // 5000 milissegundos = 5 segundos
                  </script>


                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
    </div>
  </div>
</div>

<script>
  function copiarCodigo(codigo) {
    var botao = document.getElementById('copiarBotao');
    var input = document.createElement('input');
    // Define o valor do input como o código desejado
    input.value = codigo;
    // Anexa o input ao corpo do documento
    document.body.appendChild(input);
    // Seleciona o texto dentro do input
    input.select();
    // Executa o comando de cópia
    document.execCommand('copy');
    // Remove o input do documento
    document.body.removeChild(input);
    // Alerta o usuário que o texto foi copiado
    //alert('Código copiado: ' + input.value);
    botao.textContent = 'Código copiado ✔';
  }
</script>
