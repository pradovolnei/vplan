<?php
$sql = "SELECT * FROM transactions WHERE user_id = " . $_SESSION["id"] . " ORDER BY id DESC";
$exec = mysqli_query($conn, $sql);
?>

<!-- form start -->
<div class="card-body">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Lista de Pagamentos</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <table class="table">
            <thead>
              <tr>
                <th style="width: 30px;">ID</th>
                <th style="text-align: center;">Valor</th>
                <th style="text-align: center;">Tipo</th>
                <th style="text-align: center;">Data</th>
                <th style="text-align: center;">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($row = mysqli_fetch_array($exec)) {
                $link = "";
                if ($row["status"] == 1) {
                  $link = "<br><a href='".$row["ticket_url"]."' target='_blank'> Link de Pagamento </a>";
                  ?>
                      <div id="conteudo"></div>
                      <script>
                        function atualizarConteudo() {
                          var url = "load_pix.php?id_pay=<?= $row["id"] ?>";
                          console.log(url);
                          fetch(url)
                            .then(response => response.text())
                            .then(data => {
                              document.getElementById("conteudo").innerHTML = "";
                              if (data === "Pagamento Confirmado") {
                                window.location.href = 'home.php?l=<?= base64_encode(21) ?>';
                              }
                            })
                            .catch(error => {
                              console.error("Erro:", error);
                            });
                        }

                        // Chame a função a cada intervalo de tempo (por exemplo, a cada 5 segundos)
                        setInterval(atualizarConteudo, 1000); // 5000 milissegundos = 5 segundos
                      </script>
                  <?php
                    }

                echo "<tr>";




                echo "<td> " . $row["id"] . " </td>";
                echo "<td align='center'> R$ " . number_format($row["price"], 2, ',', '.') . " </td>";
                echo "<td align='center'> " . $row["type"] . " </td>";
                echo "<td align='center'> " . date("d/m/Y H:i", strtotime($row["created_at"])) . " </td>";
                echo "<td align='center'> <b>" . statusPay($row["status"]) . "</b> $link </td>";

                echo "</tr>";


              }
              ?>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
  </div>


</div>
<!-- /.card-body -->
