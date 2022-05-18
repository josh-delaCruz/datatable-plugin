<?php

    if(isset($_POST["start"])){
        $start = $_POST["start"];
    }

    if(isset($_POST["start"])){
        $length = $_POST["lenght"];
    }else{
        $lenght = 1;
    }

    $totalElements = 10;

    $data = array(
        "employees" => array(
            
        ),
        "recordFiltered" => intval($totalElements), //result element
        "recordsTotal" => intval($totalElements) //all element
    );

    require "pages/method.php";
    $data["employees"] = get($start, $length);

?>