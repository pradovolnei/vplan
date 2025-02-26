<?php
$id_plan = base64_decode($_GET["p"]);
$id_nivel = $_SESSION["type"];

$sql_pan = "SELECT * FROM plans WHERE id=$id_plan AND group_id=" . $_SESSION["group_id"];
$exec_plan = mysqli_query($conn, $sql_pan);
if (mysqli_num_rows($exec_plan) <= 0) {
  echo "<script> window.location='home.php' </script>";
}

$sql_titulo = "SELECT * FROM data_plans WHERE plan_id=$id_plan";
$colunas = [];
$totalColunas = 0;
$totalLinhas = 0;
$dadosTabela = [];
$listaIds = [];
$tiposDados = [];
$exec_titulo = mysqli_query($conn, $sql_titulo);
if (mysqli_num_rows($exec_titulo) > 0) {
  while ($row = mysqli_fetch_array($exec_titulo)) {
    if ($row["number_line"] == 0) {
      $colunas[] = htmlspecialchars($row["value"]);
      $tiposDados[] = $row["type_id"];
    }

    $dadosTabela[$row["number_line"]][$row["number_column"]] = $row["value"];
    $totalColunas = $row["number_column"];
    $totalLinhas = $row["number_line"];

    if ($row["number_column"] == 0)
      $listaIds[$row["number_line"]] = $row["id"];

    $listaIds[$row["number_line"]] += $row["id"];
  }

} else {
  echo "<script> window.location='home.php' </script>";
}

