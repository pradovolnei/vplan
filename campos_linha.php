<?php

  $conn = mysqli_connect("localhost", "root", "");
  mysqli_select_db($conn, "vplan");

  ini_set('default_charset','UTF-8');
  mysqli_set_charset($conn, "utf8");

  $listaTipos = "SELECT dp.value, t.sub_type, dp.number_column, dp.type_id, titulo
  FROM data_plans dp
  LEFT JOIN TYPES t ON t.id = dp.type_id
  LEFT JOIN (SELECT plan_id, value AS titulo, number_column FROM data_plans WHERE plan_id = ".$_GET["p"]." AND number_line=0)AS pt ON pt.plan_id = dp.plan_id AND dp.number_column = pt.number_column
  WHERE dp.number_line = ".$_GET["l"]." AND dp.plan_id = ".$_GET["p"];

  $corpo = "";

  $execTipos = mysqli_query($conn, $listaTipos);

  while($col = mysqli_fetch_array($execTipos)){
    $numberColumn = $col["number_column"];
    if($col["sub_type"] == "select"){
      $corpo .= '<div class="form-group row">';
      $corpo .= '<select class="custom-select" name="valor[]" required >';

      $sqlOptions = "SELECT * FROM listas WHERE deleted_at IS NULL AND plan_id = ".$_GET["p"]." AND number_column = $numberColumn ORDER BY value";
      $execoptions = mysqli_query($conn, $sqlOptions);

      while($rowOptions = mysqli_fetch_array($execoptions)){
        $selected = "";
        if($rowOptions["value"] == $col["value"])
          $selected = "selected";
      $corpo .= '<option value="'.$rowOptions["value"].'" '.$selected.' > '.$rowOptions["value"].' </option>';
      }

      $corpo .= '</select>';
      $corpo .= '</div>';

    }else{
      $corpo .= '<div class="form-group row">';
      $corpo .= '<input type="'.$col["sub_type"].'" class="form-control" name="valor[]" placeholder="'.$col["titulo"].'" value="'.$col["value"].'">';
      $corpo .= '</div>';
    }

    $corpo .= "<input type='hidden' name='old_valor[]' value='".$col["value"]."' />";

  }

  echo $corpo;
?>
