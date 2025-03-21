<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>V-Sheet</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Estilos personalizados */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
    }

    .navbar {
      background-color: #007bff;
      /* Azul vibrante */
    }

    .navbar-light .navbar-nav .nav-link {
      color: white;
    }

    .navbar-light .navbar-nav .nav-link:hover {
      color: #ddd;
    }

    section {
      padding: 80px 0;
    }

    #home {
      background: linear-gradient(135deg, #e0f7fa, #b2ebf2);
      /* Gradiente suave */
      text-align: center;
    }

    #sobre-sistema,
    #planos,
    #sobre-nos,
    #fale-conosco {
      background-color: #f8f9fa;
    }

    .card {
      border: none;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    footer {
      background-color: #343a40;
      color: white;
      text-align: center;
      padding: 20px 0;
    }

    footer a {
      color: #007bff;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }

    p {
      line-height: 1.9;
      /* Aumenta o espaçamento em 60% do tamanho da fonte */
    }

    h2 {
      line-height: 1.9;
      /* Aumenta o espaçamento em 60% do tamanho da fonte */
    }

    .modal-dialog {
      max-width: 80%;
      /* Ajuste a largura conforme necessário */
    }

    .modal-content {
      max-height: 80vh;
      /* Define um limite de altura baseado na viewport */
    }

    .modal-body {
      max-height: 60vh;
      /* Limita a altura do corpo da modal */
      overflow-y: auto;
      /* Ativa a rolagem vertical caso o conteúdo ultrapasse o limite */
    }
  </style>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->

</head>

<body>

  <!-- Menu de navegação -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
    <div class="container">
      <a class="navbar-brand" style="font-family: fantasy; color: #FFF;" href="#"><i>V-Sheet</i></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#usuarios-ativos">Usuários</a></li>
          <li class="nav-item"><a class="nav-link" href="#sobre-sistema">Sobre o Sistema</a></li>
          <li class="nav-item"><a class="nav-link" href="#planos">Planos</a></li>
          <li class="nav-item"><a class="nav-link" href="#funcionalidades">Funcionalidades</a></li>
          <li class="nav-item"><a class="nav-link" href="#sobre-nos">Sobre Nós</a></li>
          <li class="nav-item"><a class="nav-link" href="#fale-conosco">Fale Conosco</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Entrar</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section id="home">
    <div class="container">
      <h1>Bem-vindo ao V-Sheet</h1>
      <p>Soluções completas para criação e análise de dados.</p>
      <a href="#planos" class="btn btn-primary btn-lg">Veja nossos planos</a>
    </div>
  </section>

  <!-- Prova Social -->
  <section id="usuarios-ativos" style="background-color: #e9f5ff; padding: 60px 0;">
    <div class="container text-center">
      <h2>Usuários Ativos no V-Sheet</h2>
      <p>Veja quantas pessoas estão utilizando nosso sistema agora mesmo!</p>
      <?php
      $usuariosAtivos = 121;
      ?>
      <h1 style="font-size: 4rem; color: #007bff;"><?php echo number_format($usuariosAtivos); ?></h1>
      <p>Usuários ativos</p>
    </div>
  </section>


  <!-- Sobre o Sistema -->
  <section id="sobre-sistema">
    <div class="container">
      <h2 class="text-center">Sobre o Sistema</h2>
      <p class="text-center">
        O <b>V-Sheet</b> é uma plataforma inovadora que facilita a criação e gestão de dados sem exigir conhecimento técnico em planilhas como Excel. Com uma interface intuitiva e recursos inteligentes, qualquer pessoa pode organizar informações, criar cálculos, visualizar estatísticas e gerar relatórios de forma prática e eficiente.
      </p>

      <h2 class="text-center">O Que Fazemos</h2>

      <p> Nosso sistema permite que usuários de qualquer nível de experiência manipulem dados com facilidade. Você pode: </p>

      <p> ✅ Criar fórmulas personalizadas sem precisar conhecer funções complexas. </p>
      <p> ✅ Agrupar totais automaticamente, simplificando análises. </p>
      <p> ✅ Gerar gráficos dinâmicos para visualizar suas informações de forma clara. </p>
      <p> ✅ Compartilhar e colaborar em tempo real. </p>
      <p> ✅ Automatizar cálculos e relatórios, economizando tempo. </p>

      <h2 class="text-center">Vantagens do V-Sheet</h2>

      <p> 💡 Simplicidade: Desenvolvido para que qualquer pessoa possa gerenciar dados sem complicação. </p>
      <p> 🚀 Agilidade: Configuração rápida e intuitiva, sem necessidade de treinamentos. </p>
      <p> 📊 Visualização Inteligente: Gráficos e tabelas dinâmicas para facilitar a interpretação dos dados. </p>
      <p> 🔗 Acessível de Qualquer Lugar: Sistema online, sem necessidade de instalação. </p>
      <p> 🔒 Segurança e Confiabilidade: Seus dados protegidos com tecnologia moderna. </p>
      <p class="text-center" style="margin-top: 40px;"> Se você precisa de uma solução fácil e eficiente para organizar informações, tomar decisões com base em dados <br> e automatizar processos, o V-Sheet é a escolha certa para você! </p>
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

  <!-- Funcionalidades com Imagens -->
  <section id="funcionalidades" style="padding: 60px 0;">
    <div class="container">
      <h2 class="text-center">Funcionalidades do V-Sheet</h2>
      <p class="text-center">Descubra como o V-Sheet pode tornar a gestão de dados mais simples e eficiente.</p>

      <div class="row">
        <!-- Funcionalidade 1 -->
        <div class="col-md-6">
          <a href="#"><img src="dist/img/criar-tabelas.png" class="img-fluid rounded" alt="Criação fácil de tabelas"></a>
        </div>
        <div class="col-md-6">
          <h4>Criação Simples de Tabelas e Fórmulas</h4>
          <p>Com o V-Sheet, você pode criar tabelas e aplicar fórmulas complexas sem precisar conhecer Excel. Nossa interface intuitiva facilita a criação de contas e automação de cálculos.</p>
        </div>
      </div>

      <div class="row mt-5">
        <!-- Funcionalidade 2 -->
        <div class="col-md-6 order-md-2">
          <img src="dist/img/agrupar-dados.png" class="img-fluid rounded clickable-image" alt="Agrupamento de dados">
        </div>
        <div class="col-md-6 order-md-1">
          <h4>Agrupamento de Dados</h4>
          <p>Organize e agrupe seus dados de forma simples. Visualize totais, médias e outras estatísticas em poucos cliques.</p>
        </div>
      </div>

      <div class="row mt-5">
        <!-- Funcionalidade 3 -->
        <div class="col-md-6">
          <img src="dist/img/gerar-graficos.png" class="img-fluid rounded clickable-image" alt="Gráficos automáticos">
        </div>
        <div class="col-md-6">
          <h4>Gráficos Automáticos</h4>
          <p>Transforme seus dados em gráficos dinâmicos com apenas um clique. Visualize informações complexas de forma clara e rápida.</p>
        </div>
      </div>

      <div class="row mt-5">
        <!-- Funcionalidade 4 -->
        <div class="col-md-6 order-md-2">
          <img src="dist/img/upload-xls.png" class="img-fluid rounded clickable-image" alt="Upload de planilhas XLS">
        </div>
        <div class="col-md-6 order-md-1">
          <h4>Importação de Planilhas XLS</h4>
          <p>Possui dados em Excel? Sem problemas! Importe suas planilhas diretamente para o V-Sheet e comece a gerenciar seus dados em minutos.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal de Imagem -->
  <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel">Visualização da Imagem</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body text-center">
          <img id="modalImage" class="img-fluid" alt="Imagem ampliada">
        </div>
      </div>
    </div>
  </div>


  <!-- Sobre Nós -->
  <section id="sobre-nos">
    <div class="container">
      <h2 class="text-center">Sobre Nós</h2>

      <div class="row align-items-center">
        <div class="col-md-4">
          <img src="dist/img/eu.jpg" alt="Sua Foto" class="img-fluid rounded-circle">
        </div>
        <div class="col-md-8">
          <p>
            Volnei Prado, programador experiente e apaixonado por games, tecnologia e animes. A ideia de criar o V-Sheet surgiu da minha surpresa com a grande quantidade de clientes que precisavam de relatórios de dados, mas não sabiam utilizar nem as fórmulas básicas do Excel. Percebi a oportunidade de facilitar a vida dessas pessoas e me dediquei a este desafio. Acredito que a análise de dados pode ser acessível a todos, e é isso que me motiva a trabalhar no V-Sheet.
          </p>
        </div>
      </div>

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

  <!-- Modal Política de Privacidade -->
  <div class="modal fade" id="modalPrivacy" tabindex="-1" aria-labelledby="modalPrivacyLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPrivacyLabel">Política de Privacidade</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Última atualização: [Data]</p>
          <h3>1. Introdução</h3>
          <p>O V-Sheet valoriza sua privacidade e está comprometido em proteger seus dados. Esta Política explica como coletamos, usamos e armazenamos suas informações.</p>

          <h3>2. Dados Coletados</h3>
          <p>Podemos coletar informações pessoais como nome, e-mail e dados de uso para melhorar sua experiência no sistema.</p>

          <h3>3. Uso das Informações</h3>
          <p>Os dados são utilizados para fornecer nossos serviços, personalizar sua experiência e garantir a segurança do sistema.</p>

          <h3>4. Compartilhamento de Informações</h3>
          <p>Não compartilhamos seus dados com terceiros, exceto quando necessário para cumprir obrigações legais.</p>

          <h3>5. Segurança</h3>
          <p>Adotamos medidas técnicas para proteger suas informações contra acesso não autorizado.</p>

          <h3>6. Seus Direitos</h3>
          <p>Você pode solicitar a alteração ou remoção dos seus dados a qualquer momento.</p>

          <h3>7. Alterações</h3>
          <p>Esta política pode ser atualizada periodicamente. Notificaremos caso haja mudanças significativas.</p>

          <h3>8. Contato</h3>
          <p>Para dúvidas, entre em contato pelo e-mail [seu e-mail].</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Termos de Uso -->
  <div class="modal fade" id="modalTerms" tabindex="-1" aria-labelledby="modalTermsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTermsLabel">Termos de Uso</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Última atualização: [Data]</p>

          <h3>1. Aceitação dos Termos</h3>
          <p>Ao utilizar o V-Sheet, você concorda com estes Termos. Caso não concorde, não utilize o sistema.</p>

          <h3>2. Uso do Sistema</h3>
          <p>O V-Sheet deve ser utilizado apenas para fins legais. É proibido usar o sistema para atividades fraudulentas ou ilícitas.</p>

          <h3>3. Cadastro</h3>
          <p>Para acessar alguns recursos, pode ser necessário criar uma conta, fornecendo informações verdadeiras e atualizadas.</p>

          <h3>4. Propriedade Intelectual</h3>
          <p>O V-Sheet e seu conteúdo são protegidos por direitos autorais. Você não pode copiar, modificar ou distribuir sem autorização.</p>

          <h3>5. Responsabilidades</h3>
          <p>Não nos responsabilizamos por danos causados pelo uso indevido do sistema.</p>

          <h3>6. Alterações</h3>
          <p>Podemos modificar estes Termos a qualquer momento. O uso contínuo do sistema após alterações implica aceitação dos novos termos.</p>

          <h3>7. Contato</h3>
          <p>Para dúvidas, entre em contato pelo e-mail [seu e-mail].</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <footer style="background-color: #EEE; text-align: center; padding: 15px;">
    <p style="color: #000; font-weight: bold;">VOLNEI LUIZ CAMPOS PRADO 40.905.140/0001-23</p>
    <a href="#" data-bs-toggle="modal" data-bs-target="#modalPrivacy">Política de Privacidade</a> |
    <a href="#" data-bs-toggle="modal" data-bs-target="#modalTerms">Termos de Uso</a>
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

    document.addEventListener('DOMContentLoaded', function() {
      const images = document.querySelectorAll('.clickable-image');
      const modalImage = document.getElementById('modalImage');
      const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));

      images.forEach(image => {
        image.addEventListener('click', function() {
          modalImage.src = this.src;
          modalImage.alt = this.alt;
          imageModal.show();
        });
      });
    });
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
