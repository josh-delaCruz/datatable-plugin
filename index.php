<?php
    include "./pages/method.php";
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
    
    header('Content-Type: application/json');

    //http method GET - POST - PUT - DELETE 
    $method = $_SERVER['REQUEST_METHOD']; 

    //page data
    $start = @$_POST["start"] ?? 0;
    $length = @$_POST["length"] ?? 10;


    //filter
    /* 
    $filter = $_POST["search[value]"];
    */

    $totalElements = get_totalElements();
    $totPages = get_totPages($totalElements, $length);

    $url = "http://localhost:8080/employees/index.php";
    
    //array
    
    $response = array(
        "data" => array(),
        "recordsFiltered" => intval($totalElements), //result element
        "recordsTotal" => intval($totalElements) //all element
    );
    
    switch($method){
        case 'GET':
        case 'POST': 
            $response["data"] = get($start, $length);
            echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        default:
            header("HTTP/1.1 400 BAD REQUEST");
            break;
    }

    

    //echo "test";
    /*
    switch($method){

        case 'GET':
            $response["employees"] = get($start, $length);
            echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        case 'POST':
            $jsonInput = json_decode(file_get_contents('php://input'), true);
            post($jsonInput["first_name"], $jsonInput["last_name"], $jsonInput["gender"]);


            $response["employees"] = get($start, $length); 
            echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;  

        case 'PUT':
            $jsonInput = json_decode(file_get_contents('php://input'), true);
            PUT($jsonInput["first_name"], $jsonInput["last_name"], $jsonInput["gender"], $id);

            break;

        case 'DELETE':
            delete($id);
            break;

        default:
            header("HTTP/1.1 400 BAD REQUEST");
            break;
    }*/

    //get total elements
    function get_totalElements()
    {
        require ("./pages/database.php");
        
        /*
        $querytotE = "SELECT count(*) AS totalElements FROM mydb";
        if($result = $mysqli->query($querytotE)){
            while($row=$result->fetch_assoc()){
                $totE = intval($row["totalElements"]);
            }
        }
        return $totE;
        */

        $query = "SELECT count(*) FROM employees";

        $result = $mysqli-> query($query);
        $totE = $result-> fetch_row();

        return $totE[0];
    }

    //get total pages
    function get_totPages($totalElements, $lenght)
    {
        require ("./pages/database.php");

        $totP = ceil($totalElements/$lenght) -1;
        return $totP;
    }

    function href($url, $page, $lenght){
        return $url . "?page=" . $page . "&size=" . $lenght;
    }

    function set_link($page, $lenght, $totPages, $url)
    {
        $links = array(
            "first" => array ( "href" => href($url, 0, $lenght)),
            "self" => array ( "href" => href($url, $page, $lenght), "templated" => true),
            "last" => array ( "href" => href($url, $totPages, $lenght))
        );
        
        if($page > 0){
            $links["prev"] = array( "href" => href($url, $page - 1, $lenght));
        }
        
        if($page < $totPages){
            $links["next"] = array ( "href" => href($url, $page + 1, $lenght));
        }
        
        return $links;
    }
?>