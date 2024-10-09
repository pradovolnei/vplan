<?php
  $conn = mysqli_connect("localhost", "root", "");
  mysqli_select_db($conn, "vplan");

  ini_set('default_charset','UTF-8');
	mysqli_set_charset($conn, "utf8");

	$pode_enviar = 1;

  function encripta($senha){
		$salt = md5("@PLN.24.vp");
		$codifica = crypt($senha,$salt);
		$codifica = hash('sha512',$codifica);
		return $codifica;
	}

?>
