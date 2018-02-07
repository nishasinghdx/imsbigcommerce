<?php
session_start();
if($_SESSION['login_user'] < 1){
	header("Location: index.php");
}
?>
<!DOCTYPE html>
<html class='no-js' lang='en'>
  <head>
    <?php
    include 'bgcommerceController.php';
    $res = new bigapi;
    $productid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
    if (!empty($productid)) {
        $Product = $res->FetchBundle($productid);
    }
    $model = $Product['model'];
    $year = $Product['year'];
    $Productname = $Product['name'];
    $fetchProducts = $res->FetchFilterProducts($model,$year);

    ?>
    <meta charset='utf-8'>
    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
    <title>Forms</title>
    <meta content='lab2023' name='author'>
    <meta content='' name='description'>
    <meta content='' name='keywords'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="resourses/hierarchy-select.min.css">
    <link href="assets/stylesheets/application-a07755f5.css" rel="stylesheet" type="text/css" /><link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/images/favicon.ico" rel="icon" type="image/ico" />
		<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
    <!-- Load local jQuery.  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
    <script src="resourses/hierarchy-select.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
    $('#example-one').hierarchySelect({
    width: 500
    });

    });
    </script>
    <!-- Load local lib and tests. -->
    <script src="resourses/jquery.pep.js"></script>
    <script type="text/javascript">
      function addbox(type) {
        var randomId = Date.now();
        if(type == 'addbox'){
          $('#dsx').prepend('<div id="' + randomId + '" class="pep context-menu-one btn btn-neutral" style="width: 25px; height: 25px; border: 1px solid #000; z-index: 10;"></div>');
        }
        var boxwidth = $( "#dsx-box" ).width();
        var someper = 13*boxwidth / 100;
        var total =  boxwidth - 250 ;



        $("#"+randomId).css( "top", "-100px" );
        $("#"+randomId).css( "left", total+"px" );
        $("#"+randomId).css( "position", "fixed" );


          $("#"+randomId).animate( {
            top: 200
          }, 1000, function() {

          $("#"+randomId).animate( {
            left: 50
          }, 1000, function() {
          });
          });


        $(document).ready(function() {

          $('.pep').pep({
            droppable: '.droppable',
            overlapFunction: false,
            useCSSTranslation: false,
            start: function(ev, obj) {
              obj.noCenter = false;
            },
            drag: function(ev, obj) {
              var vel = obj.velocity();
              var rot = (vel.x) / 5;
              rotate(obj.$el, rot);
            },
            stop: function(ev, obj) {
              rotate(obj.$el, 0);
            },
            rest: handleCentering
          });

          function handleCentering(ev, obj) {
            console.log(obj.activeDropRegions.length);
            if (obj.activeDropRegions.length > 0) {
              centerWithin(obj);
            }
          }

          function centerWithin(obj) {
            var $parent = obj.activeDropRegions[0];
            var pTop = $parent.position().top;
            var pLeft = $parent.position().left;
            var pHeight = $parent.outerHeight();
            var pWidth = $parent.outerWidth();

            var oTop = obj.$el.position().top;
            var oLeft = obj.$el.position().left;
            var oHeight = obj.$el.outerHeight();
            var oWidth = obj.$el.outerWidth();

            var cTop = pTop + (pHeight / 2);
            var cLeft = pLeft + (pWidth / 2);

            if (!obj.noCenter) {
              if (!obj.shouldUseCSSTranslation()) {
                var moveTop = cTop - (oHeight / 2);
                var moveLeft = cLeft - (oWidth / 2);
                obj.$el.animate({
                  top: moveTop,
                  left: moveLeft
                }, 50);
              } else {
                var moveTop = (cTop - oTop) - oHeight / 2;
                var moveLeft = (cLeft - oLeft) - oWidth / 2;
                obj.moveToUsingTransforms(moveTop, moveLeft);
              }

              obj.noCenter = true;
              return;
            }

            obj.noCenter = false;
          }

          function rotate($obj, deg) {
            $obj.css({
              "-webkit-transform": "rotate(" + deg + "deg)",
              "-moz-transform": "rotate(" + deg + "deg)",
              "-ms-transform": "rotate(" + deg + "deg)",
              "-o-transform": "rotate(" + deg + "deg)",
              "transform": "rotate(" + deg + "deg)"
            });
          }

        });

      }

      addbox('editload');
      $("#dsx").click(function(e) {
        alert(e);
      });
    </script>
    <style type="text/css">
      .pep-dpa {
        border-color: blue;
        background: yellow
      }

      .mappedProduct {
        background-color: #feda5d;
        opacity: .5;
      }
    </style>

		<script type="text/javascript">
		$(function() {
		//autocomplete
		$(".auto").autocomplete({
			source: "search.php",
			minLength: 1
		});
		});



		</script>










  <link rel="stylesheet" href="resourses/jquery-nicemodal.css">
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="resourses/jquery-nicemodal.js"></script>

  <link href="resourses/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
  <script src="resourses/jquery.contextMenu.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(function() {
      $.contextMenu({
        selector: '.context-menu-one',
        callback: function(key, options) {

          var $this = $(this);
          var contextId = $this.context.id;
          var m = "clicked: " + key;
          if (key == 'add') {
            addProduct();
          }
          if (key == 'change') {
            changeProduct(contextId);
          }
          if (key == 'delete') {
            deleteProduct(contextId);
          }
          if (key == 'reset') {
            resetProduct(contextId);
          }
          $("#mapobject").val(contextId);
        },
        items: {
          "add": {
            name: "Add Product",
            icon: "add",
            accesskey: "e"
          },
          "change": {
            name: "Change Product",
            icon: "edit",
            accesskey: "c"
          },
          "reset": {
            name: "Reset",
            icon: "delete"
          },  "delete": {
              name: "Delete",
              icon: "delete"
            },
          "sep1": "---------",
          "quit": {
            name: "Quit",
            icon: function($element, key, item) {
              return 'context-menu-icon context-menu-icon-quit';
            }
          }
        }
      });
    });



   function addProduct() { $(".demo").trigger("click"); }
   function deleteProduct(id) {
      var allreadyskus = $('#skus').val();
      var sku = $("#"+id).attr("sku");
      if (allreadyskus.indexOf(sku) >= 0){
        allreadyskus = allreadyskus.replace(sku, "");
        // can then use it as
          $('#skus').val(allreadyskus);
      }
      allreadyskus.replace(sku, "fd");
      $('#skus').val(allreadyskus);
     $( "#"+id ).remove();
    }
   function resetProduct(id) {
     $("#"+id).attr("model", "");
     $("#"+id).attr("productId", "");
     $("#"+id).attr("year", "");
     $("#"+id).removeClass("mappedProduct");
    }

   function changeProduct(id) {
     var sku = $("#" + id).attr("sku");
     $(".hs-searchbox input").val(sku);
     $(".demo").trigger("click");
   }

    function mapProduct() {
      var mapobject = $("#mapobject").val();
      var model = '<?php echo $model; ?>';
      var year = '<?php echo $year; ?>';
      var partno = $('#partno').val();
			if(partno < 1){    alert("Please Select Part No!"); return false;      }
			var product = $("#product-auto").val();
			var arr = product.split('|');
			var sku = $.trim(arr[0]);
			var name = $.trim(arr[1]);
			var price = $.trim(arr[2]);
			price = price.substr(1);
			var pid = $.trim(arr[3]);
      var qty = $.trim(arr[4]);

      $("#" + mapobject).attr("model", model);
      $("#" + mapobject).addClass("mappedProduct");
      $("#" + mapobject).attr("year", year);
      $("#" + mapobject).attr("partno", partno);
      $("#" + mapobject).attr("productId", pid);
      $("#" + mapobject).attr("price", price);
      $("#" + mapobject).attr("productName", name);
      $("#" + mapobject).attr("sku", sku);
      $("#" + mapobject).attr("qty", qty);
      $('#myModal').modal('hide');
      $('#partno').val('');

      /* Add Sku's in Json */
      var allreadyskus = $('#skus').val();
      if( allreadyskus.length !== 0 ) {
          $('#skus').val(allreadyskus+','+sku);
      }else{
        $('#skus').val(sku);
      }
    }

    function SaveBundle() {
      var bundleData = $("#main").html();
      var type = 'BundleData';
			var bundleId = <?php echo $productid;  ?>;
      $.ajax({
        url: 'request.php',
        type: 'POST',
        data: {bundleData:bundleData,type:type,bundleId:bundleId},
        success: function(data) {
          alert(data);
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
  <div class='navbar navbar-default' id='navbar' style="background:none;border:none;">
    <a class='navbar-brand' href='#' style="color: #2c3e50;">
        <i class='icon-globe'></i>
        International Marine
      </a>
  </div>
    <div id='wrapper'>

        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-info btn-lg demo " data-toggle="modal" data-target="#myModal" style="display:none;">Open Modal</button>


      <!-- Sidebar -->
      <section id='sidebar'>
        <i class='icon-align-justify icon-large' id='toggle'></i>
        <ul id='dock'>
          <li class=' launcher'>
            <i class='icon-dashboard'></i>
            <a href="dashboard.php">Dashboard</a>
          </li>
          <li class='launcher'>
            <i class='icon-file-text-alt'></i>
            <a href="addproducts.php">Add Parts</a>
          </li>
          <li class='launcher active'>
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
          <li class='title'>Products</li>
          <li><a href="editProduct.php">Edit Plan</a></li>
          <li><?php echo $Product['title']; ?></li>
        </ul>
        <div id='toolbar'>

          <?php if (!empty($Product)) {       ?>
            <div class="btn-group">
              <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees" onclick="addbox('addbox');">ADD BOX</button>
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees" onclick="SaveBundle();">SAVE</button>
              <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45">SAVE AND EXIT</button>
            </div>
          <?php }  ?>
        </div>
      </section>
      <!-- Content -->
      <div id='content'>
              <div class="modal-content" id="dsx-box">

                        <div class="modal-body">
                            <div class="avatar-body">
                              <!-- Upload image and data -->
                              <div class="avatar-upload" style="box-shadow: inset 0 0 5px rgba(0,0,0,.25); background-color: #fcfcfc; overflow: hidden;height: 1300px;width: 100%;">
                                  <div id="main">
                                    <?php if (empty($Product['bundle_product'])) {    ?>
                                      <div id="dsx" style="width:100%;height:100%;">
                                        <img id="ariparts_image" src="resourses/Images/<?php echo $Product['image']; ?>"  style="position: absolute; display: block; margin: 10px;" class="ariImage" zoomlevel="2" />
                                      </div>
                                      <?php    } else {    ?>
                                        <?php echo $Product['bundle_product']; ?>
                                      <?php } ?>
                                  </div>
                                  <input type="hidden" id="skus" value="" style="position:absolute;width:100%;" />
                                </div>
                              </div>
                              <br/>
                            </div>
            <input type="hidden" name="mapobject"   id="mapobject"/>
           </div>
        </div>
      </div>

      <!-- Modal -->
      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
              <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

              						<div class="btn-group hierarchy-select" data-resize="auto" id="example-one">


              								<div class="">
              								<input type='text' name='country' id="product-auto" value='' class='auto'>
              								</div>
              								<input class="hidden hidden-field" name="example_one" readonly="readonly" aria-hidden="true" type="text" id="productdropdown" placeholder="SKU | Name | Price | Product Id | QTY"/>


                              <div class="form-group">
                              <div class="col-lg-12" style="margin: 0;    margin-top: 20px;    padding: 0;">
                              <select  name="partno" id="partno" class="form-control" placeholder="Select Year" name="ProductYear" style="border:1px solid #00bca4!important">
                                <option value="">Select Part No</option>
                                <?php for($i = 1; $i<= 99; $i++) {  ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                              </select>
                              </div>
                              </div>


              						</div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-block" onclick="mapProduct();">Map Product</button>

            </div>
          </div>

        </div>
      </div>
  </body>
</html>






<?php

// create the DOMDocument object, and load HTML from string


$strhtml = $Product['bundle_product'];

$dochtml = new DOMDocument();
$dochtml->loadHTML($strhtml);
// gets all DIVs
$divs = $dochtml->getElementsByTagName('div');

// traverse the object with all DIVs
foreach($divs as $div) {
  // if the current $div has ID attribute, gets and outputs the ID and content
  if($div->hasAttribute('model')) {
  $id = $div->getAttribute('model');
	$productname = $div->getAttribute('productname');
	$price = $div->getAttribute('price');
	$div->setAttribute('price', '10');

  }
}
$dochtml->saveHTML();










?>
