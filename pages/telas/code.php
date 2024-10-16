<?php
  $id_plan = base64_decode($_GET["p"]);
  $id_nivel = $_SESSION["type"];

  $sql_pan = "SELECT * FROM plans WHERE id=$id_plan AND group_id=".$_SESSION["group_id"];
  $exec_plan = mysqli_query($conn, $sql_pan);
  if(mysqli_num_rows($exec_plan) <= 0){
    echo "<script> window.location='home.php' </script>";
  }

  $sql_titulo = "SELECT * FROM data_plans WHERE plan_id=$id_plan";
  $colunas = [];
  $totalColunas = 0;
  $totalLinhas = 0;
  $dadosTabela = [];
  $exec_titulo = mysqli_query($conn, $sql_titulo);
  if(mysqli_num_rows($exec_titulo) > 0){
    while($row = mysqli_fetch_array($exec_titulo)){
      if($row["number_line"] == 0)
        $colunas[] = htmlspecialchars($row["value"]);

        $dadosTabela[$row["number_column"]][$row["number_line"]] = $row["value"];
        $totalColunas = $row["number_column"];
        $totalLinhas = $row["number_line"];
    }
  }else{
    echo "<script> window.location='home.php' </script>";
  }

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div style="display: none;">

  <table id="salesTable" class="table table-bordered">
    <thead>
      <tr>
      <?php
        foreach($colunas as $coluna) {
          echo "<th>" . htmlspecialchars($coluna) . "</th>";
        }
      ?>
    </tr>
    </thead>
    <tbody>
        <?php
          for($linha = 1; $linha <= $totalLinhas; $linha++) {
            echo "<tr>";
            for($coluna = 0; $coluna <= $totalColunas; $coluna++) {
              $valor = isset($dadosTabela[$coluna][$linha]) ? htmlspecialchars($dadosTabela[$coluna][$linha]) : '';
              echo "<td>" . $valor . "</td>";
            }
            echo "</tr>";
          }
        ?>
    </tbody>
  </table>
</div>

<section class="content" style="margin-top: 20px;">

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Default box -->
          <div class="card collapsed-card">
            <div class="card-header">
              <h3 class="card-title">Dados da Tabela</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
            <div class="card-body" style="display: none;">
              <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                <div class="col-6">
                  <select id="total_reg" name="total_reg" onChange="groupSalesByField()" class="form-control">
                    <option value=""> Total de </option>
                    <option value="-1"> Total de Linhas </option>
                    <?php
                      $xColum = 0;
                      foreach($colunas as $coluna) {
                        echo "<option value='$xColum'>Total de " . htmlspecialchars($coluna) . "</option>";
                        $xColum++;
                      }
                    ?>
                  </select>
                </div>

                <div class="col-6">
                  <select id="group_by" name="group_by" onChange="groupSalesByField()" class="form-control">
                    <option value=""> Agrupar por </option>
                    <?php
                      $xColum = 0;
                      foreach($colunas as $coluna) {
                        echo "<option value='$xColum--$coluna'>Agrupar por " . htmlspecialchars($coluna) . "</option>";
                        $xColum++;
                      }
                    ?>
                  </select>
                </div>


              </div>
              <?php if($id_nivel == 1){ ?>
              <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                <div class="col-6">
                  <a href="#" class="btn btn-block btn-outline-info" data-toggle='modal' data-target='#modal-insert' > Inserir linha </a>
                </div>
                <div class="col-6">
                  <a href="#" class="btn btn-block btn-outline-info" data-toggle='modal' data-target='#modal-formula' > Inserir cálculo </a>
                </div>
              </div>
              <?php } ?>

            <div id="result" class="card-body table-responsive p-0">
              <table id="planilhaTabela" class="table table-bordered">
                <thead>
                  <tr>
                    <th> Linha </th>
                  <?php
                    foreach($colunas as $coluna) {
                      echo "<th>" . htmlspecialchars($coluna) . "</th>";
                    }
                  ?>
                </tr>
                </thead>
                <tbody>
                    <?php
                      for($linha = 1; $linha <= $totalLinhas; $linha++) {
                        echo "<tr>";
                        echo "<td> ";
                        if($id_nivel == 1){
                        ?>
                          <a href='#' style="font-size: 0.7rem; color: #F00" onclick='confirmDeleteLine(event, "<?=base64_encode(9)?>", "<?=base64_encode($id_plan)?>", <?=$linha?>)'> <i class='nav-icon fas fa-trash'></i> </a>
                        <?php
                        }
                        echo " ".$linha;
                        echo "</td>";
                        for($coluna = 0; $coluna <= $totalColunas; $coluna++) {
                          $valor = isset($dadosTabela[$coluna][$linha]) ? htmlspecialchars($dadosTabela[$coluna][$linha]) : '';
                          echo "<td>" . $valor . "</td>";
                        }
                        echo "</tr>";
                      }
                    ?>
                </tbody>
              </table>
            </div>
          </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>

