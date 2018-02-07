<?php
include 'bgcommerceController.php';
$requestClass = new bigapi;
$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
$model = filter_input(INPUT_GET, 'model', FILTER_SANITIZE_SPECIAL_CHARS);
$year = filter_input(INPUT_GET, 'year', FILTER_SANITIZE_SPECIAL_CHARS);
$bundleId = filter_input(INPUT_POST, 'bundleId', FILTER_SANITIZE_SPECIAL_CHARS);
$bundle = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
$bundleData = $_POST['bundleData'];
$uploadfile = $_FILES['uploadfile'];



/*  Delete Part from DB   */
if (!empty($uploadfile)) {
    $uploaddir = './resourses/Images/';
    $filename = time().'-'.basename($_FILES['uploadfile']['name']);
    $uploadfile = $uploaddir.$filename;
  if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploadfile)) {
    echo $filename;
  } else {
  	echo "error";
  }
  exit;
}


/*  Delete Part from DB   */
if ($bundle == 'deletePart') {
  $stmt = "Delete from bundle_products WHERE id=$bundleId";
  $result = $PDO->exec($stmt);
  echo "Delete Sucessfully!";
  exit;
}


/*  show hide Part from DB   */
if ($bundle == 'showhidePart') {
   $stmt = "UPDATE bundle_products SET status = '".$status."' WHERE id=$bundleId";
   $result = $PDO->exec($stmt);
   echo "Update Sucessfully!";
   exit;
}



/*  Save Bundle Data   */
if ($bundle == 'BundleData' && !empty($bundleId)) {
  $stmt = "UPDATE bundle_products SET bundle_product = '".$bundleData."' WHERE id=$bundleId";
  $result = $PDO->exec($stmt);
  echo "Update Sucessfully!";
  exit;
}

/*  Fetch year with Model   */
if ($type == 'getModel') {
}

/*  Fetch year with Model   */
if ($type == 'getYear' && !empty($model)) {
    $years = $requestClass->FetchYears($model);
    if (!empty($years)) {
        $data .= '<option value="Select Model">Select Year</option>';
        foreach ($years as $year) {
            $data .= '<option value="'.$year['year_id'].'">'.$year['name'].'</option>';
        }
    }
    echo  $data;
    exit;
}

/*  Fetch Products with Model and year   */
if ($type == 'getProducts' && !empty($model) && !empty($year)) {
    $filterProducts = $requestClass->FetchFilterProducts($model, $year);
    if (!empty($filterProducts)) {
        $data .= '<option value="Select Model">Select Year</option>';
        foreach ($filterProducts as $Products) {
            $productName = $requestClass->getProductName($Products['bc_product_id']);
            $data .= '<option value="'.$Products['bc_product_id'].'">'.$productName.'</option>';
        }
    }
    echo  $data;
    exit;
}
?>
