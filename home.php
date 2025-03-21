<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>V-SHEET</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="icon" href="dist/img/logo-sheet-mini.png" type="image/png">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/jsgrid/jsgrid.min.css">
  <link rel="stylesheet" href="plugins/jsgrid/jsgrid-theme.min.css">

  <script src="https://sdk.mercadopago.com/js/v2"></script>

</head>
<body class="hold-transition sidebar-collapse layout-top-nav">
  <?php
    include ("connect.php");
    include ("session.php");
    include ("functions.php");
    require 'vendor/autoload.php';

  ?>
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="home.php" class="navbar-brand">
        <img src="dist/img/logo-sheet-mini.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>V-Sheet</b></span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="home.php" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="index.php#fale-conosco" class="nav-link">Contato</a>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Configurações</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="?l=<?=base64_encode(16)?>" class="dropdown-item">Dados de usuários </a></li>
              <li><a href="?l=<?=base64_encode(21)?>" class="dropdown-item">Histórico de pagamnetos </a></li>
              <li><a href="logout.php" class="dropdown-item">Logout</a></li>

              <!-- End Level two -->
            </ul>
          </li>
        </ul>

        <!-- SEARCH FORM -->
        <form action="" method="GET" class="form-inline ml-0 ml-md-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" name="s" type="search" placeholder="Pesquisar" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>
      </div>

    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->

    <?php

      if(isset($_GET["l"]))
        $link = base64_decode($_GET["l"]);
      else
        $link = 0;

      if($link != 16 && $link != 19 && $link != 20){
        $data_atual = new DateTime(date("Y-m-d"));

        $data_expira = new DateTime($_SESSION["expiration"]);

        $diferenca = $data_atual->diff($data_expira);

        if ($diferenca->invert) {
          if($_SESSION["type"] == 1){
            echo "<script> window.location='home.php?l=".base64_encode(16)."'; </script>";
          }else {
            echo "<script> alert('Conta expirada! Entre em contato com sua gerência.'); window.location='logout.php'; </script>";
          }

        }
      }

      $page[0] = "pages/telas/resum.php";
      $page[1] = "pages/telas/plan.php";
      $page[2] = "pages/telas/import.php";
      $page[3] = "pages/telas/processar_upload.php";
      $page[4] = "pages/telas/dados_plan.php";
      $page[5] = "pages/telas/code.php";
      $page[6] = "pages/telas/save_plan.php";
      $page[7] = "pages/telas/remove_plan.php";
      $page[8] = "pages/telas/registro_manual.php";
      $page[9] = "pages/telas/remove_line.php";
      $page[10] = "pages/telas/tabela_manual.php";
      $page[11] = "pages/telas/nova_formula.php";
      $page[12] = "pages/telas/remove_formula.php";
      $page[13] = "pages/telas/exibe_listas.php";
      $page[14] = "pages/telas/salva_listas.php";
      $page[15] = "pages/telas/edita_linha.php";
      $page[16] = "pages/telas/perfil.php";
      $page[17] = "pages/telas/save_perfil.php";
      $page[18] = "pages/telas/altera_status.php";
      $page[19] = "pages/telas/pay_method.php";
      $page[20] = "pages/telas/pix_confirm.php";
      $page[21] = "pages/telas/pay_list.php";
      $page[22] = "pages/telas/pay_cred.php";
      $page[23] = "pages/telas/details_pay.php";
      $page[24] = "pages/telas/save_assis.php";

      include $page[$link];
    ?>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">

    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2025 <a href="#" >Volnei Prado 40.905.140/0001-23</a>.</strong> Todos os direitos reservados.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

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

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<!-- Script para manipular os dados -->
<script>
  $(document).ready(function() {
    // Quando o link de abrir modal for clicado
    $('.open-modal-edit').on('click', function() {
      // Pegando os valores dos atributos data-id e data-nome do link clicado
      var id = $(this).data('id');
      var nome = $(this).data('nome');
      var obs = $(this).data('obs');

      // Preenchendo os campos da modal com os valores capturados
      $('#id_plan').val(id);  // Campo hidden para o ID
      $('#name_plan').val(nome); // Campo de nome da planilha
      $('#obs_plan').val(obs);

    });
  });
</script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

</body>
</html>
