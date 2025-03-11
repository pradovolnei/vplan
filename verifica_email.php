<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "vplan";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if(isset($_POST['email'])) {
    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        echo 'existe';
    } else {
        echo 'disponivel';
    }
    $stmt->close();
}
$conn->close();
?>
