<?php
  $user_id = $_SESSION["id"];
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
                                    <h3 class="card-title">Dados do Usuário</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="?l=<?= base64_encode(17) ?>" method="POST">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nome</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="nome" required placeholder="Nome" value="<?= $_SESSION["name"] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">CPF</label>
                                                    <input type="text" class="form-control" id="exampleInputPassword1" name="cpf" required placeholder="CPF" value="<?= $_SESSION["cpf"] ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">E-mail</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="E-mail" readonly value="<?= $_SESSION["email"] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Nível</label>
                                                    <input type="text" class="form-control" readonly id="exampleInputPassword1" placeholder="CPF" value="<?= getNivel($_SESSION["type"]) ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->


                        </div>
                    </div>
                    <?php if ($_SESSION["type"] == 1) { ?>
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- general form elements -->
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Dados do Plano</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Status </label>
                                                        <input type="text" readonly class="form-control" id="exampleInputEmail1" placeholder="Nome" value="<?= getStatus($_SESSION["status"]) ?>">
                                                    </div>

                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Período</label> <br>
                                                        <?= getExp($_SESSION["expiration"]) ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <br>
                                                        <a href="#" class="btn btn-warning" data-toggle='modal' data-target='#modal-saldo'> Renovar / Retivar </a>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h3> Usuários </h3>
                                                </div>
                                            </div>

                                            <?php
                                            $group_id = $_SESSION["group_id"];
                                            $sqlUsers = "SELECT * FROM users WHERE group_id = $group_id AND id <> " . $user_id;
                                            $execUsers = mysqli_query($conn, $sqlUsers);

                                            while ($row = mysqli_fetch_array($execUsers)) {
                                                if ($row["status"] == 1) {
                                                    $color = "danger";
                                                    $title = "Bloquear";
                                                    $novoStatus = 2;
                                                } else {
                                                    $color = "success";
                                                    $title = "Desbloquear";
                                                    $novoStatus = 1;
                                                }
                                            ?>
                                                <div class="row" style="margin-top: 16px;">
                                                    <div class="col-md-3">
                                                        <label> <?= $row["name"] ?> </label>
                                                    </div>

                                                    <div class="col-md-3">

                                                        <a href="?l=<?= base64_encode(18) ?>&s=<?= base64_encode($novoStatus) ?>&i=<?= base64_encode($row["id"]) ?>" class="btn btn-<?= $color ?>" href=""> <?= $title ?> </a>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <!-- /.card-body -->

                                    </form>
                                </div>
                                <!-- /.card -->

                            </div>
                        </div>
                    <?php } ?>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-saldo">
  <div class="modal-dialog">
    <form action="?l=<?=base64_encode(19)?>" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Adicionar Período / Retivar</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card-body">
            <input type="hidden" class="form-control" name="id" value="<?=$user_id?>" />
            <input type="hidden" class="form-control" name="group" value="<?=$_SESSION["group_id"]?>" />

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Perídodo desejável (Dias) </label>
                  <input type="number" name="dias" id="dias" class="form-control" min="5" required />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <div id="custo" class="font-weight-bold" style="font-size: 1.2rem; line-height: 5.2;">
                    Valor estimado R$ 0,00
                  </div>
                </div>
              </div>

            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="" style="color: #FF8C00;"> * 1 Dia = R$ 1,20 </label>
                </div>
                <div class="form-group">
                  <label for="" style="color: #D00;"> * O valor mínimo de uma renovação é de R$ 6,00 </label>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary" disabled id="pagamento">Pagar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </form>
  </div>
  <!-- /.modal-dialog -->
</div>
<?php
  $sqlV = "SELECT * FROM transactions WHERE user_id=$user_id AND `status` = 1";
  $execV = mysqli_query($conn, $sqlV);
  if(mysqli_num_rows($execV)){
    $rowV = mysqli_fetch_array($execV);
?>

<div id="conteudo"></div>
<script>
    function atualizarConteudo() {
        var url = "load_pix.php?id_pay=<?=$rowV["id"]?>";
        console.log(url);
        fetch(url)
            .then(response => response.text())
            .then(data => {
                document.getElementById("conteudo").innerHTML = "";
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

<?php

  }

?>
<script>
  document.getElementById('dias').addEventListener('input', function() {
    var dias = parseFloat(this.value);
    var custo = dias * 1.2;
    var custoFormatado = isNaN(custo) ? 'Valor estimado R$ 0,00' : 'Valor estimado R$ ' + custo.toFixed(2).replace('.', ',');
    var custoPagar = isNaN(custo) ? 'R$ 0,00' : 'Pagar R$ ' + custo.toFixed(2).replace('.', ',');
    document.getElementById('custo').textContent = custoFormatado;

    document.getElementById("pagamento").textContent = custoPagar;

    if(custo >= 6){
      document.getElementById("pagamento").disabled = false;
    }else{
      document.getElementById("pagamento").disabled = true;
      document.getElementById("pagamento").textContent = "Valor mínimo R$ 6,00";
    }
  });
</script>
