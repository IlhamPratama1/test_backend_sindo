<?php
    require_once "method.php";

    $product = new Product();
    
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
    case 'GET':
            $product->get_highest_product();
        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
        break;
    }
 
?>