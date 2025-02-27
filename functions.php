<?php
  function formatarCelula($valor = null, $tipo){
    $valorFormat = $valor;

    if($valor == "")
		  return $valorFormat;

    if($tipo == 2){
      $valorFormat = number_format($valor, 0, ',', '.');
    }

    if($tipo == 3){
      $valorFormat = number_format($valor, 2, ',', '.');;
    }

    if($tipo == 4){
      $valorFormat = date("d/m/Y", strtotime($valor));
    }

    if($tipo == 5){
      $valorFormat = date("d/m/Y H:i", strtotime($valor));
    }

    return $valorFormat;
  }

  function isDate($date, $format) {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
  }

  function calcularFormula($base, $colunas, $alterar) {
		try {
			// Substitui as colunas pelos valores desejados
      $baseFormatada = str_replace("[", "", $base);
      $baseFormatada = str_replace("]", "", $baseFormatada);
			$baseFormatada = str_replace($colunas, $alterar, $baseFormatada);

			// Valida se a string contém apenas caracteres permitidos
			if (!preg_match('#^[0-9+\-*/(). ]+$#', $baseFormatada)) {
				return '###'; // Indica erro na fórmula
			}

			// Usa eval de forma segura
			$resultado = @eval('return ' . $baseFormatada . ';');

			// Se o resultado for inválido, retorna '###'
			if ($resultado === false || is_null($resultado)) {
				return '###';
			}

			// Formata o resultado com 2 casas decimais
			return number_format($resultado, 2, '.', '');
		} catch (Throwable $e) {
			// Em caso de erro, retorna um indicador de erro
			return '###';
		}
	}

  function formatarNumero($numero) {
    // Verifica se o número tem casas decimais diferentes de zero
    if (fmod($numero, 1) !== 0.0) {
        // Formata com 2 casas decimais
        return number_format($numero, 2, ',', '.');
    } else {
        // Formata sem casas decimais
        return number_format($numero, 0, ',', '.');
    }
  }

  function getNivel($idNivel){
    if($idNivel == 1)
      $nivel = "Moderador";

    if($idNivel == 2)
      $nivel = "Consulta";

    return $nivel;
  }

  function getStatus($idStatus){
    if($idStatus == 1)
      $nivel = "Ativo";

    if($idStatus == 2)
      $nivel = "Bloqueado";

    if($idStatus == 3)
      $nivel = "Expirado";

    return $nivel;
  }

  function getExp($data){
    $data_atual = new DateTime(date("Y-m-d"));

    $data_expira = new DateTime($data);

    $diferenca = $data_atual->diff($data_expira);

    if ($diferenca->invert) {
      $mensagem = "<font color='red'> Expirou a ".$diferenca->days." dias </font> ";
    } else {
      $mensagem = "<font  color='blue'> Expira em ".$diferenca->days." dias </font> ";
    }

    return $mensagem;
  }

  function statusPay($status){

    if($status == 1)
      return "Pendente";

    if($status == 2)
      return "<font color='#0B0'>Pago</font>";

    if($status == 3)
      return "<font color='#F00'>Cancelado</font>";


  }

  function parcelas($valor){
    if($valor <= 40)
      return 1;
    elseif($valor > 40 && $valor <= 200)
      return 5;
    elseif($valor > 200 && $valor <= 300)
      return 8;
    else
      return 10;
  }
?>
