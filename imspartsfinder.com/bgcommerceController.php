<?php
include 'config.php';
use Bigcommerce\Api\Client as Bigcommerce;

class bigapi
{
    protected $PDO;

    public function __construct()
    {
        global $PDO;
        $this->PDO = $PDO;
    }



    /* Fetch all Products, Require permater limit of product fetch in one call*/
    public function Products($page,$limit)
    {
        $filter = array("page" => $page ,'limit' => $limit);
        return $products = Bigcommerce::getProducts($filter);
    }

	/* Fetch all Products, Require permater limit of product fetch in one call*/
    public function updatedProducts($page,$limit)
    {
        $filter = array("min_date_modified" => '2017-8-18' );
        return $products = Bigcommerce::getProducts($filter);
    }




    /* Fetch BC Product with Product Id */
    public function getProductData($ProductId)
    {
        return $products = Bigcommerce::getProduct($ProductId);
    }

    public function FetchSku($part)
    {

        $sql= 'SELECT  * FROM Products where sku = "'.$part.'" LIMIT  1 '/*LIMIT ".$limit*/;

        $stmt = $this->PDO->query($sql);
        $row = $stmt->fetchALl(PDO::FETCH_ASSOC);
        return $row;
        if(count($row)>0){
          return json_encode(array('status'=>'success','data'=> $row));
        }
        return json_encode(array('status'=>'fail','data'=> $_GET));
        //return $row;
    }


    /* Count total Products in BigCommerce*/
    public function ProductsCount()
    {
        return $count = Bigcommerce::getProductsCount();
    }

    /* Count total Products in Local App*/
    public function appProductsCount()
    {
        $sql= "SELECT count(*) as total FROM Products";
        $stmt = $this->PDO->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }


    /* Count total Products in Local App*/
    public function SyncProductPersentage()
    {
        $totalProductsinapp = bigapi::appProductsCount();
        $totalProductsinbig = bigapi::ProductsCount();
        $percent = ($totalProductsinapp * 100) / $totalProductsinbig;
        if (!empty($percent) && $percent >= 100) {
            $percent = 100;
        }
        return $percent;
    }


    /* Fetch Product custom fields, Require permater $productId*/
    public function ProductCustomFields($productId)
    {
        return $CustomFields = Bigcommerce::getProductCustomFields($productId);
    }



    /* Fetch all Models*/
    public function FetchModels()
    {
        $sql= "SELECT * FROM Model";
        $stmt = $this->PDO->query($sql);
        $row = $stmt->fetchALl(PDO::FETCH_ASSOC);
        return $row;
    }


    /* Fetch all Years of a particular model, $model perameter require */
    public function FetchYears($model)
    {
        $sql= "SELECT  * FROM Years where model_id = '".$model."' ORDER BY year_id DESC";
        $stmt = $this->PDO->query($sql);
        $row = $stmt->fetchALl(PDO::FETCH_ASSOC);
        return $row;
    }




    /* Fetch model name with ID */
    public function modelName($id)
    {
        $sql= "SELECT  name  FROM Model where model_id = '".$id."'";
        $stmt = $this->PDO->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }


    /* Fetch model name with ID */
    public function yearName($id)
    {
        $sql= "SELECT  name  FROM Years where year_id = '".$id."'";
        $stmt = $this->PDO->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }


