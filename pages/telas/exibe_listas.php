<?php
  if(isset($_GET["d"])){
    $user_id = $_SESSION["id"];
    $sqlD = "UPDATE listas SET deleted_at = NOW(), deleted_by=$user_id WHERE id=".base64_decode($_GET["d"]);
    mysqli_query($conn, $sqlD);
  }
?>

<section class="content" style="margin-top: 20px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Opções do campo "<?=base64_decode($_GET["c"])?>"</h3>
          </div>
          <!-- /.card-header -->
          <form action="?l=<?=base64_encode(14)?>" method="POST">
          <div class="modal-body">
            <div class="row mb-2">
              <div class="col-sm-4">
                <a href="#" onclick="adicionarCampo()" class="btn btn-block btn-outline-info" > Adicionar Campo </a>
              </div>
            </div>
            <input type="hidden" name="plan_id" value="<?=base64_decode($_GET["i"])?>">
            <input type="hidden" name="number_column" value="<?=base64_decode($_GET["nc"])?>">
            <?php
              $sql = "SELECT * FROM listas WHERE deleted_at IS NULL AND plan_id=".base64_decode($_GET["i"])." AND number_column=".base64_decode($_GET["nc"])." ORDER BY value";
              $exec = mysqli_query($conn, $sql);
              while($row = mysqli_fetch_array($exec)){
                echo '<div class="row mb-2">
                        <div class="col-sm-4">
                          <input type="text" class="form-control" value="'.$row["value"].'" readonly />
                        </div>
                        <div class="col-sm-4">
                          <a href="?l=MTM=&c='.$_GET["c"].'&i='.$_GET["i"].'&nc='.$_GET["nc"].'&d='.base64_encode($row["id"]).'" class="btn btn-danger"> Remover </a>
                        </div>
                      </div>';
              }
            ?>
            <div id="inputContainer"></div>

            <div class="row mb-2">
              <div class="col-sm-6">
                <input type="submit" value="Salvar" class="btn btn-primary" />
              </div>
            </div>
          </div>
          </form>
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

<script>
  function adicionarCampo() {
    // Cria um novo div 'row' para agrupar o input, select e botão de remover
    var rowDiv = document.createElement('div');
    rowDiv.classList.add('row', 'mb-2');

    // Cria o div 'col-sm-4' para o input
    var colDivInput = document.createElement('div');
    colDivInput.classList.add('col-sm-4');

    // Cria o input de texto
    var input = document.createElement('input');
    input.type = 'text';
    input.name = 'campos[]';
    input.id = 'campos[]';
    input.placeholder = 'Digite aqui';
    input.classList.add('form-control');

    // Adiciona o input ao div 'col-sm-4'
    colDivInput.appendChild(input);

    var colDivRemove = document.createElement('div');
    colDivRemove.classList.add('col-sm-4');

    // Cria o botão de remover
    var removeBtn = document.createElement('button');
    removeBtn.textContent = 'Remover';
    removeBtn.classList.add('btn', 'btn-danger');

    // Adiciona evento para remover a linha quando o botão for clicado
    removeBtn.addEventListener('click', function() {
        rowDiv.remove();
    });

    colDivRemove.appendChild(removeBtn);

    rowDiv.appendChild(colDivInput);
    rowDiv.appendChild(colDivRemove);

    document.getElementById('inputContainer').appendChild(rowDiv);
  }
</script>
