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

  if(!isset($_GET['model'])){
		$_GET['model'] = 17;
	}

	if(!isset($_GET['year'])){
		$_GET['year'] = 'all';
	}
  if(isset($_GET['model'])){
        $Products = $res->FetchBundles($_GET['model'],$_GET['year']);
  }else{

        $Products = $res->FetchBundles($_GET['model'],'all');
  }

  ?>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="resourses/jquery.table.hpaging.js"></script>
  <script src="assets/image-tooltip.js"></script>
  <script>
  $(document).ready(function () {
    $('.my-image').imageTooltip();
  });


  function deletePart(id) {
    var type = 'deletePart';
    if (confirm("Are you sure you want to delete this record?") == true) {
            $.ajax({
              url: 'request.php',
              type: 'POST',
              data: 'type='+type+'&bundleId='+id,
              success: function(data) {
                $("#row-"+id).hide(100);

                  var text = $("#title-"+id).html()+"deleted Sucessfully";
                  $("#text").html(text);
                  setTimeout(function(){
                    return $(".bar").animate({height:"toggle"},"slow")
                  },450);

                  setTimeout(function() {   //calls click event after a certain time
                     $("#ok").trigger('click');
                  }, 5000);



              },
              error: function(e) {
                  alert(e.message);
              }
            });
         } else {

         }

  }
	function syncPart(id) {
		var type = 'syncPart';
						$.ajax({
							url: 'sync.php',
							type: 'GET',
							data: 'type='+type+'&id='+id,
							success: function(data) {


									var text = $("#title-"+id).html()+"Updated Sucessfully";
									$("#text").html(text);
									setTimeout(function(){
										return $(".bar").animate({height:"toggle"},"slow")
									},450);

									setTimeout(function() {   //calls click event after a certain time
										 $("#ok").trigger('click');
									}, 5000);



							},
							error: function(e) {
									alert(e.message);
							}
						});


	}

	function syncPartAll() {










		var myCheckboxes = new Array();
        $("input:checked").each(function() {
           myCheckboxes.push($(this).val());
        });

				if(myCheckboxes.length>0){
					$("#overlay").show();
					setTimeout(function(){
						return $(".bar1").show()
					},450);
					console.log('myCheckboxes');
					console.log(myCheckboxes);
					$.ajax({
						url: 'sync.php',
						type: 'POST',
						dataType: 'html',
						data: {info:myCheckboxes},
						success: function(data) {
							  console.log('responce');
	              console.log(data);
								setTimeout(function(){
									$("#overlay").hide();
									return $(".bar1").hide()
								},450);
						},
						error: function(e) {
								alert(e.message);
						}
					});
				}else{
					alert("Please Select Products");
				}
  }

  function showhidePart(id) {

    var currentstatus = $("#status-"+id).val();
    if(currentstatus == 0){
        var status = 1;
      }else{
          var status = 0;
    }
    var type = 'showhidePart';
            $.ajax({
              url: 'request.php',
              type: 'POST',
              data: 'type='+type+'&bundleId='+id+'&status='+status,
              success: function(data) {
                    $("#status-"+id).val(status);
                    if(status == 0){
                        $("#eye-"+id).addClass('icon-eye-close');
                        $("#eye-"+id).removeClass('icon-eye-open');
                      }else{
                        $("#eye-"+id).addClass('icon-eye-open');
                        $("#eye-"+id).removeClass('icon-eye-close');
                    }
              },
              error: function(e) {
                  alert(e.message);
              }
            });

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
        <li><a href="#">List Parts</a></li>

      </ul>
      <div id='toolbar'>

      </div>
    </section>

		<div class="bar1">
      <div class="loader"></div>
    </div>
    <!-- Content -->
    <div id='content'>
      <div class='panel panel-default grid'>
        <div class='panel-heading'>
          <div class='row'>
            <div class='col-md-2'>
                <i class='icon-table icon-large'></i> List Parts
            </div>

            <div class='col-md-2' style="float:right;">
              <select name="partno" id="partno" class="form-control" placeholder="Select Year" style="border:1px solid #00bca4!important;" onchange="sortList(this.value);">
                  <option value="">Select Year</option>
                  <option value="all">Show All</option>
                  <?php
									$model = $_GET['model'];
                  $years = $res->FetchYears($model);
                    foreach ($years as $Year) {   ?>
                    <option value="<?php  echo $Year['year_id']; ?>"   ><?php  echo $Year['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
						<div class='col-md-1' style="float:right;">
							<select name="partno" id="partno" class="form-control" placeholder="Select Year" style="border:1px solid #00bca4!important;" onchange="sortmodelList(this.value);">

									<?php
									$modles = $res->FetchModels();
										foreach ($modles as $modle) {   ?>
										<option value="<?php  echo $modle['model_id']; ?>"  <?php if($model == $modle['model_id']){  echo "selected";  } ?>><?php  echo $modle['name']; ?></option>
										<?php } ?>
								</select>
						</div>
          </div>

        </div>

        <table class='table' id="table1" >
          <thead>
						<tr>
							<th>
							<button type="button" id="selectAll" value = " Select All" class=" btn btn-default">Select All</button>
						  </th>
							<th>
							<a class='btn btn-success' href='javascript:syncPartAll();'>Sync All</a>
							</th>
					  </tr>
            <tr>
							<th><i class="icon-foursquare"></i></i></th>
              <th>#</th>
              <th>Title</th>
              <th>Model</th>
              <th>Year</th>
              <th>Image</th>
              <th>description</th>
              <th>created Date</th>
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
							<th><input type="checkbox" id = "checkbox<?php echo $Product['id']; ?>" class = "checkbox btn btn-lg" value = "<?php echo $Product['id']; ?>"/></th>
              <td width="7%"><?php echo $key+1; ?> </td>
              <td width="13%" id="title-<?php echo $Product['id']; ?>" ><?php echo $Product['title']; ?> </td>
              <td width="10%"><?php echo $getModelName['name']; ?> </td>
              <td width="20%"><?php echo $getYearName['name']; ?> </td>
              <td width="5%"><img src="resourses/Images/<?php echo $Product['image']; ?>" class="my-image imgshadow"  width="20"   /></td>
              <td width="25%"><?php echo $Product['description']; ?> </td>
              <td width="10%"><?php echo $Product['created_date']; ?> </td>
              <td class='action'width="10%">
                <a class='btn btn-danger' href='javascript:showhidePart(<?php echo $Product['id']; ?>,<?php echo $Product['status']; ?>);' style="background-color:#1abc9c;border-color:#1abc9c;cursor:pointer;">
                    <i id="eye-<?php echo $Product['id']; ?>" class='<?php if($Product['status'] == 1){  ?>icon-eye-open<?php }else{  ?> icon-eye-close<?php } ?>'></i>
                  </a>
                <a class='btn btn-info' href='editProduct.php?id=<?php echo $Product['id']; ?>' style="cursor:pointer;">
                    <i class='icon-edit'></i>
                  </a>
                  <input type="hidden" name="status" id="status-<?php echo $Product['id']; ?>" value="<?php echo $Product['status']; ?>" />
                <a class='btn btn-danger' href='javascript:deletePart(<?php echo $Product['id']; ?>);' style="cursor:pointer;">
                    <i class='icon-trash'></i> </a>
									<!--	<a class='btn btn-success' href='sync.php?id=<?php //echo $Product['id']; ?>'>sync
									</a>-->
									  <a class='btn btn-success' href='javascript:syncPart(<?php echo $Product['id']; ?>);'>sync
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
#text1 {
    font-size: 16px;
    top: 12px;
    text-align: center;
    position: relative;
}

.bar1 {


    text-align: center;
    padding: 8px;
    padding-top: 0px;
    max-height: 100px;
    position: absolute;
    top: 71px;
    left: 80px;
    right: 0px;
    color: #f5f5f5;
    -webkit-box-shadow: 0px 2px 13px 0.5px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 13px 0.5px rgba(0, 0, 0, 0.3);
    display: none;
    z-index: 3008;
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

.loader {
    margin: 0 auto;
    margin-top: 15%;
    border: 16px solid #565656;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
#overlay {
    background-color: rgba(0, 0, 0, 0.8);
    z-index: 999;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    display: none;
}

</style>
<script>
$(function(){
    return $("#ok").on("click",function(){
      $("#barwrap").css("margin-bottom","0px");
      $(".bar").animate({height:"toggle"},"slow");
      return!1}
    )
  });
</script>


<script type="text/javascript">
    $(function () {
        $("#table1").hpaging({ "limit": 20 });
    });

    function focusRow(id){

        var text = $("#title-"+id).html()+"Added Sucessfully";
        $("#text").html(text);
        if(id != null && $("#title-"+id).html() != null){
          setTimeout(function(){
            return $(".bar").animate({height:"toggle"},"slow")
          },450);


          setTimeout(function() {   //calls click event after a certain time
             $("#ok").trigger('click');
          }, 6000);
        }
    }
    focusRow(<?php echo $_GET['focus']; ?>);

		$(document).ready(function () {
		  $('body').on('click', '#selectAll', function () {
		    if ($(this).hasClass('allChecked')) {
		        $('input[type="checkbox"]', '#table1').prop('checked', false);
		    } else {
		        $('input[type="checkbox"]', '#table1').prop('checked', true);
		    }
		    $(this).toggleClass('allChecked');
		  })
		});
    function sortList(year){
			window.location.replace("http://www.imspartsfinder.com/listProducts.php?model=<?php echo $_GET['model']; ?>&year="+year);

    }

		function sortmodelList(model){
          window.location.replace("http://www.imspartsfinder.com/listProducts.php?model="+model);
    }











</script>
<div id="overlay"></div>
</body>
</html>