    /* Fetch BC Product Name with Product Id */
    public function getProductName($ProductId)
    {
        $sql= "SELECT * FROM Products where product_id = $ProductId ";
        $stmt = $this->PDO->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    /* Fetch products  of a particular model and year, both $model,$year perameter require*/
    public function FetchFilterProducts($model, $year)
    {
        $sql= "SELECT  * FROM Products where model_id = '".$model."' and year_id = '".$year."'";
        $stmt = $this->PDO->query($sql);
        $row = $stmt->fetchALl(PDO::FETCH_ASSOC);
        return $row;
    }

    /* Fetch products  of a particular model and year, both $model,$year perameter require*/
    public function FetchAllFilterProducts()
    {
        $sql= "SELECT   * FROM Products";
        $stmt = $this->PDO->query($sql);
        $row = $stmt->fetchALl(PDO::FETCH_ASSOC);
        return $row;
    }







    /* Fetch Bundles*/
    public function FetchBundle($bundleId)
    {
        $sql= "SELECT  * FROM bundle_products where id = '".$bundleId."' ";
        $stmt = $this->PDO->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    /* Fetch Bundles*/
    public function FetchBundles($model, $year)
    {
      if($year == 'all'){
          $sql= "SELECT  * FROM bundle_products where model = '".$model."' ORDER BY `bundle_products`.`id` DESC";
      }else{
          $sql= "SELECT  * FROM bundle_products where model = '".$model."' AND year = '".$year."' ORDER BY `bundle_products`.`id` DESC";
      }

        $stmt = $this->PDO->query($sql);
        $rows = $stmt->fetchALl(PDO::FETCH_ASSOC);
        return $rows;
    }



    /* Insert Bundle Product in database, Form post data require*/
    public function InsertProducts($data = array())
    {
        extract($data);
        if (!empty($ProductName) && !empty($ProductModel) && !empty($ProductYear) && !empty($ProductImage)) {
            $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
            $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
            $Description = str_replace($search, $replace, $ProductDescription);
            $stmt =  "INSERT INTO bundle_products (title, image, description, model, year, bundle_product) VALUES ('".$ProductName."', '".$ProductImage."', '".$Description."', '".$ProductModel."', '".$ProductYear."' , '')";
            $result = $this->PDO->exec($stmt);
            $lastInsertproductId = $this->PDO->lastInsertId();

            if ($ActionType == "save") {
                return 'listProducts.php?focus='.$lastInsertproductId.'';
            } elseif ($ActionType == "saveandmap") {
                return "editProduct.php?id=".$lastInsertproductId;
            } else {
                return  "Something is Wrong!";
            }
        } else {
            return "Please Enter all Required Fields";
        }
    }



    /* Check Product is Exist or Not? */
    public function Checkproductexist($id)
    {
        $sql= "SELECT  * FROM Products where product_id = '".$id."' ";
        $stmt = $this->PDO->query($sql);
        $rows = $stmt->fetchALl(PDO::FETCH_ASSOC);
        return $rows;
    }

    /* Check Product is Exist or Not? */
    public function Checkskuexist($sku)
    {
        $sql= "SELECT  * FROM Products where sku = '".$sku."' ";
        $stmt = $this->PDO->query($sql);
        $rows = $stmt->fetchALl(PDO::FETCH_ASSOC);
        return $rows;
    }

    /* Check Model is Exist or Not? */
    public function Checkmodelexist($modelId)
    {
        $sql= "SELECT  model_id FROM Model where model_id = '".$modelId."' ";
        $stmt = $this->PDO->query($sql);
        $rows = $stmt->fetchALl(PDO::FETCH_ASSOC);
        return $rows;
    }


    /* Check Year is Exist or Not? */
    public function Checkyearexist($yearId)
    {
        $sql= "SELECT  year_id FROM Years where year_id = '".$yearId."' ";
        $stmt = $this->PDO->query($sql);
        $rows = $stmt->fetchALl(PDO::FETCH_ASSOC);
        return $rows;
    }

    /* Check Product is Updated on BC? */
    public function Checkproductupdated($id, $dateModified)
    {
        $sql= "SELECT  * FROM Products where product_id = '".$id."' ";
        $stmt = $this->PDO->query($sql);
        $rows = $stmt->fetchALl(PDO::FETCH_ASSOC);
        return $rows;
    }



    /* Insert Products in APP database tabel.*/
    public function syncProducts()
    {
        $totalProductsinapp = bigapi::appProductsCount();
        $totalProductsinbig = bigapi::ProductsCount();
        $diff = $totalProductsinbig - $totalProductsinapp;
        if ($diff <= 0) {
            $message = $totalProductsinapp.'-'.$totalProductsinbig;
        } else {
            $fetchproducts = bigapi::Products(200);
            foreach ($fetchproducts as $product) {
                $proexist =  bigapi::Checkproductexist($product->id);
                if (empty($proexist)) {
                    $productId = $product->id;
                    $productName = $product->name;
                    $productSKU = $product->sku;
                    $productDescription = $product->description;
                    $productPrice = $product->price;
                    $order_quantity_minimum = $product->order_quantity_minimum;
                    $productDateCreated = strtotime($product->date_created);
                    $productCategories = serialize($product->categories);
                    $productDateModified = strtotime($product->date_modified);
                    $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
                    $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
                    $productDescription = str_replace($search, $replace, $productDescription);

                  /* prepare and bind */
                  $stmt = "INSERT INTO Products (product_id, name, Categorie_ids, sku, description, price, date_created_bc, date_modified_bc, order_quantity_minimum) VALUES ($productId, '".$productName."', '".$productCategories."', '".$productSKU."', '".$productDescription."', $productPrice, $productDateCreated, $productDateModified, $order_quantity_minimum )";
                    $result = $this->PDO->exec($stmt);
                    $lastInsertproductId = $this->PDO->lastInsertId();

                  /* Save Custom fields data */
                  $CustomFields = Bigcommerce::getProductCustomFields($product->id);
                    $custom_array = array();
                    $model = '';
                    foreach ($CustomFields as $CustomField) {
                        if ($CustomField->name == 'Model' && $model != $CustomField->text) {
                            $model = $CustomField->text;
                        }
                        if ($CustomField->name == 'Year') {
                            $arr = array('Model' => $model, 'Year' => $CustomField->text);
                            $custom_array[$CustomField->product_id][] = $arr;
                        }
                    }

                    foreach ($custom_array[$CustomField->product_id] as $customArray) {
                        if (!empty($custom_array)) {
                            $customstat = "INSERT INTO bc_options (model, year, product_id, bc_product_id) VALUES ('".$customArray['Model']."', '".$customArray['Year']."', $lastInsertproductId, $product->id )";
                            $custresult = $this->PDO->exec($customstat);
                        }
                    }
                    $message = "Database has been up-to-date Sucessfully!";
                }
            }
        }
        return $message;
    }





    public function syncOptions()
    {    
        $options = Bigcommerce::getCollection('/option_sets');
        foreach ($options as $option) {
            $Id = $option->id;
            $Name = $option->name;
            try {

              $modelexist =  bigapi::Checkmodelexist($Id);
              if (empty($modelexist)) {
                  $stmt = "INSERT INTO Model (model_id, name) VALUES ($Id, '".$Name."')";
                  $result = $this->PDO->exec($stmt);
                  $lastInsertproductId = $this->PDO->lastInsertId();
                }

                $option_set = Bigcommerce::getCollection('/optionsets/'.$Id.'/options');
                foreach ($option_set as $set) {
                    foreach ($set->values as $values) {

                      $yearexist =  bigapi::Checkyearexist($values->option_value_id);
                      if (empty($yearexist)) {
                        try {
                            $stmt = "INSERT INTO Years (model_id , year_id, name) VALUES ($Id, $values->option_value_id , '".$values->value."')";
                            $result = $this->PDO->exec($stmt);
                        } catch (Exception $e) {
                            die("Oh noes! There's an error in the query! <br/>".$e);
                        }
                      }

                    }
                }
            } catch (Exception $e) {
                die("Oh noes! There's an error in the query! <br/>".$e);
            }
        }
    }
    /* Fetch Bundles*/
   public function FetchProducts($model,$year)
   {
       $sql= "SELECT  * FROM Products where year_id = '".$year."' and model_id = '".$model."' ORDER BY `Products`.`id` DESC";
       $stmt = $this->PDO->query($sql);
       $rows = $stmt->fetchALl(PDO::FETCH_ASSOC);
       return $rows;
   }

 public function updateBundal($data ,$pid){

    //$data = htmlentities($data);
    $sql =  "UPDATE bundle_products SET bundle_product = '$data' WHERE id= $pid";
    $result = $this->PDO->exec($sql);

 }



 /* Update Products in APP database tabel.*/
    public function syncModifiedProducts()
    {

		$fetchproducts = bigapi::updatedProducts($x,200);


	}





  /* Update Products in APP database tabel.*/
    public function syncUpdatedProductsss($mindate,$maxdate)
    {
        $filter = array("min_date_modified" => $mindate.'T00:01:10Z' ,'max_date_modified' => $maxdate.'T23:53:10Z');
      $products = Bigcommerce::getProducts($filter);
      foreach ($products as $product) {
          echo $productId = $product->id;
          echo "<br/>";
          $productglobalPrice = $product->price;
          $productDescription = $product->description;
          $order_quantity_minimum = $product->order_quantity_minimum;
          $productDateCreated = strtotime($product->date_created);
          $productCategories = serialize($product->categories);
          $productDateModified = strtotime($product->date_modified);
          $option_set_id = $product->option_set_id;
          if(!empty($option_set_id)){
          $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
          $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
          $productDescription = str_replace($search, $replace, $productDescription);
          $productName = str_replace($search, $replace, $product->name);
          $options = Bigcommerce::getCollection('/products/'.$productId.'/skus?limit=20');
          foreach ($options as $option) {
            if(isset($option->options[0])){
              $year = $option->options[0]->option_value_id;
            }else{
              $year = 0;
            }
              $productSKU = $option->sku;
              $productPrice = $option->price;
              if(empty($productPrice)){
                $productPrice = $productglobalPrice;
              }
              /* prepare and bind */
              $proexist =  bigapi::Checkskuexist($productSKU);
              if (empty($proexist)) {
          try {
                $stmt = "INSERT INTO Products (product_id,model_id,year_id, name, Categorie_ids, sku, description, price, date_created_bc, date_modified_bc, order_quantity_minimum) VALUES ($productId, $option_set_id, $year, '".$productName."', '".$productCategories."', '".$productSKU."', '".$productDescription."', $productPrice, $productDateCreated, $productDateModified, $order_quantity_minimum )";
                $result = $this->PDO->exec($stmt);
                echo $lastInsertproductId = $this->PDO->lastInsertId();
            } catch (Exception $e) {
                echo  $stmt;
                die("Oh noes! There's an error in the query! <br/>".$e);
            }
          }
        }
        }
      }
    }














  /* Update Products in APP database tabel.*/
    public function syncUpdatedProducts()
    {
      for($x=4; $x<=6; $x++){
        $fetchproducts = bigapi::Products($x,200);
        //print_r($fetchproducts);
        foreach ($fetchproducts as $product) {

            echo $productId = $product->id;
            echo "<br/>";
            $productglobalPrice = $product->price;
            $productDescription = $product->description;
            $order_quantity_minimum = $product->order_quantity_minimum;
            $productDateCreated = strtotime($product->date_created);
            $productCategories = serialize($product->categories);
            $productDateModified = strtotime($product->date_modified);
            $option_set_id = $product->option_set_id;
            if(!empty($option_set_id)){
            $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
            $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
            $productDescription = str_replace($search, $replace, $productDescription);
            $productName = str_replace($search, $replace, $product->name);
            $options = Bigcommerce::getCollection('/products/'.$productId.'/skus?limit=20');
            foreach ($options as $option) {
              if(isset($option->options[0])){
                $year = $option->options[0]->option_value_id;
              }else{
                $year = 0;
              }
                $productSKU = $option->sku;
                $productPrice = $option->price;
                if(empty($productPrice)){
                  $productPrice = $productglobalPrice;
                }
                /* prepare and bind */
                $proexist =  bigapi::Checkskuexist($productSKU);
                if (empty($proexist)) {
            try {
                  $stmt = "INSERT INTO Products (product_id,model_id,year_id, name, Categorie_ids, sku, description, price, date_created_bc, date_modified_bc, order_quantity_minimum) VALUES ($productId, $option_set_id, $year, '".$productName."', '".$productCategories."', '".$productSKU."', '".$productDescription."', $productPrice, $productDateCreated, $productDateModified, $order_quantity_minimum )";
                  $result = $this->PDO->exec($stmt);
                  echo $lastInsertproductId = $this->PDO->lastInsertId();
              } catch (Exception $e) {
                  echo  $stmt;
                  die("Oh noes! There's an error in the query! <br/>".$e);
              }
            }
          }
          }
        }
    }
  }
}
//$big = new bigapi ;
//echo $big->syncProducts();
