<?php
session_start();
if(isset($_SESSION['login_user']) && empty($_SESSION['login_user'])){

	header("Location: index.php");  
}
?><?php
include 'bgcommerceController.php';
$res = new bigapi;
// $count = $res->ProductsCount();
// $products = $res->syncProducts();
?>

<div id="main_border_products">
<h2 style="text-align:center; margin-top: 0px;"> App Store Products</h2>
<table class="table" style="table-layout: fixed">
		 <thead>
			 <tr>
				<th>Product Id</th>
				<th>Product Name</th>
				<th>Product Description</th>
				<th>SKU</th>
				<th>Price</th>
				<th>Calculated Price</th>

			 </tr>
		 </thead>
		 <tbody>

		 <?php
        foreach ($products as $value) {
            $CustomFields = $res->ProductCustomFields($value->id); ?>
			 <tr>
			 <td><?php echo $value->id; ?></td>
			 <td><?php echo $value->name; ?></td>
				<td id="datass"><?php echo $value->description; ?></td>
				<td><?php echo $value->sku; ?></td>
				<td><?php echo $value->price; ?></td>
				<td><?php echo $value->calculated_price; ?></td>

		 </tr>
		 </tbody>

	<?php

        }
     ?>
</table>
</div>
