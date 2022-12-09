<?php
    require_once "method.php";

    $product = new Product();
    
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            $product->get_product($id);
        } else {
            $product->get_all_products();
        }
        break;
    case 'POST':
        if (!empty($_GET["id"]))
        {
            $id = intval($_GET["id"]);
            $product->update_product($id);
        } else {
            $product->insert_product();
        }     
        break; 
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
        break;
    }
 
?>