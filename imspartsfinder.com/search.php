<?php
include 'bgcommerceController.php';


if (isset($_GET['term'])){
	$return_arr = array();

	try {


	    $stmt = $PDO->prepare('SELECT * FROM Products WHERE sku LIKE :term');
	    $stmt->execute(array('term' => '%'.$_GET['term'].'%'));

	    while($row = $stmt->fetch()) {
				if($row['order_quantity_minimum'] == 0){   $row['order_quantity_minimum'] = 1;          }
	        $return_arr[] =  $row['sku'].' | '.$row['name'].' | $'.$row['price'].' | '.$row['product_id'].' | '.$row['order_quantity_minimum'];
	    }

	} catch(PDOException $e) {
	    echo 'ERROR: ' . $e->getMessage();
	}


    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
}


?>
