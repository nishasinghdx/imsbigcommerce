<?php
session_start();
if($_SESSION['login_user'] < 1){
	header("Location: index.php");  
}
?>
<!DOCTYPE html>
<html class='no-js' lang='en'>
<head>
  <meta charset='utf-8'>
  <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
  <title>Tables</title>
  <meta content='lab2023' name='author'>
  <meta content='' name='description'>
  <meta content='' name='keywords'>
  <link href="assets/stylesheets/application-a07755f5.css" rel="stylesheet" type="text/css" />
  <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/images/favicon.ico" rel="icon" type="image/ico" />
  <?php
  include 'bgcommerceController.php';
  $res = new bigapi;
  $model = 17;
  $year = 109;
  $Products = $res->FetchProducts($model,$year);
  ?>
  
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  
  
<script>
	function editProduct(productId){
		$('.view_'+productId).hide();
		$('#input_name_'+productId).show();
		$('#input_price_'+productId).show();
		$('#input_quantity_'+productId).show();
		$('#edit_'+productId).hide();
		$('#save_'+productId).show();
		
	}
	
	
	function saveProduct(productId){
		
		var name = $('#input_name_'+productId).val();
		var price = $('#input_price_'+productId).show();
		var quantity =  $('#input_quantity_'+productId).show();
		
		$('.view_'+productId).show();
		$('#input_name_'+productId).hide();
		$('#input_price_'+productId).hide();
		$('#input_quantity_'+productId).hide();
		$('#edit_'+productId).show();
		$('#save_'+productId).hide();
		
	}
	
	
	
	
	
	

</script>
</head>
<body class='main page'>
  <!-- Navbar -->
  <div class='navbar navbar-default' id='navbar'>
    <a class='navbar-brand' href='#'>
        <i class='icon-globe'></i>
        International Marine
      </a>
  </div>
  <div id='wrapper'>
    <!-- Sidebar -->
         <section id='sidebar'>
        <i class='icon-align-justify icon-large' id='toggle'></i>
        <ul id='dock'>
          <li class=' launcher'>
            <i class='icon-dashboard'></i>
            <a href="dashboard.php">Dashboard</a>
          </li>
          <li class=' launcher'>
            <i class='icon-file-text-alt'></i>
            <a href="addproducts.php">Add Parts</a>
          </li>
          <li class='launcher active'>
            <i class='icon-table'></i>
            <a href="listProducts.php">View Parts</a>
          </li>
		   <li class='launcher'>
            <i class='icon-signout'></i>
            <a href="logout.php">Logout</a>
          </li>

        </ul>
        <div data-toggle='tooltip' id='beaker' title='Made by DesignersX'></div>
      </section>
    <!-- Tools -->
    <section id='tools'>
      <ul class='breadcrumb' id='breadcrumb'>
        <li class='title'>Parts</li>
        <li><a href="#">List Items</a></li>
      </ul>
      <div id='toolbar'></div>
    </section>   
    <!-- Content -->
    <div id='content'>
      <div class='panel panel-default grid'>
        <div class='panel-heading'>
          <div class='row'>
            <div class='col-md-2'>
                <i class='icon-table icon-large'></i> List Items
            </div>
            <div class='col-md-3' style="float:right;">
              <select name="partno" id="partno" class="form-control" placeholder="Select Year" style="border:1px solid #00bca4!important;" onchange="sortList(this.value);">
                  <option value="">Select Year</option>
                  <option value="all">Show All</option>
                  <?php
                  $years = $res->FetchYears(17);
                    foreach ($years as $Year) {   ?>
                    <option value="<?php  echo $Year['year_id']; ?>"><?php  echo $Year['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>
        </div>

        <table class='table' id="table1" >
          <thead>
            <tr>
              <th>#</th>
              <th>Product Name</th>
              <th>SKU</th>
			  <th>Price</th>
			  <th>Model</th>
			  <th>Year</th>             
              <th>Minimum Qty</th>              
              <th class='actions'>
                Actions
              </th>
            </tr>
          </thead>
          <tbody>

            <?php foreach ( $Products as $key => $Product) {
              $res = new bigapi;
              $getModelName = $res->modelName($Product['model']);
              $getYearName = $res->yearName($Product['year']);
              ?>


            <tr id="row-<?php echo $Product['id']; ?>">
				<td width="7%"><?php echo $key+1; ?> </td>
				<td width="18%" id="title-<?php echo $Product['id']; ?>" >
					<input type="text" value="<?php echo $Product['name']; ?>" id="<?php echo 'input_name_'.$Product['id'] ?>" style="display:none;"/> 
					<p class="<?php echo 'view_'.$Product['id'] ?>"  ><?php echo $Product['name']; ?> </p>
				</td>
				<td width="15%"><?php echo $Product['sku']; ?> </td>
				<td width="10%">				 
					<input type="text" value="<?php echo $Product['price']; ?>" id="<?php echo 'input_price_'.$Product['id'] ?>" style="display:none;"/> 
					<p class="<?php echo 'view_'.$Product['id'] ?>" ><?php echo $Product['price']; ?> </p>		
				
				</td>
				<td width="10%"><?php echo $Product['model_id']; ?> </td> 
				<td width="10%"><?php echo $Product['year_id']; ?> </td>
				<td width="10%">
					<input type="text" value="<?php echo $Product['order_quantity_minimum']; ?>" id="<?php echo 'input_quantity_'.$Product['id'] ?>" style="display:none;"/> 
					<p class="<?php echo 'view_'.$Product['id'] ?>" ><?php echo $Product['order_quantity_minimum']; ?> </p>	
				</td>					
              <td class='action'width="10%">
                
                <a class='btn btn-info' id="edit_<?php echo $Product['id']; ?>" href="javascript:editProduct('<?php echo $Product['id']; ?>')" style="cursor:pointer;">
                    <i class='icon-edit'></i>
                </a>
				<a class='btn btn-info' id="save_<?php echo $Product['id']; ?>" href="javascript:saveProduct('<?php echo $Product['id']; ?>')" style="cursor:pointer;background-color:#00bca4;display:none;">
                    <i class='icon-check'></i>
                </a>
                 
                <a class='btn btn-danger' href='javascript:deletePart(<?php echo $Product['id']; ?>);' style="cursor:pointer;">
                    <i class='icon-trash'></i>
                  </a>

              </td>
            </tr>
          <?php }  ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
  <!-- Footer -->


	

<link rel="stylesheet" href="css/freenbar.css">
<style>
#barwrap {
  margin-bottom: 30px; /* space between the bar and your content */
}
.bar{
  text-align: center;
      padding: 8px;
      padding-top: 0px;
      background-color: #005baa;
      max-height: 100px;
      position: absolute;
      top: 71px;
      left: 80px;
      right: 0px;
      color: #f5f5f5;
  -webkit-box-shadow:  0px 2px 13px 0.5px rgba(0, 0, 0, 0.3);
  box-shadow:  0px 2px 13px 0.5px rgba(0, 0, 0, 0.3);
  display: none;
  z-index: 3008;
}

#head-image{
  margin-right: 1%;
  position: relative;
  top: 8px;
}

#text{
  font-size: 16px;
  top: 12px;
  text-align: center;position: relative;
}

#otherimg{

/* Your code here for that section */

}

#ok{
  float: right;
  margin-top: 6px;
  margin-right: 10px;
  font-size: 25px;
}

#ok a {
  color: #1abc9c;
  text-decoration: none;
}

</style>
</body>
</html>