<section class="content" style="margin-top: 20px;">

  <div class="container-fluid">
    <div id="eixos">
      <div class="row">
        <div class="col-3"></div>
        <div class="col-3">
          <select id="eixoX" class="form-control">
            <option >Eixo X</option>
            <?php
              foreach($colunas as $coluna) {
                echo "<option value='$coluna'>" . htmlspecialchars($coluna) . "</option>";
              }
            ?>

          </select>
        </div>

        <div class="col-3">
          <select id="eixoY" class="form-control">
            <option >Eixo Y</option>
            <?php
              foreach($colunas as $coluna) {
                echo "<option value='$coluna'>" . htmlspecialchars($coluna) . "</option>";
              }
            ?>

          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <!-- Seleção de tipo de gráfico -->
        <div class="container mt-4">
            <label for="tipoGrafico">Selecione o tipo de gráfico:</label>
            <select id="tipoGrafico" class="form-control">
                <option value="">Selecione um Gráfico</option>
                <option value="bar">Barra</option>
                <option value="line">Linha</option>
                <option value="pie">Pizza</option> <!-- Nova opção de gráfico de pizza -->
            </select>

            <!-- Canvas onde o gráfico será renderizado -->
            <canvas id="graficoCanvas" class="mt-4"></canvas>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Modal -->
<div class="modal fade" id="modal-insert">
  <div class="modal-dialog">
    <form action="?l=<?=base64_encode(8)?>" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Registro Manual Linha <?=$totalLinhas+1?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card-body">
            <!-- Campo hidden para o ID -->
            <input type="hidden" class="form-control" name="id" value="<?=$id_plan?>">
            <input type="hidden" class="form-control" name="new_line" value="<?=$totalLinhas+1?>">

            <?php
              $xColum = 0;
              foreach($colunas as $coluna) {
                echo '<div class="form-group row">';
                echo '<input type="text" class="form-control" name="valor[]" placeholder="'.$coluna.'">';
                echo '</div>';
              }
            ?>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </form>
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-formula">
  <div class="modal-dialog">
    <form action="?l=<?=base64_encode(11)?>" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Nova Fórmula</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card-body">
            <!-- Campo hidden para o ID -->
            <input type="hidden" class="form-control" name="id" value="<?=$id_plan?>">

            <div class="row">
              <div class="col-12">
                <select name="numerador" name="numerador" > 
                  <option value> </option>
                </select>
              </div>
            </div>
            <?php
              $xColum = 0;
              foreach($colunas as $coluna) {
                echo '<div class="form-group row">';
                echo '<input type="text" class="form-control" name="valor[]" placeholder="'.$coluna.'">';
                echo '</div>';
              }
            ?>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </form>
  </div>
  <!-- /.modal-dialog -->
</div>


