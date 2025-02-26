<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

<!-- DataTables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<?php
$id_nivel = $_SESSION["type"];
?>
<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <?php if ($id_nivel == 1) { ?>
        <div class="col-sm-4" style="margin-top: 10px;">
          <button data-toggle="modal" data-id="5555" data-target="#modal-manual" class="btn btn-block btn-outline-info">
            Criar Planilha Manualmente</button>
        </div><!-- /.col -->
        <div class="col-sm-4" style="margin-top: 10px;">
          <button data-toggle="modal" data-id="5555" data-target="#modal-default" class="btn btn-block btn-outline-info">
            Carga xls </button>
        </div><!-- /.col -->
      <?php } ?>
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <form action="?l=<?= base64_encode(3) ?>" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Upload de Planilha</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" class="form-control" id="name" name="name" placeholder="Nome da Planilha" required>
        </div>
        <div class="modal-body">
          <input type="file" class="form-control" id="planilha" name="planilha" accept=".xls,.xlsx" required>
        </div>
        <div class="modal-body">
          <textarea id="obs" class="form-control" name="obs" placeholder="Observações"></textarea>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </form>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-manual">
  <div class="modal-dialog">
    <form action="?l=<?= base64_encode(10) ?>" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Criar tabela</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" class="form-control" id="name" name="name" placeholder="Nome da Planilha" required>
        </div>
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-sm-4">
              <a href="#" onclick="adicionarColuna()" class="btn btn-block btn-outline-info"> Adicionar Coluna </a>
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-sm-4">
              <input type="text" class="form-control" name="coluna_manual[]" id="coluna_manual[]"
                placeholder="Nome da Coluna" />
            </div>
            <div class="col-sm-4">
              <select name="tipo_coluna[]" id="tipo_coluna[]" class="form-control" required>
                <option value=""> Tipo </option>
                <option value="texto"> Texto </option>
                <option value="número inteiro"> Número Inteiro </option>
                <option value="número decial"> Número Decimal </option>
                <option value="data"> Data </option>
                <option value="data/hora"> Data/Hora </option>
                <option value="lista suspensa"> Lista Suspensa </option>
              </select>
            </div>
          </div>

          <div id="inputContainer"></div>
        </div>
        <div class="modal-body">
          <textarea id="obs" class="form-control" name="obs" placeholder="Observações"></textarea>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </form>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Planilhas da Equipe</h3>
          </div>
          <div class="card-body table-responsive p-3">
            <?php
            $group_id = $_SESSION["group_id"];
            $sql = "SELECT p.id, p.name, p.created_at, u.name as 'user', p.obs FROM plans p LEFT JOIN users u ON u.id = p.created_by WHERE p.group_id=$group_id AND deleted_at IS NULL ORDER BY p.created_at DESC";
            if (isset($_GET["s"])) {
              $string_s = $_GET["s"];
              $sql .= " AND (p.name LIKE '%$string_s%' OR u.name LIKE '%$string_s%')";
            }
            $exec = mysqli_query($conn, $sql);

            if (mysqli_num_rows($exec) > 0) {
              ?>
              <table class="table table-hover table-bordered text-center" id="myTable">
                <thead class="thead-dark">
                  <tr>
                    <th>Planilha</th>
                    <th>Criada em</th>
                    <th>Criada por</th>
                    <th>Ação</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($row = mysqli_fetch_array($exec)) {
                    echo "<tr>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . date("d/m/Y H:i", strtotime($row["created_at"])) . "</td>";
                    echo "<td>" . $row["user"] . "</td>";
                    echo "<td>";
                    ?>
                    <a class='text-primary mx-1' title="Visualizar"
                      href='?l=<?= base64_encode(5) . "&p=" . base64_encode($row["id"]) ?>'><i class='fas fa-eye'></i></a>
                    <?php if ($id_nivel == 1) { ?>
                      <a class='text-success mx-1' title='Editar' href='#' data-toggle='modal' data-target='#modal-edit'
                        data-obs='<?= $row["obs"] ?>' data-id='<?= $row["id"] ?>' data-nome='<?= $row["name"] ?>'><i
                          class='fas fa-pen'></i></a>
                      <a class='text-danger mx-1' title="Remover" href='#'
                        onclick='confirmDelete(event, "<?= base64_encode(7) ?>", "<?= base64_encode($row["id"]) ?>")'><i
                          class='fas fa-trash'></i></a>
                    <?php }
                    echo "</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
              <?php
            } else {
              echo "<h5 class='text-center text-muted'>Nenhuma planilha encontrada.</h5>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Modal -->
<div class="modal fade" id="modal-edit">
  <div class="modal-dialog">
    <form action="?l=<?= base64_encode(6) ?>" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Editar Planilha</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Campo hidden para o ID -->
          <input type="hidden" class="form-control" id="id_plan" name="id">
          <input type="text" class="form-control" id="name_plan" name="name" placeholder="Nome da Planilha" value=""
            required>
        </div>
        <div class="modal-body">
          <textarea id="obs_plan" class="form-control" name="obs" placeholder="Observações"></textarea>
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
  function confirmDelete(event, l, p) {
    console.log(123);
    event.preventDefault(); // Impede o link de ser seguido imediatamente
    if (confirm("Todos os dados serão perdidos. Deseja realmente remover esta planilha?")) {
      // Se o usuário confirmar, redireciona para o link
      window.location.href = "home.php?l=" + l + "&p=" + p;
    }
  }
</script>

<script>
  function adicionarColuna() {
    // Cria um novo div 'row' para agrupar o input, select e botão de remover
    var rowDiv = document.createElement('div');
    rowDiv.classList.add('row', 'mb-2');

    // Cria o div 'col-sm-4' para o input
    var colDivInput = document.createElement('div');
    colDivInput.classList.add('col-sm-4');

    // Cria o input de texto
    var input = document.createElement('input');
    input.type = 'text';
    input.name = 'coluna_manual[]';
    input.id = 'coluna_manual[]';
    input.placeholder = 'Nome da Coluna';
    input.classList.add('form-control');

    // Adiciona o input ao div 'col-sm-4'
    colDivInput.appendChild(input);

    // Cria o div 'col-sm-4' para o select
    var colDivSelect = document.createElement('div');
    colDivSelect.classList.add('col-sm-4');

    // Cria a lista suspensa (select)
    var select = document.createElement('select');
    select.name = 'tipo_coluna[]';
    select.id = 'tipo_coluna[]';
    select.classList.add('form-control');
    select.required = true;

    var option = document.createElement('option');
    option.value = "";
    option.textContent = "Tipo";
    select.appendChild(option);

    // Adiciona opções ao select
    var opcoes = ['Texto', 'Número Inteiro', 'Número Decimal', 'Data', 'Data/Hora', 'Lista Suspensa'];
    opcoes.forEach(function (opcao) {
      var option = document.createElement('option');
      option.value = opcao.toLowerCase();
      option.textContent = opcao;
      select.appendChild(option);
    });

    // Adiciona o select ao div 'col-sm-4'
    colDivSelect.appendChild(select);

    var colDivRemove = document.createElement('div');
    colDivRemove.classList.add('col-sm-4');

    // Cria o botão de remover
    var removeBtn = document.createElement('button');
    removeBtn.textContent = 'Remover';
    removeBtn.classList.add('btn', 'btn-danger');

    // Adiciona evento para remover a linha quando o botão for clicado
    removeBtn.addEventListener('click', function () {
      rowDiv.remove();
    });

    colDivRemove.appendChild(removeBtn);

    // Adiciona os elementos criados ao div 'row'
    rowDiv.appendChild(colDivInput);
    rowDiv.appendChild(colDivSelect);
    rowDiv.appendChild(colDivRemove);

    // Adiciona o div 'row' ao container principal
    document.getElementById('inputContainer').appendChild(rowDiv);
  }

</script>

<script>
  $(document).ready(function() {
    $('#myTable').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json" // Tradução para português (opcional)
      },
      "order": [[1, "desc"]] // Ordenação inicial pela segunda coluna (criada em) em ordem decrescente
    });
  });
</script>