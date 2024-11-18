<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Apresentação do Sistema - V-Plan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      scroll-behavior: smooth;
      font-family: Arial, sans-serif;
    }
    .hero-section {
      background: linear-gradient(135deg, #007bff, #0056b3);
      color: white;
      padding: 80px 0;
      text-align: center;
    }
    .hero-section h1 {
      font-size: 3em;
      font-weight: bold;
    }
    .hero-section p {
      font-size: 1.2em;
      margin-top: 10px;
    }
    .btn-primary {
      background-color: #ffc107;
      border: none;
      font-weight: bold;
    }
    .features, .testimonials, .faq {
      padding: 60px 0;
    }
    .feature-icon {
      font-size: 2em;
      color: #007bff;
    }
    .testimonials {
      background-color: #f8f9fa;
    }
    .faq .accordion-button {
      background-color: #007bff;
      color: white;
    }
    footer {
      padding: 20px 0;
      background-color: #343a40;
      color: white;
      text-align: center;
    }
  </style>
</head>
<body>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container">
      <h1>Bem-vindo ao V-Plan</h1>
      <p>O sistema inovador para gerenciamento eficiente de projetos e dados</p>
      <a href="#features" class="btn btn-primary btn-lg mt-3">Saiba Mais</a>
    </div>
  </section>

  <!-- Menu de navegação -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">V-Plan</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#features">Funcionalidades</a></li>
          <li class="nav-item"><a class="nav-link" href="#testimonials">Depoimentos</a></li>
          <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contato</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Funcionalidades -->
  <section id="features" class="features text-center">
    <div class="container">
      <h2>Funcionalidades do V-Plan</h2>
      <p>Descubra como nosso sistema pode ajudar no sucesso dos seus projetos</p>
      <div class="row mt-4">
        <div class="col-md-4">
          <div class="feature-icon mb-3">🔒</div>
          <h5>Segurança</h5>
          <p>Proteção avançada para seus dados com criptografia de ponta a ponta.</p>
        </div>
        <div class="col-md-4">
          <div class="feature-icon mb-3">⚡</div>
          <h5>Desempenho</h5>
          <p>Rápido e eficiente, otimizando tempo e reduzindo o esforço.</p>
        </div>
        <div class="col-md-4">
          <div class="feature-icon mb-3">📊</div>
          <h5>Relatórios Personalizados</h5>
          <p>Visualize o progresso com relatórios detalhados e customizáveis.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Depoimentos -->
  <section id="testimonials" class="testimonials text-center">
    <div class="container">
      <h2>O que nossos clientes dizem</h2>
      <div class="row mt-4">
        <div class="col-md-6">
          <blockquote class="blockquote">
            <p>"O V-Plan transformou nossa forma de trabalhar, aumentando a eficiência em mais de 40%!"</p>
            <footer class="blockquote-footer">Ana Silva, <cite title="Source Title">Gerente de Projetos</cite></footer>
          </blockquote>
        </div>
        <div class="col-md-6">
          <blockquote class="blockquote">
            <p>"Um sistema intuitivo e seguro que facilitou o gerenciamento de dados na empresa."</p>
            <footer class="blockquote-footer">Carlos Mendes, <cite title="Source Title">CEO da Tech Solutions</cite></footer>
          </blockquote>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section id="faq" class="faq">
    <div class="container">
      <h2>Perguntas Frequentes</h2>
      <div class="accordion mt-4" id="faqAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header" id="faq1">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne" aria-expanded="true" aria-controls="faqOne">
              Como posso começar a usar o V-Plan?
            </button>
          </h2>
          <div id="faqOne" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Você pode começar se registrando em nossa página inicial e configurando seu primeiro projeto.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="faq2">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
              O sistema é seguro?
            </button>
          </h2>
          <div id="faqTwo" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Sim, nosso sistema utiliza criptografia de ponta a ponta para garantir a segurança dos seus dados.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <p>&copy; 2024 V-Plan. Todos os direitos reservados.</p>
      <p><a href="#hero" class="text-white">Voltar ao topo</a></p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
