<?php
    include "./pages/method.php";
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
    
    header('Content-Type: application/json');

    //http method GET - POST - PUT - DELETE 
    $method = $_SERVER['REQUEST_METHOD']; 

    //page data

    //get id
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }else{
        $id = 0;
    }
    //get page
    if(isset($_GET["page"])){
        $page = $_GET["page"];
    }else{
        $page = 0;
    }
    //get size
    if(isset($_GET["size"])){
        $size = $_GET["size"];
    }else{
        $size = 20;
    }

    //filter 
    $filter = $_POST["search[value]"];

    $totalElements = get_totalElements();
    $totPages = get_totPages($totalElements, $size);

    $url = "http://localhost:8080/employees/index.php";
    
    //array
    
    $data = array(
        "employees" => array(
        ),
        "recordFiltered" => $totalElements //result element
        "recordTotal" => $totalElements //all element
    );
    
    //echo "test";
    switch($method){

        case 'GET':
            $data["_embedded"]["employees"] = get($page, $size); //add employees data
            echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); //transforms data array in json
        case 'POST':
            $jsonInput = json_decode(file_get_contents('php://input'), true);
            post($jsonInput["first_name"], $jsonInput["last_name"], $jsonInput["gender"]);
            //echo json_encode($jsonInput);
            break;

        case 'PUT':
            $jsonInput = json_decode(file_get_contents('php://input'), true);
            PUT($jsonInput["first_name"], $jsonInput["last_name"], $jsonInput["gender"], $id);
            //echo json_encode($jsonInput);
            break;

        case 'DELETE':
            delete($id);
            break;
        
        //in case of bad request
        default:
            header("HTTP/1.1 400 BAD REQUEST");
            break;
    }

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
    function get_totPages($totalElements, $size)
    {
        require ("./pages/database.php");

        $totP = ceil($totalElements/$size) -1;
        return $totP;
    }

    function href($url, $page, $size){
        return $url . "?page=" . $page . "&size=" . $size;
    }

    function set_link($page, $size, $totPages, $url)
    {
        $links = array(
            "first" => array ( "href" => href($url, 0, $size)),
            "self" => array ( "href" => href($url, $page, $size), "templated" => true),
            "last" => array ( "href" => href($url, $totPages, $size))
        );
        
        if($page > 0){
            $links["prev"] = array( "href" => href($url, $page - 1, $size));
        }
        
        if($page < $totPages){
            $links["next"] = array ( "href" => href($url, $page + 1, $size));
        }
        
        return $links;
    }
?>