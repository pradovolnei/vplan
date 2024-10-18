<?php
  function formatarCelula($valor){
    $valorFormat = $valor;

    if(isDate($valor, "Y-m-d")){
      $valorFormat = date("d/m/Y", strtotime($valor));
    }

    if (is_numeric($valor)) {
      if (strpos($valor, '.') !== false) {
          $valorFormat = number_format($valor, 2, ',', '.');
      }else{
        $valorFormat = number_format($valor, 0, ',', '.');
      }
    }

    return $valorFormat;
  }

  function isDate($date, $format) {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
  }
?>
