
<?php
  $id = base64_decode($_GET["p"]);

  $sql = "SELECT name, MAX(number_column) AS 'total_colunas', (SELECT COUNT(*) FROM data_plans WHERE plan_id=$id AND number_column=1 AND number_line <> 1) AS 'total_linhas'
          FROM data_plans dp
          LEFT JOIN plans p ON p.id = dp.plan_id
          WHERE plan_id = $id";
  $exec = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($exec);
?>

<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h2 class="m-0"> Planilha <?=$row["name"]?></small></h2>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td><b>Total de Colunas<b></td>
                  <td><?=$row["total_colunas"]?></td>
                </tr>
                <tr>
                  <td><b>Total de Linhas</b></td>
                  <td><?=$row["total_linhas"]?></td>
                </tr>

              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
