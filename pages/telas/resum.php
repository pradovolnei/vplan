<?php
  $id_nivel = $_SESSION["type"];
?>
<div class="content-header">
  <div class="container">
    <div class="row mb-2">
        <?php if($id_nivel == 1){ ?>
          <div class="col-sm-4" style="margin-top: 10px;">
            <button data-toggle="modal" data-id="5555" data-target="#modal-manual" class="btn btn-block btn-outline-info"> Criar Planilha Manualmente</button>
          </div><!-- /.col -->
          <div class="col-sm-4" style="margin-top: 10px;">
            <button data-toggle="modal" data-id="5555" data-target="#modal-default" class="btn btn-block btn-outline-info"> Carga xls </button>
          </div><!-- /.col -->
        <?php } ?>
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <form action="?l=<?=base64_encode(3)?>" method="POST" enctype="multipart/form-data">
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
    <form action="?l=<?=base64_encode(10)?>" method="POST" enctype="multipart/form-data">
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
            <a href="#" onclick="adicionarColuna()" class="btn btn-block btn-outline-info" > Adicionar Coluna </a>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-sm-6">
            <input type="text" class="form-control" name="coluna_manual[]" id="coluna_manual[]" placeholder="Nome da Coluna" />
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
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Planilhas da Equipe</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <?php
              $group_id = $_SESSION["group_id"];
              $sql = "SELECT p.id, p.name, p.created_at, u.name as 'user', p.obs
                      FROM plans p
                      LEFT JOIN users u ON u.id = p.created_by
                      WHERE p.group_id=$group_id AND deleted_at IS NULL ";

              if(isset($_GET["s"])){
                $string_s = $_GET["s"];
                $sql .= " AND (p.name LIKE '%$string_s%' OR u.name LIKE '%$string_s%')";
              }
              $exec = mysqli_query($conn, $sql);

              if(mysqli_num_rows($exec) > 0){
            ?>
            <table  class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>Planilha</th>
                <th>Criada em</th>
                <th>Criada por</th>
                <th>Ação</th>
              </tr>
              </thead>
              <tbody>
                <?php
                  while($row = mysqli_fetch_array($exec)){
                    echo "<tr>";

                    echo "<td>".$row["name"]."</td>";
                    echo "<td> ".date("d/m/Y H:i", strtotime($row["created_at"]))." </td>";
                    echo "<td> ".$row["user"]." </td>";
                    echo "<td align='center'> ";
                    ?>
                    <a style='color: #00F' class='open-modal-edit' title="Visualizar" href='?l=<?=base64_encode(5)."&p=".base64_encode($row["id"])?>' ><i class='nav-icon fas fa-eye'></i> </a>
                    &nbsp;
                    <?php
                      if($id_nivel == 1){
                        echo "<a style='color: #0A0' title='Editar' class='open-modal-edit' href='#' data-toggle='modal' data-target='#modal-edit' data-obs='".$row["obs"]."' data-id='".$row["id"]."' data-nome='".$row["name"]."' ><i class='nav-icon fas fa-pen'></i> </a>";

                    ?>
                    &nbsp;
                    <a style='color: #F00' class='open-modal-edit' title="Remover" href='#' onclick='confirmDelete(event, "<?=base64_encode(7)?>", "<?=base64_encode($row["id"])?>")' ><i class='nav-icon fas fa-trash'></i> </a>
                    <?php
                      }
                    echo " </td>";

                    echo "</tr>";
                  }
                ?>
              </tbody>
            </table>

            <?php
              }else{
                echo "<h3> Nenhuma planilha para essa equipe. </h3>";
              }
            ?>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>

<!-- Modal -->
<div class="modal fade" id="modal-edit">
  <div class="modal-dialog">
    <form action="?l=<?=base64_encode(6)?>" method="POST" enctype="multipart/form-data">
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
          <input type="text" class="form-control" id="name_plan" name="name" placeholder="Nome da Planilha" value="" required>
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
      // Cria um novo div 'row' para agrupar o input e o botão de remover
      var rowDiv = document.createElement('div');
      rowDiv.classList.add('row', 'mb-2', 'input-group');

      // Cria o div 'col-sm-4' para o input
      var colDiv = document.createElement('div');
      colDiv.classList.add('col-sm-6');

      // Cria o input de texto
      var input = document.createElement('input');
      input.type = 'text';
      input.name = 'coluna_manual[]';
      input.id = 'coluna_manual[]';
      input.placeholder = 'Nome da Coluna';
      input.classList.add('form-control');

      // Cria o botão de remover
      var removeBtn = document.createElement('button');
      removeBtn.textContent = 'Remover';
      removeBtn.classList.add('btn', 'btn-danger');

      // Adiciona evento para remover o input quando o botão for clicado
      removeBtn.addEventListener('click', function() {
          rowDiv.remove();
      });

      // Adiciona o input ao div 'col-sm-4'
      colDiv.appendChild(input);

      // Adiciona o div 'col-sm-4' e o botão de remover ao div 'row'
      rowDiv.appendChild(colDiv);
      rowDiv.appendChild(removeBtn);

      // Adiciona o div 'row' ao container principal
      document.getElementById('inputContainer').appendChild(rowDiv);
  }
</script>
