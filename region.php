<?php
    require_once "method.php";

    $product = new Product();
    
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
    case 'GET':
            $product->get_count_by_region();
        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
        break;
    }
 
?>