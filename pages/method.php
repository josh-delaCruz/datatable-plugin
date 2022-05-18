<?php

    //get all employee data
    function get($start, $lenght){

        $numCampo = $_POST["order"][0]["column"];
        $campo = $_POST["columns"][$numCampo]["data"];
        $direzione = $_POST["order"][0]["dir"];

        $searchVal = $_POST["search"]["value"];

        //$p = $page* $size;
        require("database.php");
        $query = "SELECT * FROM employees 
        WHERE first_name LIKE '%$searchVal%'
        OR last_name LIKE '%$searchVal%'
        OR id LIKE '%$searchVal%'
        OR gender LIKE '%$searchVal%'
        OR birth_date LIKE '%$searchVal%'
        OR hire_date LIKE '%$searchVal%'
        ORDER BY $campo $direzione LIMIT $start, $lenght ";

        $json = array();
        if($result = $mysqli-> query($query)){
            while($row = $result-> fetch_assoc()){
                $json[] = $row;
            }
        }
        return $json;
    }

    //add new employee
    function post($first_name, $last_name, $gender){
        require("database.php");
        $query = "INSERT INTO employees (first_name, last_name, gender) VALUES ('$first_name','$last_name', '$gender')";
        $result = $mysqli-> query($query);

    }

    //update an employee data
    function put($first_name, $last_name, $gender, $id){
        require("database.php");
        $query = "UPDATE employees SET first_name = '$first_name', last_name = '$last_name', gender = '$gender' WHERE id = '$id'";
        $result = $mysqli-> query($query);
        
    }

    //delete employee
    function delete($id){
        require("database.php");
        $query = "DELETE FROM employees WHERE id = $id";
        $result = $mysqli-> query($query);
        
    }

?>