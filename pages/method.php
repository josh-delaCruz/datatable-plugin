<?php

    //get all employee data
    function get($start, $length){
        require("database.php");

        $numCampo = $_POST["order"][0]["column"];
        $campo = $_POST["columns"][$numCampo]["data"];
        $direzione = $_POST["order"][0]["dir"];

        $searchVal = $_POST["search"]["value"];
        
        $stmt = $mysqli->prepare("SELECT * FROM employees 
                                    WHERE first_name LIKE ? 
                                    OR last_name LIKE ? 
                                    OR id = ? 
                                    OR gender LIKE ? 
                                    OR birth_date LIKE ? 
                                    OR hire_date LIKE ? 
                                    ORDER BY ".$campo." ".$direzione." LIMIT ".$start.", ".$length);

        $searchLike = "%".$searchVal."%";

        $stmt->bind_param("ssisss", 
                            $searchLike, 
                            $searchLike, 
                            $searchVal, 
                            $searchLike,
                            $searchLike,
                            $searchLike);

        $stmt -> execute();

        $json = array();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $json[] = $row;
        }

        return $json;
    }

    function filteredCount(){
        require("database.php");

        $numCampo = $_POST["order"][0]["column"];
        $campo = $_POST["columns"][$numCampo]["data"];
        $direzione = $_POST["order"][0]["dir"];

        $searchVal = $_POST["search"]["value"];
        
        $stmt = $mysqli->prepare("SELECT count(*) AS num FROM employees 
                                    WHERE first_name LIKE ? 
                                    OR last_name LIKE ? 
                                    OR id = ? 
                                    OR gender LIKE ? 
                                    OR birth_date LIKE ? 
                                    OR hire_date LIKE ? 
                                    ORDER BY ".$campo." ".$direzione);

        $searchLike = "%".$searchVal."%";

        $stmt->bind_param("ssisss", 
                            $searchLike, 
                            $searchLike, 
                            $searchVal, 
                            $searchLike,
                            $searchLike,
                            $searchLike);

        $stmt -> execute();

        $num = 0;
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $num = $row["num"];
            break;
        }

        return $num;
    }

?>