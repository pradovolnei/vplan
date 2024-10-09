<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"> Home</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <button data-toggle="modal" data-target="#modal-default"> Nova Planilha</button>
      </div><!-- /.col -->
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

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-2"> </div>
      <div class="col-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Planilhas da Equipe</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <?php
              $group_id = $_SESSION["group_id"];
              $sql = "SELECT p.id, p.name, p.created_at, u.name as 'user'
                      FROM plans p
                      LEFT JOIN users u ON u.id = p.created_by
                      WHERE p.group_id=$group_id";
              $exec = mysqli_query($conn, $sql);

              if(mysqli_num_rows($exec) > 0){
            ?>
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>Planilha</th>
                <th>Criada em</th>
                <th>Criada por</th>
              </tr>
              </thead>
              <tbody>
                <?php
                  while($row = mysqli_fetch_array($exec)){
                    echo "<tr>";

                    echo "<td> <a href='?l=".base64_encode(5)."&p=".base64_encode($row["id"])."'>".$row["name"]."</a> </td>";
                    echo "<td> ".date("d/m/Y H:i", strtotime($row["created_at"]))." </td>";
                    echo "<td> ".$row["user"]." </td>";

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
