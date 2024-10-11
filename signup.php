<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cadastro</title>

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
  <?php include ("connect.php"); ?>
<div class="login-box">
  <div class="login-logo">
    <a href="index2.html">CADASTRO</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Cadastre um Usuário</p>

      <form action="cadastrar.php" method="post">
        <div class="input-group mb-3">
          <input type="text" name="name" id="name" class="form-control" placeholder="Nome" onkeypress="verificar()" required >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" id="email" class="form-control" placeholder="Email" onkeypress="verificar()" required >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" name="cpf" id="cpf" class="form-control" placeholder="CPF" onkeypress="verificar()" required >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-file"></span>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <select name="grupo" id="grupo" class="form-control" onchange="verificar()" required >
            <option value=""> Selecione um grupo de usuário </option>
            <?php
              $sql = "SELECT * FROM groups ORDER BY name";
              $exec = mysqli_query($conn, $sql);
              while($row = mysqli_fetch_array($exec)){
                echo "<option value='".$row["id"]."'> ".$row["name"]." </option>";
              }
            ?>
          </select>

        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Senha" onkeyup="verificar()" onkeydown="verificar()" onkeypress="verificar()" required >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password2" id="password2" class="form-control" placeholder="Repita a Senha" onkeypress="verificar()" onkeyup="verificar()" onkeydown="verificar()" onkeypress="verificar()" required >
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
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" id="btn_cadastro" class="btn btn-primary btn-block" disabled >Cadastrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script>
  function verificar(){
    var nome = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var cpf = document.getElementById("cpf").value;
    var grupo = document.getElementById("grupo").value;
    var password = document.getElementById("password").value;
    var password2 = document.getElementById("password2").value;
    var msg_erro = document.getElementById("msg_erro");
    if(password != password2){
      msg_erro.innerHTML = "<font color='red' size='1' > *Senhas diferentes* </font>";
    }else{
      msg_erro.innerHTML = "";
    }

    if(nome != "" && email != "" && cpf != "" && grupo != "" && password != "" && password2 != "" && password == password2){
      document.querySelector("#btn_cadastro").removeAttribute("disabled");
    }else{
      document.getElementById("btn_cadastro").disabled = true;
    }

  }
</script>
</body>
</html>
