<?php
    require_once "method.php";

    $user_transaction = new UserTransaction();
    
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            $user_transaction->get_user_transaction($id);
        } else {
            $user_transaction->get_all_transaction();
        }
        break;
    case 'POST':
            $user_transaction->transfer_balance(); 
        break; 
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
        break;
    }
 
?>