<style>
  .btn-outline-success,
  .btn-outline-primary {
    display: flex;
    flex-direction: column;
    align-items: center;
    border-radius: 10px;
    cursor: pointer;
    width: 120px;
  }

  .btn-outline-success input:checked+img,
  .btn-outline-primary input:checked+img {
    filter: brightness(0.9) !important;
  }

  .gap-4 {
    gap: 1.5rem;
  }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php
$user_id = $_SESSION["id"];
$id_group = $_SESSION["group_id"];
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
              <div class="col-md-12">
                <div class="card card-success">
                  <div class="card-header">
                    <h3 class="card-title">Dados do Plano</h3>
                  </div>
                  <form>
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Status</label>
                            <input type="text" readonly class="form-control" value="<?= getStatus($_SESSION["status"]) ?>">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Período</label>
                            <p class="text-primary font-weight-bold"> <?= getExp($_SESSION["expiration"]) ?> </p>
                          </div>
                        </div>
                        <div class="col-md-4 text-right">
                          <a href="#" class="btn btn-warning" data-toggle='modal' data-target='#modal-saldo'>Renovar / Reativar</a>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="m-0">Assistentes</h3>
                        <a class="btn btn-primary" href="#" data-toggle='modal' data-target='#modal-assis'>Novo assistente</a>
                      </div>
                      <?php
                      $group_id = $id_group;
                      $sqlUsers = "SELECT * FROM users WHERE group_id = $group_id AND id <> " . $user_id;
                      $execUsers = mysqli_query($conn, $sqlUsers);
                      while ($row = mysqli_fetch_array($execUsers)) {
                        $color = ($row["status"] == 1) ? "danger" : "success";
                        $title = ($row["status"] == 1) ? "Bloquear" : "Desbloquear";
                        $novoStatus = ($row["status"] == 1) ? 2 : 1;
                      ?>
                        <div class="d-flex justify-content-between align-items-center border p-2 rounded mb-2">
                          <span class="font-weight-bold"> <?= $row["name"] ?> </span>
                          <a href="?l=<?= base64_encode(18) ?>&s=<?= base64_encode($novoStatus) ?>&i=<?= base64_encode($row["id"]) ?>" class="btn btn-<?= $color ?>"> <?= $title ?> </a>
                        </div>
                      <?php } ?>
                    </div>
                  </form>
                </div>
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
    <form action="?l=<?= base64_encode(19) ?>" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h4 class="modal-title">Adicionar Período / Reativar</h4>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <input type="hidden" name="id" value="<?= $user_id ?>" />
            <input type="hidden" name="group" value="<?= $id_group ?>" />

            <div class="form-group">
              <label for="dias" class="font-weight-bold">Período desejável (Dias)</label>
              <input type="number" name="dias" id="dias" class="form-control" min="5" required />
              <?php
              $sqlGroups = "SELECT * FROM users WHERE group_id=$id_group";
              $execG = mysqli_query($conn, $sqlGroups);
              $totalUsers = mysqli_num_rows($execG);
              $totalUsersReal = $totalUsers - 1;
              ?>
              <input type="hidden" name="assistentes" id="assistentes" value="<?= $totalUsersReal ?>" />
            </div>

            <div class="form-group text-center font-weight-bold" id="custo" style="font-size: 1.3rem;">
              Valor estimado R$ 0,00
            </div>

            <div class="alert alert-warning text-center">
              <strong>1 Dia = R$ 1,20</strong> <br>
              <small>*Adicional de R$ 0,40/dia para cada assistente*</small>
            </div>
            <div class="alert alert-danger text-center">
              <strong>O valor mínimo de uma renovação é de R$ 6,00 / 5 dias</strong>
            </div>

            <div class="form-group text-center">
              <label class="font-weight-bold">Escolha a forma de pagamento:</label>
              <div class="d-flex justify-content-center gap-4">
                <label class="btn btn-outline-success p-3 mx-2">
                  <input type="radio" name="pagamento" value="pix" class="d-none" required>
                  <img src="dist/img/pix.png" style="filter: brightness(2.0);" alt="Pix" width="40">
                  <br>Pix
                </label>
                <label class="btn btn-outline-primary p-3 mx-2">
                  <input type="radio" name="pagamento" value="cartao" class="d-none" required>
                  <img src="dist/img/cred.png" alt="Cartão de Crédito" width="40">
                  <br>Cartão de Crédito
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary" disabled id="pagamento">Pagar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-assis">
  <div class="modal-dialog">
    <form action="?l=<?= base64_encode(24) ?>" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h4 class="modal-title">Novo Assistente</h4>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <input type="hidden" name="group" value="<?= $id_group ?>" />

            <div class="form-group">
              <label for="nome" class="font-weight-bold">Nome</label>
              <input type="text" name="nome" id="nome" class="form-control" required />
            </div>

            <div class="form-group">
              <label for="email" class="font-weight-bold">E-mail</label>
              <input type="email" name="email" id="email" class="form-control" required />
              <span id="msg"></span>
            </div>

            <div class="form-group">
              <label for="cpf" class="font-weight-bold">CPF</label>
              <input type="text" name="cpf" id="cpf" class="form-control" required />
            </div>

            <div class="form-group">
              <label for="permissao" class="font-weight-bold">Perfil de Administrador <i class='fas fa-info-circle text-secondary' data-bs-toggle='tooltip' title='O usuário poderá criar e editar planilhas além de criar e bloquear assisentes.'></i></label>
              <select class="form-control" name="permissao" id="permissao" required>
                <option value="">  </option>
                <option value="1"> Sim </option>
                <option value="2"> Não </option>
              </select>
            </div>

            <div class="form-group">
              <label for="senha" class="font-weight-bold">Senha</label>
              <input type="password" name="senha" id="senha" class="form-control" required />
            </div>

          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary" id="submitBtn">Cadastrar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#email').on('keyup', function() {
      var email = $(this).val();
      if (email.length > 5) {
        $.ajax({
          url: 'verifica_email.php',
          type: 'POST',
          data: {
            email: email
          },
          success: function(response) {
            if (response == 'existe') {
              $('#msg').text('Email já cadastrado').css('color', 'red');
              $('#submitBtn').prop('disabled', true);
            } else {
              $('#msg').text('Email disponível').css('color', 'green');
              $('#submitBtn').prop('disabled', false);
            }
          }
        });
      } else {
        $('#msg').text('');
        $('#submitBtn').prop('disabled', false);
      }
    });
  });