?>
<style>
  .btn-custom {
    width: 100%;
    /* Faz o botão ocupar toda a largura do container */
  }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div style="display: none;">

  <table id="salesTable" class="table table-bordered">
    <thead>
      <tr>
        <?php
        foreach ($colunas as $coluna) {
          echo "<th>" . htmlspecialchars($coluna) . "</th>";
        }

        $sqlFormulas = "SELECT * FROM formulas WHERE plan_id=" . $id_plan;
        $execFormulas = mysqli_query($conn, $sqlFormulas);

        while ($row = mysqli_fetch_array($execFormulas)) {
          echo "<th>" . htmlspecialchars($row["name"]) . "</th>";
        }
        ?>
      </tr>
    </thead>
    <tbody>
      <?php
      for ($linha = 1; $linha <= $totalLinhas; $linha++) {
        echo "<tr>";
        for ($coluna = 0; $coluna <= $totalColunas; $coluna++) {
          $valor = isset($dadosTabela[$linha][$coluna]) ? htmlspecialchars($dadosTabela[$linha][$coluna]) : '';
          echo "<td>" . $valor . "</td>";

        }

        $sqlFormulas = "SELECT * FROM formulas WHERE plan_id=" . $id_plan;
        $execFormulas = mysqli_query($conn, $sqlFormulas);

        while ($row = mysqli_fetch_array($execFormulas)) {
          echo "<td>" . calcularFormula($row["formula"], $colunas, $dadosTabela[$linha]) . "</td>";
        }
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</div>
<?php include "pages/telas/modals_details.php"; ?>
<section class="content" style="margin-top: 20px;">

  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <!-- Default box -->
        <div class="card collapsed-card shadow-lg">
          <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
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
                  foreach ($colunas as $coluna) {
                    echo "<option value='$xColum'>Total de " . htmlspecialchars($coluna) . "</option>";
                    $xColum++;
                  }

                  $sqlFormulas = "SELECT * FROM formulas WHERE plan_id=" . $id_plan;
                  $execFormulas = mysqli_query($conn, $sqlFormulas);

                  while ($row = mysqli_fetch_array($execFormulas)) {
                    echo "<option value='$xColum'> Total de " . htmlspecialchars($row["name"]) . "</option>";
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
                  foreach ($colunas as $coluna) {
                    echo "<option value='$xColum--$coluna'>Agrupar por " . htmlspecialchars($coluna) . "</option>";
                    $xColum++;
                  }

                  ?>
                </select>
              </div>


            </div>
            <?php if ($id_nivel == 1) { ?>
              <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                <div class="col-12 col-md-3 mb-2 mb-md-0">
                  <a href="#" class="btn btn-block btn-outline-info" data-toggle='modal'
                    data-target='#modal-insert'>Inserir linha</a>
                </div>
                <div class="col-12 col-md-3 mb-2 mb-md-0">
                  <a href="#" class="btn btn-block btn-outline-info" data-toggle='modal'
                    data-target='#modal-formula'>Inserir Fórmula</a>
                </div>
                <div class="col-12 col-md-3 mb-2 mb-md-0">
                  <a href="#" class="btn btn-block btn-outline-danger" data-toggle='modal'
                    data-target='#modal-remove'>Remover Fórmula</a>
                </div>
                <div class="col-12 col-md-3 mb-2 mb-md-0">
                  <a href="#" class="btn btn-block btn-outline-warning" data-toggle='modal'
                    data-target='#modal-lista'>Listas Suspensas</a>
                </div>
              </div>
            <?php } ?>

            <div id="result" class="card-body table-responsive p-0">
              <table id="planilhaTabela" class="table table-bordered table-hover text-center">
                <thead class="thead-light">
                  <tr>
                    <?php
                    if ($id_nivel == 1)
                      echo "<th> Ação </th>";
                    ?>

                    <th> Linha </th>
                    <th> ID </th>
                    <?php
                    foreach ($colunas as $coluna) {
                      echo "<th>" . htmlspecialchars($coluna) . "</th>";
                    }

                    $sqlFormulas = "SELECT * FROM formulas WHERE plan_id=" . $id_plan;
                    $execFormulas = mysqli_query($conn, $sqlFormulas);

                    while ($row = mysqli_fetch_array($execFormulas)) {
                      echo "<th style='background-color: #DDD'>" . htmlspecialchars($row["name"]) . "</th>";
                    }
                    ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  for ($linha = 1; $linha <= $totalLinhas; $linha++) {
                    echo "<tr>";

                    if ($id_nivel == 1) {
                      echo "<td>";
                      echo "<a onclick='preencherLinha($id_plan, $linha)' style='color: #0A0' title='Editar' class='open-modal-edit' href='#' data-toggle='modal' data-target='#modal-edit-line'  ><i class='nav-icon fas fa-pen'></i> </a>";
                      ?>
                      <a href='#' title='Excluir' style=" color: #F00"
                        onclick='confirmDeleteLine(event, "<?= base64_encode(9) ?>", "<?= base64_encode($id_plan) ?>", <?= $linha ?>)'>
                        <i class='nav-icon fas fa-trash'></i> </a>
                      <?php

                      echo "</td>";
                    }
                    echo "<td> ";
                    echo $linha;
                    echo "</td>";
                    echo "<td> " . $id_plan . $listaIds[$linha] . " </td>";
                    for ($coluna = 0; $coluna <= $totalColunas; $coluna++) {
                      $valor = isset($dadosTabela[$linha][$coluna]) ? htmlspecialchars($dadosTabela[$linha][$coluna]) : '';

                      echo "<td>" . formatarCelula($valor, $tiposDados[$coluna]) . "</td>";

                    }

                    $sqlFormulas = "SELECT * FROM formulas WHERE plan_id=" . $id_plan;
                    $execFormulas = mysqli_query($conn, $sqlFormulas);

                    while ($row = mysqli_fetch_array($execFormulas)) {
                      echo "<td align='right' style='color: #777; font-weight: bold;'>" . formatarNumero(calcularFormula($row["formula"], $colunas, $dadosTabela[$linha])) . "</td>";
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
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h2 class="text-center mb-4">Gráfico de Produtos</h2>
        <div id="eixos" class="mb-4">
          <div class="row">
            <div class="col-md-6">
              <label for="eixoX">Eixo X:</label>
              <select id="eixoX" class="form-control">
                <option>Selecione o Eixo X</option>
                <?php
                foreach ($colunas as $coluna) {
                  echo "<option value='$coluna'>" . htmlspecialchars($coluna) . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-md-6">
              <label for="eixoY">Eixo Y:</label>
              <select id="eixoY" class="form-control">
                <option>Selecione o Eixo Y</option>
                <?php
                foreach ($colunas as $coluna) {
                  echo "<option value='$coluna'>" . htmlspecialchars($coluna) . "</option>";
                }
                $sqlFormulas = "SELECT * FROM formulas WHERE plan_id=" . $id_plan;
                $execFormulas = mysqli_query($conn, $sqlFormulas);

                while ($row = mysqli_fetch_array($execFormulas)) {
                  echo "<option value='" . $row["name"] . "'>" . htmlspecialchars($row["name"]) . "</option>";
                  $xColum++;
                }
                ?>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="container mt-4">
              <label for="tipoGrafico">Selecione o tipo de gráfico:</label>
              <select id="tipoGrafico" class="form-control">
                <option value="">Selecione um Gráfico</option>
                <option value="bar">Barra</option>
                <option value="line">Linha</option>
                <option value="pie">Pizza</option>
              </select>
              <div style="width: 60%;">
                <canvas id="graficoCanvas" class="mt-4"></canvas>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



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

    if (total_reg != "" && campo != "") {

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
                       <th>`+ nomecampo + `</th>
                       <th>Total</th>
                     </tr></thead>`;
      sortedKeys.forEach(key => {
        const value = salesData[key];

        // Verifica se `key` é uma data válida
        let formattedKey = key;
        if (!isNaN(Date.parse(key))) {
          const date = new Date(key);
          formattedKey = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
        }

        resultHtml += `<tr>
                   <td>${formattedKey}</td>
                   <td>${Number.isInteger(value) ? value : value.toFixed(2)}</td>
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
                        <option value="`+ nomecampo + `">` + nomecampo + `</option>
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
      gerarGrafico(nomecampo, "Total");

      document.getElementById("eixoX").value = nomecampo;
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

    if (tipoGrafico != "") {
      //var tipoGrafico = 'bar';

      var eixoY = [eixoY2];
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
          var valorBruto = tabela.rows[i].cells[yIndices[0]].innerText;
          var valorNormalizado = valorBruto.replace(/\./g, '').replace(',', '.'); // Remove pontos e ajusta a vírgula para ponto
          dados.push(parseFloat(valorNormalizado));
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
            var valorNormalizado2 = tabela.rows[i].cells[yIndex].innerText;
            var valorNormalizado1 = valorNormalizado2.replace(/\./g, '').replace(',', '.'); // Remove pontos e ajusta a vírgula para ponto

            dados.push(parseFloat(valorNormalizado1));
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
    if (confirm("Os dados da linha " + li + " serão perdidos. Deseja continuar?")) {
      // Se o usuário confirmar, redireciona para o link
      window.location.href = "home.php?l=" + l + "&li=" + li + "&p=" + p;
    }
  }

  function confirmDeleteForm(event, l, i) {
    event.preventDefault(); // Impede o link de ser seguido imediatamente
    if (confirm("Os dados da fórmula serão perdidos. Deseja continuar?")) {
      // Se o usuário confirmar, redireciona para o link
      window.location.href = "home.php?l=" + l + "&i=" + i;
    }
  }

  function baixarXls() {
    var wb = XLSX.utils.table_to_book(document.getElementById('planilhaTabela'), { sheet: "Sheet1" });
    XLSX.writeFile(wb, 'tabela.xlsx');
  }

  function baixarPdf() {
    var { jsPDF } = window.jspdf;
    var doc = new jsPDF();

    doc.autoTable({ html: '#planilhaTabela' });
    doc.save('tabela.pdf');
  }

  function novaFormula(campo) {
    var formula = document.getElementById('formula');
    var antigo = formula.value;
    var link = document.getElementById("valor_numerico");

    const array = ["+", "-", "*", "/", ")", "("];
    const array2 = ["+", "-", "*", "/", "("];

    if (!array2.includes(campo)) {
      link.classList.add("disabled");
    } else {
      link.classList.remove("disabled");
    }

    formula.value = antigo;

    if (!array.includes(campo)) {
      formula.value += "[" + campo + "]";

    } else {
      formula.value += campo;

    }

    let atualizado = document.getElementById('formula').value;
    const countAbre = atualizado.split('').filter(letter => letter.toUpperCase() === '(').length;
    const countFecha = atualizado.split('').filter(letter => letter.toUpperCase() === ')').length;

    if (array2.includes(campo) || countAbre != countFecha || atualizado.includes("](") || atualizado.includes(")[")) {
      document.getElementById("save_form").disabled = true;
    } else {
      document.querySelector("#save_form").removeAttribute("disabled");
    }

  }

  function inserirNumerico() {
    let numerico = document.getElementById("numerico").value;

    let neoNumerico = numerico.replace(",", ".");

    var formula = document.getElementById('formula');
    var antigo = formula.value;

    formula.value = antigo + neoNumerico;

  }

  function limparFormula() {
    var formula = document.getElementById('formula');
    formula.value = "";
  }

</script>

<script>
  document.getElementById('novoDenominadorBtn').addEventListener('click', function (e) {
    e.preventDefault(); // Impede a ação padrão do link

    // Clona a div 'denominadores'
    var denominadoresClone = document.getElementById('denominadores').cloneNode(true);

    // Remove o atributo id do clone para evitar IDs duplicados no DOM
    denominadoresClone.removeAttribute('id');

    // Insere o clone dentro da div 'inputContainer'
    document.getElementById('inputContainer').appendChild(denominadoresClone);
  });
</script>

<script>
  async function preencherLinha(planilha, linha) {
    var numLine = document.getElementById("line");
    numLine.value = linha;

    const response = await fetch('campos_linha.php?p=' + planilha + '&l=' + linha);
    if (!response.ok) {
      throw new Error('Erro ao acessar o arquivo PHP');
    }
    const texto = await response.text();
    document.getElementById('resultsEdit').innerHTML = texto;
  }
</script>