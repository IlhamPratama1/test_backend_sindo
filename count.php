<?php
    require_once "method.php";

    $product = new Product();
    
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
    case 'GET':
            $product->get_total_count();
        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
        break;
    }
 
?>