<script>
function groupSalesByField() {
  const table = document.getElementById("salesTable");
  const rows = table.getElementsByTagName("tr");
  const salesData = {};

  let campos = document.getElementById("group_by").value;
  let array = campos.split("--");
  var campo = array[0];
  var nomecampo = array[1];

  var regs = document.getElementById("total_reg");
  var total_reg = regs.value;

  if(total_reg != "" && campo != ""){

    // Ignorar o cabeçalho (primeira linha) e iterar sobre as linhas de dados
    for (let i = 1; i < rows.length; i++) {
      const cells = rows[i].getElementsByTagName("td");
      const groupKey = cells[campo].textContent;  // A chave é o campo pelo qual você quer agrupar

      let total = 0;

      if (total_reg == "-1") {
        // Se total_reg for -1, simplesmente contamos as ocorrências
        total = 1;
      } else {
        // Caso contrário, somamos o valor escolhido (valor de venda ou quantidade)
        total = parseFloat(cells[total_reg].textContent);
      }

      // Agrupar por campo selecionado e somar os valores
      if (salesData[groupKey]) {
        salesData[groupKey] += total;
      } else {
        salesData[groupKey] = total;
      }
    }

    // Ordenar as chaves (produtos ou datas)
    const sortedKeys = Object.keys(salesData).sort();  // Ordenação alfabética por chave

    // Exibir o resultado em uma tabela
    let resultHtml = `<h3>Agrupado</h3>`;
    resultHtml += `
                  <div class="row">
                  <div class="col-12">
                  <table id="planilhaTabela" class="table table-bordered">
                     <thead><tr>
                       <th>`+nomecampo+`</th>
                       <th>Total</th>
                     </tr></thead>`;
    sortedKeys.forEach(key => {
      resultHtml += `<tr>
                       <td>${key}</td>
                       <td> ${salesData[key].toFixed(2)}</td>
                     </tr>`;
    });
    resultHtml += "</table> </div> </div>";
    resultHtml += "<div class='row' >";
    resultHtml += " <div class='col-4'> <a href='' class='btn btn-warning'> Desagrupar Tabela </a> </div> ";
    resultHtml += " <div class='col-4'> <button id='downloadXLS' onclick='baixarXls()' class='btn btn-success'>Baixar XLS</button> </div> ";
    resultHtml += " <div class='col-4'> <button id='downloadPDF' onclick='baixarPdf()' class='btn btn-danger'>Baixar PDF</button> </div> ";

    resultHtml += "</div>";

    eixosHtml = `<div class="row">
                    <div class="col-3"></div>
                    <div class="col-3">
                      <select id="eixoX" class="form-control">
                        <option value="Agrupado">`+nomecampo+`</option>
                      </select>
                    </div>

                    <div class="col-3">
                      <select id="eixoY" class="form-control">
                        <option value="Total">Total</option>
                      </select>
                    </div>
                  </div>`;

    document.getElementById("eixos").innerHTML = eixosHtml;

    document.getElementById("result").innerHTML = resultHtml;
    gerarGrafico("Agrupado", "Total");

    document.getElementById("eixoX").value = "Agrupado";
    document.getElementById("eixoY").value = "Total";

  }
}

</script>

<!-- Script para manipular a geração dos gráficos -->
<script>
	let chartInstance = null;

	function gerarGrafico(abaX = null, abaY = null) {
    var tipoGrafico = document.getElementById('tipoGrafico').value;

    let eixoX, eixoY2;

    // Verifica se abaX e abaY não estão nulos ou vazios
    if (abaX && abaY) {
        eixoX = abaX;
        eixoY2 = abaY;
    } else {
        eixoX = document.getElementById('eixoX').value;
        eixoY2 = document.getElementById('eixoY').value;
    }

    if(tipoGrafico != ""){
    //var tipoGrafico = 'bar';

    var eixoY = [eixoY2];
		//var eixoYSelect = document.getElementById('eixoY');
		//var eixoY = Array.from(eixoYSelect.selectedOptions).map(option => option.value); // Pegando todos os campos selecionados no eixo Y
    //console.log(eixoY2);
    //console.log(eixoY);
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
			//labels.push(tabela.rows[i].cells[xIndex].innerText);

			if (tabela.rows[i].cells[xIndex]) {
				labels.push(tabela.rows[i].cells[xIndex].innerText);
			}
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

	}

	// Eventos onchange para os selects
	document.getElementById('tipoGrafico').addEventListener('change', gerarGrafico);
	document.getElementById('eixoX').addEventListener('change', gerarGrafico);
	document.getElementById('eixoY').addEventListener('change', gerarGrafico);

	// Gerar gráfico inicialmente
	gerarGrafico();

</script>

<script>
  function confirmDeleteLine(event, l, p, li) {
      event.preventDefault(); // Impede o link de ser seguido imediatamente
      if (confirm("Os dados da linha "+li+" serão perdidos. Deseja continuar?")) {
          // Se o usuário confirmar, redireciona para o link
          window.location.href = "home.php?l=" + l + "&li=" + li + "&p=" + p;
      }
  }

  function baixarXls(){
      var wb = XLSX.utils.table_to_book(document.getElementById('planilhaTabela'), {sheet: "Sheet1"});
      XLSX.writeFile(wb, 'tabela.xlsx');
  }

  function baixarPdf(){
    var { jsPDF } = window.jspdf;
      var doc = new jsPDF();

      doc.autoTable({ html: '#planilhaTabela' });
      doc.save('tabela.pdf');
  }


</script>



