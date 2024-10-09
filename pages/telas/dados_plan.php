

<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

$id_plan = base64_decode($_GET["p"]);

$sql_titulo = "SELECT * FROM data_plans WHERE plan_id=$id_plan";
$colunas = [];
$totalColunas = 0;
$totalLinhas = 0;
$dadosTabela = [];
$exec_titulo = mysqli_query($conn, $sql_titulo);
while($row = mysqli_fetch_array($exec_titulo)){
  if($row["number_line"] == 0)
    $colunas[] = htmlspecialchars($row["value"]);

    $dadosTabela[$row["number_column"]][$row["number_line"]] = $row["value"];
    $totalColunas = $row["number_column"];
    $totalLinhas = $row["number_line"];
}

function exibirPlanilhaComoTabela($dadosTabela, $colunas, $totalColunas, $totalLinhas) {
  $modalTable1 = '
  <section class="content" style="margin-top: 20px;">

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Default box -->
          <div class="card collapsed-card">
            <div class="card-header">
              <h3 class="card-title">Title</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-plus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body" style="display: none;">
              ';

$modalTable2 = '
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
';


        echo $modalTable1;
        // Início da tabela HTML
        echo '<table id="planilhaTabela" class="table table-bordered">';
        //$colunas = [];
        echo "<thead><tr>";
        foreach($colunas as $coluna) {
          echo "<th>" . htmlspecialchars($coluna) . "</th>";
        }
        echo "</tr></thead>";

        echo "<tbody>";

        for($linha = 1; $linha <= $totalLinhas; $linha++) {
          echo "<tr>";
          for($coluna = 0; $coluna <= $totalColunas; $coluna++) {
            $valor = isset($dadosTabela[$coluna][$linha]) ? htmlspecialchars($dadosTabela[$coluna][$linha]) : '';
            echo "<td>" . $valor . "</td>";
          }
          echo "</tr>";
        }

        echo "</tbody>";

        // Fim da tabela HTML
        echo '</table>';
        echo $modalTable2;

        // Gerar opções dinâmicas para o select com base nos cabeçalhos da planilha
        echo '<label for="eixoX">Selecione o campo para o eixo X:</label>';
        echo '<select id="eixoX" class="form-control">';
        foreach ($colunas as $coluna) {
            echo '<option value="' . $coluna . '">' . $coluna . '</option>';
        }
        echo '</select>';

        echo '<label for="eixoY">Selecione os campos para o eixo Y:</label>';
        echo '<select id="eixoY" class="form-control" multiple>';
        foreach ($colunas as $coluna) {
            echo '<option value="' . $coluna . '">' . $coluna . '</option>';
        }
        echo '</select>';
}

exibirPlanilhaComoTabela($dadosTabela, $colunas, $totalColunas, $totalLinhas);
?>

<!-- Inclusão do Bootstrap e Chart.js via CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Seleção de tipo de gráfico -->
<div class="container mt-4">
    <label for="tipoGrafico">Selecione o tipo de gráfico:</label>
    <select id="tipoGrafico" class="form-control">
        <option value="bar">Barra</option>
        <option value="line">Linha</option>
        <option value="pie">Pizza</option> <!-- Nova opção de gráfico de pizza -->
    </select>

    <!-- Canvas onde o gráfico será renderizado -->
    <canvas id="graficoCanvas" class="mt-4"></canvas>
</div>


<!-- Script para manipular a geração dos gráficos -->
<script>
	let chartInstance = null;

	function gerarGrafico() {
		var tipoGrafico = document.getElementById('tipoGrafico').value;
		var eixoX = document.getElementById('eixoX').value;
		var eixoYSelect = document.getElementById('eixoY');
		var eixoY = Array.from(eixoYSelect.selectedOptions).map(option => option.value); // Pegando todos os campos selecionados no eixo Y

		// Limitar a seleção de campos Y no gráfico de pizza
		if (tipoGrafico === 'pie' && eixoY.length > 1) {
			alert('O gráfico de pizza só pode exibir um campo no eixo Y.');
			return;
		}

		// Pegando os dados da tabela
		var tabela = document.getElementById('planilhaTabela');
		var colunas = tabela.rows[0].cells;
		var xIndex;
		var yIndices = [];

		// Descobrir o índice da coluna selecionada para o eixo X
		for (var i = 0; i < colunas.length; i++) {
			if (colunas[i].innerText == eixoX) xIndex = i;
		}

		// Descobrir os índices das colunas selecionadas para o eixo Y
		for (var i = 0; i < colunas.length; i++) {
			if (eixoY.includes(colunas[i].innerText)) yIndices.push(i);
		}

		var labels = [];
		var datasets = [];

		// Iterar sobre as linhas da tabela para coletar os dados
		for (var i = 1; i < tabela.rows.length; i++) {
			labels.push(tabela.rows[i].cells[xIndex].innerText);
		}

		if (tipoGrafico === 'pie') {
			// Gerar dados para o gráfico de pizza
			var dados = [];
			for (var i = 1; i < tabela.rows.length; i++) {
				dados.push(parseFloat(tabela.rows[i].cells[yIndices[0]].innerText));
			}

			datasets.push({
				label: eixoY[0],
				data: dados,
				backgroundColor: [
					'rgba(255, 99, 132, 0.6)',
					'rgba(54, 162, 235, 0.6)',
					'rgba(255, 206, 86, 0.6)',
					'rgba(75, 192, 192, 0.6)',
					'rgba(153, 102, 255, 0.6)',
					'rgba(255, 159, 64, 0.6)'
				],
				borderColor: [
					'rgba(255, 99, 132, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 159, 64, 1)'
				],
				borderWidth: 1
			});
		} else {
			// Criar datasets dinâmicos para cada campo do eixo Y (gráficos de barra e linha)
			yIndices.forEach((yIndex, idx) => {
				var dados = [];
				for (var i = 1; i < tabela.rows.length; i++) {
					dados.push(parseFloat(tabela.rows[i].cells[yIndex].innerText));
				}

				// Adicionar dataset
				datasets.push({
					label: eixoY[idx],
					data: dados,
					backgroundColor: 'rgba(75, 192, 192, 0.2)',
					borderColor: 'rgba(75, 192, 192, 1)',
					borderWidth: 1
				});
			});
		}

		// Se houver um gráfico anterior, destrua-o para não sobrepor
		if (chartInstance) {
			chartInstance.destroy();
		}

		// Configuração do gráfico
		var ctx = document.getElementById('graficoCanvas').getContext('2d');
		chartInstance = new Chart(ctx, {
			type: tipoGrafico,
			data: {
				labels: labels,
				datasets: datasets // Usando os datasets gerados dinamicamente
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});

		// Ajustar opções para gráfico de pizza
		if (tipoGrafico === 'pie') {
			chartInstance.options.scales = {}; // Remove as escalas do gráfico de pizza
		}
	}

	// Eventos onchange para os selects
	document.getElementById('tipoGrafico').addEventListener('change', gerarGrafico);
	document.getElementById('eixoX').addEventListener('change', gerarGrafico);
	document.getElementById('eixoY').addEventListener('change', gerarGrafico);

	// Gerar gráfico inicialmente
	gerarGrafico();

</script>
