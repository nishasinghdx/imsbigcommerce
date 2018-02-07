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
    <title>Forms</title>
    <meta content='lab2023' name='author'>
    <meta content='' name='description'>
    <meta content='' name='keywords'>
    <link href="assets/stylesheets/application-a07755f5.css" rel="stylesheet" type="text/css" /><link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/images/favicon.ico" rel="icon" type="image/ico" />
    <!-- Load local jQuery.  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    <script type="text/javascript" src="resourses/ajaxupload.3.5.js" ></script>
    <?php
    include 'bgcommerceController.php';
    $res = new bigapi;
    $models = $res->FetchModels();
    if(isset($_POST) && !empty($_POST['ProductName'])){
      $productData = $res->InsertProducts($_POST);
      if (strpos($productData, '.php') !== false) {
        ?>
        <script>
          window.location.replace("<?php echo $productData; ?>");
        </script>
        <?php
      }else{
         echo 'false';
      }
    }
    ?>
    <script type="text/javascript" >
      $(function(){
        var btnUpload=$('#upload');
        var status=$('#status');
        new AjaxUpload(btnUpload, {
          action: 'request.php',
          name: 'uploadfile',
          onSubmit: function(file, ext){

            status.text('Uploading...');
          },
          onComplete: function(file, response){
            //On completion clear the status
            status.text('');
            //Add uploaded file to list
            if(response != "error"){
              $('#ProductImage').val(response);
              $('<li></li>').appendTo('#files').html('<img src="./resourses/Images/'+response+'" alt="" style="max-width:100px;" /><br />'+file).addClass('success');
            } else{
              $('<li></li>').appendTo('#files').text(file).addClass('error');
            }
          }
        });

      });
    </script>
    <script>
    function changedrop(type,mod) {
    	var model = mod.value;
    	$.ajax({
    		url: 'request.php',
    		type: 'GET',
    		data: 'type='+type+'&model='+model+'',
    		success: function(data) {
    			if(data === '' || data === null){
    				$('#yeardropdown').app('<option>Select Year</option>');
    			}else{
    				$('#yeardropdown').html(data);
    			}
    		},
    		error: function(e) {
    				alert(e.message);
    		}
    	});
    }
    </script>

<style>

.error{

      color: #d9534f;
      font-style: italic;
      font-weight: 600;
      font-family: cursive;

}

#modeldropdown-error{  display: none!important;  }
#yeardropdown-error{  display: none!important;  }
#ProductImage-error{  display: none!important;  }

</style>








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
  <!-- Sidebar -->
      <section id='sidebar'>
        <i class='icon-align-justify icon-large' id='toggle'></i>
        <ul id='dock'>
          <li class=' launcher'>
            <i class='icon-dashboard'></i>
            <a href="dashboard.php">Dashboard</a>
          </li>
          <li class='active launcher'>
            <i class='icon-file-text-alt'></i>
            <a href="addproducts.php">Add Parts</a>
          </li>
          <li class='launcher '>
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
          <li><a href="#">Add Parts</a></li>

        </ul>
        <div id='toolbar'>

        </div>
      </section>
      <!-- Content -->
      <div id='content'>

        <div class='panel panel-default'>
          <div class='panel-heading'>
            <i class='icon-edit icon-large'></i>
            Add Parts
          </div>
          <div class='panel-body'>
            <form class='form-horizontal' action="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data" id="myform">
              <fieldset>

                <div class='form-group'>
                  <label class='col-lg-2 control-label'>Title</label>
                  <div class='col-lg-10'>
                    <input class='form-control' placeholder='Enter Title' type='text' name="ProductName">
                  </div>
                </div>
                <div class='form-group'>
                  <label class='col-lg-2 control-label'>Model</label>
                  <div class='col-lg-10'>
                    <select type="text" id="modeldropdown" class="form-control" placeholder="" onchange="changedrop('getYear', this);" name="ProductModel">
          						<option value="">Select Model</option>
                      <?php foreach ($models as $model) {       ?>
                        <option value="<?php  echo $model['model_id']; ?>"><?php  echo $model['name']; ?></option>
                        <?php } ?>
                    </select>
                  </div>
                </div>
                <div class='form-group'>
                  <label class='col-lg-2 control-label'>Year</label>
                  <div class='col-lg-10'>
                    <select type="text" id="yeardropdown" class="form-control" placeholder="Select Year" name="ProductYear" >
          						<option value="">Select Year</option>
          					</select>
                  </div>
                </div>
                <div class='form-group'>
                  <label class='col-lg-2 control-label'>Diagram</label>
                  <div class='col-lg-10'>
                    		<!-- Upload Button, use any id you wish-->
                    		<div id="upload" ><img src="resourses/Images/uapload.png"/></div><span id="status" ></span>
                        <ul id="files"  ></ul>
                        <input type="hidden" name="ProductImage" value="" id="ProductImage" />
                  </div>
                </div>
                <div class='form-group'>
                  <label class='col-lg-2 control-label'>Description</label>
                  <div class='col-lg-10'>
                    <textarea class='form-control' placeholder='Enter Description' type='text' name="ProductDescription"></textarea>
                  </div>
                </div>

              </fieldset>
              <div class='form-actions'>
              <button class='btn btn-default' type='submit' name = "ActionType" value="save">Save</button>
              <button class='btn btn-default' type='submit' name = "ActionType" value="saveandmap" >Save and Map Product</button>
              </div>
            </form>
          </div>
        </div>


        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
        <script>


        $( "#myform" ).validate({
          rules: {
            ProductName: {
              required: true,
            },
            ProductModel: {
              required: true,
            },
            ProductYear: {
              required: true,
            },
            ProductImage: {
              required: true,
            },
            ProductDescription: {
              required: true,
            }
          },messages: {
            ProductModel: {
                required: ''
            },ProductYear: {
                required: ''
            },ProductImage: {
                required: ''
            },ProductName: {
                required: 'Title is required!'
            },ProductDescription: {
                required: 'Title is required!'
            }
        }
        });
        </script>
