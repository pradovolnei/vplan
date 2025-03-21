<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>V-Sheet</title>
  <link rel="icon" href="dist/img/logo-sheet-mini.png" type="image/png">
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

    /*footer {
      padding: 20px 0;
      background-color: #f8f9fa;
      text-align: center;
    }*/

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
  <form method="POST" action="confirm_pix.php">
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
                    <span id="msg"></span>
                  </div>
                  <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="" required>
                  </div>
                  <button type="submit" id="submitBtn" class="btn btn-primary w-100">Pagar</button>
                </div>
              </div>
            </div>
          </div>

          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="card">

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </form>

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

  <!-- Rodapé -->
  <footer style="background-color: #EEE; ">
    <p style="color: #000;">VOLNEI LUIZ CAMPOS PRADO 40.905.140/0001-23</p>
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

</body>

</html>
