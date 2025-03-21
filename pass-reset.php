<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#">ATUALIZAÇÃO DE SENHA</a>
    </div>
    <!-- /.login-logo -->
    <?php
    include("connect.php");
    $token = $_GET["token"];
    $sql = "SELECT u.id, u.email
      FROM reset_senha rs
      LEFT JOIN users u ON u.id = rs.user_id
      WHERE rs.token = '$token'";

    $exec = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($exec);
    $user_id = $row["id"];
    $email = $row["email"];

    ?>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Escolha uma nova senha</p>

        <form action="update-pass.php" method="post">
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" value="<?= $email ?>" readonly="Email">
            <input  type="hidden" name="token" value="<?= $token ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="Nova Senha" onkeyup="verificaSenha()">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password2" id="password2" class="form-control" placeholder="Confirmar Senha" onkeyup="verificaSenha()">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <div id="msg_erro"></div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block" id="botao_save">Salvar Nova Senha</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <script>
    function verificaSenha() {
      var senha1 = document.getElementById("password").value;
      var senha2 = document.getElementById("password2").value;
      var msg_erro = document.getElementById("msg_erro");

      if (senha1 != senha2) {
        document.getElementById("botao_save").disabled = true;
        msg_erro.innerHTML = "<font color='red' size='1' > *Senhas diferentes* </font>";
      } else {
        document.querySelector("#botao_save").removeAttribute("disabled");
        msg_erro.innerHTML = "";
      }
    }
  </script>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
</body>

</html>
