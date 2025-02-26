<div class="modal fade" id="modal-formula">
  <div class="modal-dialog">
    <form action="?l=<?= base64_encode(11) ?>" method="POST" enctype="multipart/form-data">
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
            <input type="hidden" class="form-control" name="id" value="<?= $id_plan ?>">

            <div class="row">
              <div class="col-12">
                <input class="form-control" type="text" name="nome_coluna" id="nome_coluna" required
                  placeholder="Nome da Coluna" value="" />
              </div>
            </div>
            <br />

            <div class="row">
              <div class="col-12">

                <textarea placeholder="Fórmula" class="form-control" readonly type="text" name="formula"
                  id="formula"></textarea>
              </div>
            </div>
            <br />

            <div class="row">
              <div class="col-6">
                <a href="#" onclick="limparFormula()" class="btn btn-block btn-warning"> Limpar </a>
              </div>
            </div>
            <br />

            <div class="row">
              <div class="col-12">

                <table>
                  <tr>
                    <?php
                    $class_row = 1;
                    foreach ($colunas as $coluna) {
                      if ($class_row == 4) {
                        echo "</tr><tr>";
                        $class_row = 1;
                      }

                      ?>
                      <td><a href="#" class="btn btn-block btn-secondary" onclick="novaFormula('<?= $coluna ?>')">
                          <?= $coluna ?> </a></td>
                      <?php
                      $class_row++;
                    }
                    ?>
                  </tr>

                  <tr>
                    <td><a href="#" class="btn btn-block btn-secondary" onclick="novaFormula('+')"> + </a></td>
                    <td><a href="#" class="btn btn-block btn-secondary" onclick="novaFormula('-')"> - </a></td>
                    <td><a href="#" class="btn btn-block btn-secondary" onclick="novaFormula('*')"> x </a></td>
                  </tr>
                  <tr>
                    <td><a href="#" class="btn btn-block btn-secondary" onclick="novaFormula('/')"> ÷ </a></td>
                    <td><a href="#" class="btn btn-block btn-secondary" onclick="novaFormula('(')"> ( </a></td>
                    <td><a href="#" class="btn btn-block btn-secondary" onclick="novaFormula(')')"> ) </a></td>
                  </tr>
                </table>
              </div>
            </div>
            <br />

            <div id="denominadores">
              <div class="row">
                <div class="col-6">
                  <input type="number" class="form-control" id="numerico" name="numerico" value=""
                    placeholder="Valor Numérico" />
                </div>
                <div class="col-6">
                  <a href="#" onclick="inserirNumerico()" class="btn btn-block btn-outline-info"
                    id="valor_numerico">Inserir Valor Numérico</a>
                </div>
              </div>
              <br />
            </div>


          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" id="save_form" class="btn btn-primary">Salvar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </form>
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-lista">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Listas Suspensas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <!-- Campo hidden para o ID -->

          <?php
          $sql = "SELECT * FROM data_plans WHERE number_line = 0 AND type_id = 6 AND plan_id=" . $id_plan;
          $exec = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_array($exec)) {
            ?>
            <div class="row mb-2"> <!-- Adiciona margem abaixo de cada linha -->
              <div class="col-6">
                <a href="?l=<?= base64_encode(13) ?>&c=<?= base64_encode($row["value"]) ?>&i=<?= base64_encode($row["plan_id"]) ?>&nc=<?= base64_encode($row["number_column"]) ?>"
                  class='btn btn-warning btn-block'> <!-- btn-block faz o botão ocupar toda a largura da coluna -->
                  <?= $row["value"] ?>
                </a>
              </div>
            </div>

            <?php
          }
          ?>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-remove">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Remover Fórmulas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <!-- Campo hidden para o ID -->

          <?php
          $sql = "SELECT * FROM formulas WHERE plan_id=" . $id_plan;
          $exec = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_array($exec)) {
            ?>
            <div class="row">
              <div class="col-6">
                <input class="form-control" type="text" readonly value="<?= $row["name"] ?>" />
              </div>
              <div class="col-6">
                <a href="#" class='btn btn-danger'
                  onclick='confirmDeleteForm(event, "<?= base64_encode(12) ?>", "<?= base64_encode($row["id"]) ?>")'> Remover
                </a>
              </div>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- Modal -->
<div class="modal fade" id="modal-insert">
  <div class="modal-dialog">
    <form action="?l=<?= base64_encode(8) ?>" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Registro Manual Linha <?= $totalLinhas + 1 ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card-body">
            <!-- Campo hidden para o ID -->
            <input type="hidden" class="form-control" name="id" value="<?= $id_plan ?>">
            <input type="hidden" class="form-control" name="new_line" value="<?= $totalLinhas + 1 ?>">

            <?php
            /*$xColum = 0;
            foreach($colunas as $coluna) {
              echo '<div class="form-group row">';
              echo '<input type="text" class="form-control" name="valor[]" placeholder="'.$coluna.'">';
              echo '</div>';
            }*/

            $listaTipos = "SELECT dp.value, t.sub_type, number_column, dp.type_id
                              FROM data_plans dp
                              LEFT JOIN types t ON t.id = dp.type_id
                              WHERE dp.number_line = 0
                              AND dp.plan_id = $id_plan ";

            $execTipos = mysqli_query($conn, $listaTipos);

            while ($col = mysqli_fetch_array($execTipos)) {
              $numberColumn = $col["number_column"];
              if ($col["sub_type"] == "select") {
                echo '<div class="form-group row">';
                echo '<select class="custom-select" name="valor[]" required >';
                echo '<option value=""> ' . $col["value"] . ' </option>';

                $sqlOptions = "SELECT * FROM listas WHERE deleted_at IS NULL AND plan_id = $id_plan AND number_column = $numberColumn ORDER BY value";
                $execoptions = mysqli_query($conn, $sqlOptions);

                while ($rowOptions = mysqli_fetch_array($execoptions)) {
                  echo '<option value="' . $rowOptions["value"] . '"> ' . $rowOptions["value"] . ' </option>';
                }

                echo '</select>';
                //echo "<br><a href='?l=".base64_encode(13)."&i=".base64_encode($id_plan)."&nc=".base64_encode($numberColumn)."&c=".base64_encode($col["value"])."'> Adicionar Opções </a>";
                echo '</div>';
              } else {
                echo '<div class="form-group row">';
                echo '<input type="' . $col["sub_type"] . '" class="form-control" name="valor[]" placeholder="' . $col["value"] . '">';
                echo '</div>';
              }

              echo "<input type='hidden' name='tipos[]' value='" . $col["type_id"] . "' />";

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

<!-- Modal -->
<div class="modal fade" id="modal-edit-line">
  <div class="modal-dialog">
    <form action="?l=<?= base64_encode(15) ?>" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Editar Linha</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card-body">
            <!-- Campo hidden para o ID -->
            <input type="hidden" class="form-control" name="id" value="<?= $id_plan ?>" />
            <input type="hidden" class="form-control" name="line" id="line" value="" />
            <div id="resultsEdit"></div>

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