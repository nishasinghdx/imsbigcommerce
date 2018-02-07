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
    <title>Dashboard</title>
    <meta content='lab2023' name='author'>
    <meta content='' name='description'>
    <meta content='' name='keywords'>
    <link href="assets/stylesheets/application-a07755f5.css" rel="stylesheet" type="text/css" /><link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/images/favicon.ico" rel="icon" type="image/ico" />
		<link href="assets/stylesheets/dcalendar.picker.css" rel="stylesheet" type="text/css">
		<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <?php
      include 'bgcommerceController.php';
      $res = new bigapi;



      //$percent = $res->SyncProductPersentage();
			if(isset($_POST['ActionType'])  && $_POST['ActionType'] == 'updatedSync' && !empty($_POST['mindate']) && !empty($_POST['maxdate'] ) ){
				 $mindate = str_replace("/","-",$_POST['mindate']);
				 $maxdate = str_replace("/","-",$_POST['maxdate']);
				//$sync =  $res->syncUpdatedProducts();
				$products = $res->syncUpdatedProducts($mindate,$maxdate);
				$products = $res->syncOptions();
				print_r($products);
			}


    	if( $_POST['ActionType'] == 'Syncall' ){
        $sync =  $res->syncUpdatedProducts();
      }


		 if(isset($_POST["SyncModels"])){
		 $res->syncOptions();
		 }

    ?>


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
          <li class='active launcher'>
            <i class='icon-dashboard'></i>
            <a href="dashboard.php">Dashboard</a>
          </li>
          <li class='launcher'>
            <i class='icon-file-text-alt'></i>
            <a href="addproducts.php">Add Parts</a>
          </li>
          <li class='launcher'>
            <i class='icon-table'></i>
            <a href="listProducts.php">View Parts</a>
          </li>
		   <li class='launcher'>
            <i class='icon-table'></i>
            <a href="logout.php">Logout</a>
          </li>

        </ul>
        <div data-toggle='tooltip' id='beaker' title='Made by DesignersX'></div>
      </section>

      <!-- Tools -->
      <section id='tools'>
        <ul class='breadcrumb' id='breadcrumb'>
          <li class='title'>Dashboard</li>
        </ul>
      </section>
      <!-- Content -->
      <div id='content'>
        <div class='panel panel-default'>
          <div class='panel-heading'>
            <i class='icon-dashboard icon-large'></i>


          </div>
          <div class='panel-body'>

            <div class='page-header'>
              <h4>Sync products</h4>
            </div>
            <div class='row text-center'>

							<div class='col-md-6'>
								<form name="updatedsync" method="POST" action="">

									<div class='col-md-4' style="text-align: left;"><b>Start Date:</b><br/><input class="form-control" id="mindate" name="mindate" type="text"></div>
									<div class='col-md-4' style="text-align: left;"><b>End Date:</b><br/><input class="form-control" id="maxdate" name="maxdate"  type="text"></div>
									<div class='col-md-4'><br/>

										<button class="btn btn-default" type="submit" name="ActionType" value="updatedSync" style="    padding: 5px 5px;    font-size: 14px;    text-transform: uppercase;    background: #1abc9c;    color: #fff;">Sync Products</button>

										<button class="btn btn-default" type="submit" name="ActionType" value="Syncall" style="    padding: 5px 5px;    font-size: 14px;    text-transform: uppercase;    background: #1abc9c;    color: #fff;">Sync All</button>

									</div>
								</form>

								<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
								<script src="assets/javascripts/dcalendar.picker.js"></script>
								<script>
								$('#mindate').dcalendarpicker();$('#maxdate').dcalendarpicker();
								</script>

  					</div>




							<div class='col-md-3'>
                <?php if($percent < 1 ){  $percent = 1;     }?>
                <input class='knob second' data-bgcolor='#d4ecfd' data-fgcolor='#30a1ec' data-height='140' data-inputcolor='#333' data-thickness='.3' data-width='140' type='text' value='<?php echo   $percent; ?>'>
                <br/>
                <?php if($percent < 100){  ?>
                <form class="form-horizontal" name="form1" action="" method="post" >
                  <div class="form-actions" style=" background-color:#fff;">
										<input type="hidden" name="Sync" value="1" />
                  <!--  <button class="btn btn-default" type="submit" name="ActionType" value="Sync" style="    padding: 12px 12px;    font-size: 18px;    text-transform: uppercase;    background: #1abc9c;    color: #fff;">Sync Products</button>-->
                  </div>
                </form>
                <?php }else{ ?>

                  <div class="form-actions" style=" background-color:#fff;">
				  <input type="hidden" name="Sync" value="1"/>
                    <!--  <button class="btn btn-default" type="submit" name="ActionType" value="Sync" style="    padding: 12px 12px;    font-size: 18px;    text-transform: uppercase;     color: #fff; margin-top: 20px;"  onclick="uptodate();">Sync Products</button>-->
                  </div>

                <?php } ?>
              </br/>
              </div>





              <!--  <div class='col-md-3'>
                <input class='knob second' data-bgcolor='#c4e9aa' data-fgcolor='#8ac368' data-height='140' data-inputcolor='#333' data-thickness='.3' data-width='140' type='text' value='75'>
              </div>
              <div class='col-md-3'>
                <input class='knob second' data-bgcolor='#cef3f5' data-fgcolor='#5ba0a3' data-height='140' data-inputcolor='#333' data-thickness='.3' data-width='140' type='text' value='35'>
              </div>
              <div class='col-md-3'>
                <input class='knob second' data-bgcolor='#f8d2e0' data-fgcolor='#b85e80' data-height='140' data-inputcolor='#333' data-thickness='.3' data-width='140' type='text' value='85'>
              </div>  -->

            </div>
						<h4>Sync Models</h4>
						<form name="SyncModels" method="POST" action="">
					  <button class="btn btn-default" type="submit" name="SyncModels" value="SyncModels" style="padding:5px 5px;font-size:14px;text-transform:uppercase;background:#1abc9c;color: #fff;">Sync Models</button>
					 </form>

          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <!-- Javascripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script><script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js" type="text/javascript"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js" type="text/javascript"></script><script src="assets/javascripts/application-985b892b.js" type="text/javascript"></script>
    <!-- Google Analytics -->
    <script>
    function uptodate(){

      alert("Products is uptodate!")
    }
    </script>



  </body>
</html>