</script>

<?php
$sqlV = "SELECT * FROM transactions WHERE user_id=$user_id AND `status` = 1";
$execV = mysqli_query($conn, $sqlV);
if (mysqli_num_rows($execV)) {
  $rowV = mysqli_fetch_array($execV);
?>

  <div id="conteudo"></div>
  <script>
    function atualizarConteudo() {
      var url = "load_pix.php?id_pay=<?= $rowV["id"] ?>";
      console.log(url);
      fetch(url)
        .then(response => response.text())
        .then(data => {
          document.getElementById("conteudo").innerHTML = "";
          if (data === "Pagamento Confirmado") {
            window.location.href = 'home.php?l=<?= base64_encode(16) ?>';
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
    var assistentes = document.getElementById("assistentes").value;
    var assis = parseInt(assistentes);
    var custo = dias * (1.2 + (assis * 0.4));
    var custoFormatado = isNaN(custo) ? 'Valor estimado R$ 0,00' : 'Valor estimado R$ ' + custo.toFixed(2).replace('.', ',');
    var custoPagar = isNaN(custo) ? 'R$ 0,00' : 'Pagar R$ ' + custo.toFixed(2).replace('.', ',');
    document.getElementById('custo').textContent = custoFormatado;

    document.getElementById("pagamento").textContent = custoPagar;

    if (custo >= 6) {
      document.getElementById("pagamento").disabled = false;
    } else {
      document.getElementById("pagamento").disabled = true;
      document.getElementById("pagamento").textContent = "Valor mínimo R$ 6,00 / 5 dias";
    }
  });
</script>
