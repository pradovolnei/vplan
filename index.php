<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Apresentação do Sistema</title>
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
</head>
<body>

  <!-- Menu de navegação -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">V-Plan</a>
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
            <a class="nav-link" href="#sobre-nos">Sobre Mim</a>
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
      <p class="text-center">
        V-Plan oferece possibilidade para criação de planilhas web, tratando dados, criando fórmulas e gráficos sem a necessidade de conhecimento em excel.
        <br>
        Você pode também trazer suas planilhas xls para nossa plataforma e deixá-las mais completa.
      </p>
    </div>
  </section>

	<!-- Planos -->
	<section id="planos" class="bg-light">
	  <div class="container">
		<h2 class="text-center">Planos</h2>
		<div class="row">
		  <div class="col-md-3">
			<div class="card h-100 d-flex flex-column justify-content-between">
			  <div class="card-body">
				<h5 class="card-title">Plano Básico</h5>
				<p class="card-text">R$ 29,90/mês</p>
				<ul>
				  <li>Grupo com 1 usuário (1 Nível Administrador) </li>
				  <li>Limite de 10 planilhas</li>
				  <li>Suporte online</li>
				</ul>
			  </div>
			  <div class="card-footer text-center">
				<a href="#" class="btn btn-primary">Assinar</a>
			  </div>
			</div>
		  </div>
		  <div class="col-md-3">
			<div class="card h-100 d-flex flex-column justify-content-between">
			  <div class="card-body">
				<h5 class="card-title">Plano Intermediário</h5>
				<p class="card-text">R$ 49,90/mês</p>
				<ul>
				  <li>Grupo com 2 usuários (1 Nível Administrador + 1 Nível Visualizador) </li>
				  <li>Limite de 30 planilhas</li>
				  <li>Suporte online</li>
				</ul>
			  </div>
			  <div class="card-footer text-center" >
				<a href="#" class="btn btn-primary">Assinar</a>
			  </div>
			</div>
		  </div>
		  <div class="col-md-3">
			<div class="card h-100 d-flex flex-column justify-content-between">
			  <div class="card-body">
				<h5 class="card-title">Plano Avançado</h5>
				<p class="card-text">R$ 69,90/mês</p>
				<ul>
				  <li>Grupo com 5 usuários (1 Nível Administrador + 4 Nível Visualizador)</li>
				  <li>Planilhas Ilimitadas</li>
				  <li>Suporte online</li>
				</ul>
			  </div>
			  <div class="card-footer text-center">
				<a href="#" class="btn btn-primary">Assinar</a>
			  </div>
			</div>
		  </div>
      <div class="col-md-3">
			<div class="card h-100 d-flex flex-column justify-content-between">
			  <div class="card-body">
				<h5 class="card-title">Plano Customisado</h5>
				<p class="card-text">Valor a combinar</p>
				<ul>
				  <li>Grupo com usuários ilimitados</li>
				  <li>Planilhas Ilimitadas</li>
          <li>Fórmulas específicas e exclusivas para o seu perfil </li>
          <li>Seu próprio Dashboard </li>
				  <li>Suporte online</li>
				</ul>
			  </div>
			  <div class="card-footer text-center">
				<a href="#" class="btn btn-primary">Assinar</a>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</section>


  <!-- Sobre Nós -->
  <section id="sobre-nos">
    <div class="container">
      <h2 class="text-center">Sobre Mim</h2>
      <p class="text-center">
        Me chamo Volnei Luiz Campos Prado. <br> Sou um programador formado em TI que decidiu sair da CLT pra conquistar o mundo com seus próprios projetos.<br>

      </p>
      <p class="text-center">
        <a href="https://www.linkedin.com/in/volnei-luiz-campos-prado-036659bb/" target="_blank"> Me acompanho no Linkedin </a>
      </p>
    </div>
  </section>

  <!-- Fale Conosco -->
  <section id="fale-conosco" class="bg-light">
    <div class="container">
      <h2 class="text-center">Fale Conosco</h2>
      <form>
        <div class="mb-3">
          <label for="nome" class="form-label">Nome</label>
          <input type="text" class="form-control" id="nome" placeholder="Seu nome">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input type="email" class="form-control" id="email" placeholder="Seu e-mail">
        </div>
        <div class="mb-3">
          <label for="mensagem" class="form-label">Mensagem</label>
          <textarea class="form-control" id="mensagem" rows="3" placeholder="Digite sua mensagem"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
      </form>
    </div>
  </section>

  <!-- Rodapé -->
  <footer style="background-color: #EEE" >
    <p>Volnei Luiz Campos Prado</p>
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
  </script>
</body>
</html>
