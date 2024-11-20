<?php
  function formatarCelula($valor, $tipo){
    $valorFormat = $valor;

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
			$baseFormatada = str_replace($colunas, $alterar, $base);

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
?>
