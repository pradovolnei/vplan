<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>V-Plan</title>
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
      <a class="navbar-brand" href="#"><i>V-Plan</i></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#sobre-sistema">Sobre o Sistema</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#planos">Planos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#sobre-nos">Sobre Nós</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#fale-conosco">Fale Conosco</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Home -->
  <section id="home" class="bg-light">
    <div class="container">
      <!-- Conteúdo da home -->
    </div>
  </section>

  <!-- Sobre o Sistema -->
  <section id="sobre-sistema">
    <div class="container">
      <h2 class="text-center">Sobre o Sistema</h2>
      <p class="text-center">Nosso sistema oferece uma solução completa para gerenciamento de negócios, com foco em automatização e otimização de processos, proporcionando maior eficiência e resultados para sua empresa.</p>
    </div>
  </section>

  <!-- Planos -->
  <section id="planos" class="bg-light">
    <div class="container">
      <h2 class="text-center">Planos</h2>
      <div class="row">
        <div class="col-md-6">
          <div class="card h-100 d-flex flex-column justify-content-between">
            <div class="card-body">
              <h5 class="card-title">Plano Padrão</h5>
              <p class="card-text">R$ 36,00/mês (R$ 1,20/dia)</p>
              <ul>
                <li>Importar Planilhas XLS/XLSX</li>
                <li>Exportar Relatórios em XLS e PDF</li>
                <li>Gerar Gráficos</li>
                <li>Suporte Básico</li>
              </ul>
            </div>
            <div class="card-footer text-center">
              <a href="#" class="btn btn-primary" data-toggle='modal' data-target='#modal-saldo'>Assinar</a>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card h-100 d-flex flex-column justify-content-between">
            <div class="card-body">
              <h5 class="card-title">Plano Customizado</h5>
              <p class="card-text">Valor a Combinar</p>
              <ul>
                <li>Domínio Próprio</li>
                <li>Funcionalidades Extras do Seu Interesse</li>
                <li>Novas Telas Com conteúdos de Seu Interesse</li>
                <li>Layouts Customizados</li>
                <li>Suporte Avançado</li>
              </ul>
            </div>
            <div class="card-footer text-center">
              <a href="#fale-conosco" class="btn btn-primary" onclick="solicitaOrcamento()">Solicitar Orçamento</a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>


  <!-- Sobre Nós -->
  <section id="sobre-nos">
    <div class="container">
      <h2 class="text-center">Sobre Nós</h2>
      <p class="text-center">Somos uma equipe dedicada ao desenvolvimento de soluções inovadoras para empresas de todos os portes, sempre focados em entregar a melhor experiência para nossos clientes.</p>
    </div>
  </section>

  <!-- Fale Conosco -->
  <section id="fale-conosco" class="bg-light">
    <div class="container">
      <h2 class="text-center">Fale Conosco</h2>
      <form action="mail.php" method="POST">
        <div class="mb-3">
          <label for="nome" class="form-label">Nome</label>
          <input type="text" class="form-control" name="nome" id="nome" placeholder="Seu nome" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">E-Mail</label>
          <input type="email" class="form-control" name="email" id="email" placeholder="Seu e-mail" required>
        </div>
        <div class="mb-3">
          <label for="assunto" class="form-label">Assunto</label>
          <select name="assunto" id="assunto" class="form-control" required>
            <option value=""></option>
            <option value="Dúvidas">Dúvidas</option>
            <option value="Orçamento">Orçamento</option>
            <option value="Suporte Técnico">Suporte Técnico</option>
            <option value="Outros">Outros</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="mensagem" class="form-label">Mensagem</label>
          <textarea class="form-control" id="mensagem" name="mensagem" rows="3" required placeholder="Digite sua mensagem"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
      </form>
      <?php if (isset($_GET["c"])) { ?>
        <h5 style="color: #0A0;"> Recebemos a sua mensagem!</h5>
        <h6 style="color: #0A0;">Em breve, nossa equipe entrará em contato. </h6>
      <?php } ?>
    </div>
  </section>

  <!-- Modal -->
  <div class="modal fade" id="modal-saldo">
    <div class="modal-dialog">
      <form action="?l=<?= base64_encode(19) ?>" method="POST" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h4 class="modal-title">Escolha a Forma de Pagamento</h4>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container">
              <div class="form-group text-center">
                <div class="d-flex justify-content-center gap-3">
                  <a href="pagamento.php?p" class="w-50">
                    <label class="btn btn-outline-success p-3 d-flex flex-column align-items-center justify-content-center w-100">
                      <img src="dist/img/pix.png" style="filter: brightness(2.0);" alt="Pix" width="50">
                      <br>Pix
                    </label>
                  </a>
                  <a href="pagamento.php?c" class="w-50">
                    <label class="btn btn-outline-primary p-3 d-flex flex-column align-items-center justify-content-center w-100">
                      <img src="dist/img/cred.png" alt="Cartão de Crédito" width="50">
                      <br>Cartão de Crédito
                    </label>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </form>
    </div>
  </div>

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
</body>

</html>
