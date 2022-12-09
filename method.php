<?php

    require_once "koneksi.php";
    
    class User {
        public  function get_all_users()
        {
            global $mysqli;

            $data = array();

            $query = "SELECT * FROM users";
            $result = $mysqli->query($query);
            while($row = mysqli_fetch_object($result)) {
                $data[] = $row;
            }

            $response = array(
                'success' => true,
                'message' =>'Get List Users Successfully.',
                'data' => $data
            );

            header('Content-Type: application/json');
            echo json_encode($response);
        }

        public function get_user($id = 0)
        {
            global $mysqli;

            $query = "SELECT * FROM users";
            if ($id != 0) {
                $query .= " WHERE id=" . $id . " LIMIT 1";
            }

            $data = array();
            $result = $mysqli->query($query);
            while($row = mysqli_fetch_object($result)) {
                $data[] = $row;
            }

            $response = array(
                'success' => true,
                'message' =>'Get User Successfully.',
                'data' => $data
            );

            header('Content-Type: application/json');
            echo json_encode($response);    
        }

        public function insert_user()
        {
            global $mysqli;

            $arr_check_post = array('email' => '', 'name' => '', 'region' => '');
            $count = count(array_intersect_key($_POST, $arr_check_post));

            if ($count == count($arr_check_post)) {
            
                $result = mysqli_query($mysqli, "INSERT INTO users SET
                    email = '$_POST[email]',
                    name = '$_POST[name]',
                    region = '$_POST[region]'
                ");
                    
                if ($result) {
                    $response = array(
                        'success' => true,
                        'message' =>'User Added Successfully.'
                    );
                } else {
                    $response = array(
                        'success' => false,
                        'message' =>'User Addition Failed.'
                    );
                }
            } else {
                $response = array(
                    'success' => false,
                    'message' =>'Parameter Do Not Match'
                );
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }

        function update_user($id)
        {
            global $mysqli;
            
            $arr_check_post = array('email' => '', 'name' => '', 'region' => '');
            $count = count(array_intersect_key($_POST, $arr_check_post));

            if($count == count($arr_check_post)) {
            
                $result = mysqli_query($mysqli, "UPDATE users SET
                email = '$_POST[email]',
                name = '$_POST[name]',
                region = '$_POST[region]'
                WHERE id = '$id'");
            
                if ($result) {
                    $response = array(
                        'success' => true,
                        'message' =>'User Updated Successfully.'
                    );
                } else {
                    $response = array(
                        'success' => false,
                        'message' =>'User Updation Failed.'
                    );
                }
            } else {
                $response = array(
                    'success' => false,
                    'message' =>'Parameter Do Not Match'
                );
            }
            header('Content-Type: application/json');
            echo json_encode($response);
        }

        function delete_user($id)
        {
            global $mysqli;

            $query = "DELETE FROM users WHERE id = " . $id;
            if(mysqli_query($mysqli, $query)) {
                $response = array(
                    'success' => true,
                    'message' =>'User Deleted Successfully.'
                );
            } else {
                $response=array(
                    'success' => false,
                    'message' =>'User Deletion Failed.'
                );
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    class Product {
        public  function get_all_products()
        {
            global $mysqli;
            $batas = 10;
            $data = array();

            $halaman = isset($_GET['page'])?(int)$_GET['page'] : 1;
			$halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;	

			$countQuery = "SELECT * from products limit " . $halaman_awal . ", " . $batas;
            $countResult = $mysqli->query($countQuery);

            $jumlah_data = mysqli_num_rows($countResult);
 
			$query = "SELECT * from products limit " . $halaman_awal . ", " . $batas;
			$nomor = $halaman_awal + 1;

            $result = $mysqli->query($query);
            while($row = mysqli_fetch_object($result)) {
                $data[] = $row;
            }

            $response = array(
                'success' => true,
                'message' =>'Get List Products Successfully.',
                'number' => $nomor,
                'data' => $data
            );

            header('Content-Type: application/json');
            echo json_encode($response);
        }

        public function get_product($id = 0)
        {
            global $mysqli;

            $query = "SELECT * FROM products";
            if ($id != 0) {
                $query .= " WHERE id=" . $id . " LIMIT 1";
            }

            $data = array();
            $result = $mysqli->query($query);
            while($row = mysqli_fetch_object($result)) {
                $data[] = $row;
            }

            $response = array(
                'success' => true,
                'message' =>'Get Product Successfully.',
                'data' => $data
            );

            header('Content-Type: application/json');
            echo json_encode($response);    
        }

        public function get_total_count()
        {
            global $mysqli;

            $query = "SELECT name, COUNT(*) as product_count FROM products GROUP BY 'name' ORDER BY product_count DESC";

            $data = array();
            $result = $mysqli->query($query);
            while($row = mysqli_fetch_object($result)) {
                $data[] = $row;
            }

            $response = array(
                'success' => true,
                'message' =>'Get Total Count Product Successfully.',
                'data' => $data
            );

            header('Content-Type: application/json');
            echo json_encode($response);    
        }

        public function get_highest_product()
        {
            global $mysqli;

            $query = "SELECT * FROM products GROUP BY 'name' ORDER BY price DESC";

            $data = array();
            $result = $mysqli->query($query);
            while($row = mysqli_fetch_object($result)) {
                $data[] = $row;
            }

            $response = array(
                'success' => true,
                'message' =>'Get Highest Price of Product Successfully.',
                'data' => $data
            );

            header('Content-Type: application/json');
            echo json_encode($response);    
        }
        
        public function get_count_by_region()
        {
            global $mysqli;

            $query = "SELECT region, COUNT(*) as product_count FROM users as usr GROUP BY 'region' ORDER BY product_count DESC";

            $data = array();
            $result = $mysqli->query($query);
            while($row = mysqli_fetch_object($result)) {
                $data[] = $row;
            }

            $response = array(
                'success' => true,
                'message' =>'Get Total Count Product Successfully.',
                'data' => $data
            );

            header('Content-Type: application/json');
            echo json_encode($response);    
        }

        public function insert_product()
        {
            global $mysqli;

            $arr_check_post = array('user_id' => '', 'name' => '', 'price' => '');
            $count = count(array_intersect_key($_POST, $arr_check_post));

            if ($count == count($arr_check_post)) {
            
                $result = mysqli_query($mysqli, "INSERT INTO products SET
                    user_id = '$_POST[user_id]',
                    name = '$_POST[name]',
                    price = '$_POST[price]'
                ");
                    
                if ($result) {
                    $response = array(
                        'success' => true,
                        'message' =>'User Added Successfully.'
                    );
                } else {
                    $response = array(
                        'success' => false,
                        'message' =>'User Addition Failed.'
                    );
                }
            } else {
                $response = array(
                    'success' => false,
                    'message' =>'Parameter Do Not Match'
                );
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }

        function update_product($id)
        {
            global $mysqli;
            
            $arr_check_post = array('user_id' => '', 'name' => '', 'price' => '');
            $count = count(array_intersect_key($_POST, $arr_check_post));

            if($count == count($arr_check_post)) {
            
                $result = mysqli_query($mysqli, "UPDATE products SET
                user_id = '$_POST[user_id]',
                name = '$_POST[name]',
                price = '$_POST[price]'
                WHERE id = '$id'");
            
                if ($result) {
                    $response = array(
                        'success' => true,
                        'message' =>'User Updated Successfully.'
                    );
                } else {
                    $response = array(
                        'success' => false,
                        'message' =>'User Updation Failed.'
                    );
                }
            } else {
                $response = array(
                    'success' => false,
                    'message' =>'Parameter Do Not Match'
                );
            }
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    class UserTransaction {
        function transfer_balance()
        {
            global $mysqli;

            $arr_check_post = array('from_user_id' => '', 'to_user_id' => '', 'balance' => '');
            $count = count(array_intersect_key($_POST, $arr_check_post));

            if ($count == count($arr_check_post)) {   
                $result = mysqli_query($mysqli, "INSERT INTO user_transaction SET
                    from_user = '$_POST[from_user_id]',
                    to_user = '$_POST[to_user_id]',
                    balance = '$_POST[balance]'
                ");
                    
                if ($result) {
                    $response = array(
                        'success' => true,
                        'message' =>'Transfer Balance Successfully.'
                    );
                } else {
                    $response = array(
                        'success' => false,
                        'message' =>'Transfer Balance Failed.'
                    );
                }
            } else {
                $response = array(
                    'success' => false,
                    'message' =>'Parameter Do Not Match'
                );
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }

        function get_all_transaction() {
            global $mysqli;

            $data = array();

            $query = "SELECT * FROM user_transaction";
            $result = $mysqli->query($query);
            while($row = mysqli_fetch_object($result)) {
                $data[] = $row;
            }

            $response = array(
                'success' => true,
                'message' =>'Get List User Transaction Successfully.',
                'data' => $data
            );

            header('Content-Type: application/json');
            echo json_encode($response);
        }

        public function get_user_transaction($id = 0)
        {
            global $mysqli;

            $query = "SELECT * FROM user_transaction";
            if ($id != 0) {
                $query .= " WHERE from_user=" . $id . " OR to_user=" . $id . " LIMIT 1";
            }

            $data = array();
            $result = $mysqli->query($query);
            while($row = mysqli_fetch_object($result)) {
                $data[] = $row;
            }

            $response = array(
                'success' => true,
                'message' =>'Get User Transaction Successfully.',
                'data' => $data
            );

            header('Content-Type: application/json');
            echo json_encode($response);    
        }
    }

 ?>