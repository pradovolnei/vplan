<?php
include("connect.php");
//include("session.php");
session_start();

$id_pay = $_GET["id_pay"];
$group_id = $_SESSION["group_id"];

$sql = "SELECT * FROM transactions WHERE id=$id_pay";
$exec = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($exec);

$ticket_url = $row["ticket_url"];
$price = $row["price"];
$user_id = $row["user_id"];
$url = file_get_contents($ticket_url);

$var = "Este pagamento já foi realizado";

if (strpos($url, $var) === false) {

  $var2 = "Pagamento indisponível";
  if (strpos($url, $var2) == true) {
    $sqlUT = "UPDATE transactions SET `status`=3 WHERE id=$id_pay";
    mysqli_query($conn, $sqlUT);

    echo "Pix Cancelado";
  } else {
    echo "Aguardando Pagamento";
  }
} else {

  $sqlG = "SELECT * FROM groups WHERE id= $group_id";
  $execG = mysqli_query($conn, $sqlG);
  $rowG = mysqli_fetch_array($execG);
  $expiration = new DateTime($rowG["expiration"]);
  $data_atual = new DateTime(date("Y-m-d"));

  $nova_data = "CURRENT_DATE + INTERVAL 30 DAY";


  $sqlUp = "UPDATE groups SET expiration = $nova_data WHERE id=$group_id";
  mysqli_query($conn, $sqlUp);

  $sqlUs = "UPDATE users SET `status` = 1 WHERE id=$user_id";
  mysqli_query($conn, $sqlUs);

  $sqlUT = "UPDATE transactions SET `status`=2 WHERE id=$id_pay";
  mysqli_query($conn, $sqlUT);

  $sqlG2 = "SELECT * FROM groups WHERE id= $group_id";
  $execG2 = mysqli_query($conn, $sqlG2);
  $rowG2 = mysqli_fetch_array($execG2);

  $_SESSION["expiration"] = $rowG2["expiration"];

  echo "Pagamento Confirmado";
}
