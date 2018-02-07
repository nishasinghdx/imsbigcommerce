
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
    $fetchProducts = $res->FetchAllFilterProducts();

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
    <!-- Load local jQuery.  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="resourses/hierarchy-select.min.js"></script>
  <link rel="stylesheet" href="resourses/jquery-nicemodal.css">
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="resourses/jquery-nicemodal.js"></script>

  <link href="resourses/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
  <script src="resourses/jquery.contextMenu.js" type="text/javascript"></script>

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
          <li class='launcher'>
            <i class='icon-dashboard'></i>
            <a href="index.php">Dashboard</a>
          </li>
          <li class='active launcher'>
            <i class='icon-table'></i>
            <a href="listProducts.php">View Plans</a>
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

        </div>
      </section>
      <!-- Content -->
      <div id='content'>











          <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
        	<form action='' method='post'>
        		<p><label>Country:</label><input type='text' name='country' id="product" value='' class='auto'></p>
            <br/>
                <button type="button" onclick="getvalue()">Submit</button>
        	</form>

        
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
        <script type="text/javascript">
        $(function() {
        	//autocomplete
        	$(".auto").autocomplete({
        		source: "search.php",
        		minLength: 1
        	});
        });

          function getvalue(){

            var product = $("#product").val();
            var arr = product.split('|');
            var sku = $.trim(arr[0]);
            var name = $.trim(arr[1]);
            var price = $.trim(arr[2]);
            var productId = $.trim(arr[3]);
            alert(productId);
          }

        </script>






























        </div>
      </div>






  </body>
</html>
