<?php
include 'bgcommerceController.php';
$res = new bigapi;
$productid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$productids = $_POST['info'];

if(isset($productids)){
  foreach($productids as $value){
    {
      $Product = $res->FetchBundle($value);
      $strhtml = $Product['bundle_product'];

      $dochtml = new DOMDocument();
      $dochtml->loadHTML($strhtml);
      // gets all DIVs
      $divs = $dochtml->getElementsByTagName('div');

      // traverse the object with all DIVs
      foreach($divs as $div) {
        // if the current $div has ID attribute, gets and outputs the ID and content
        $sku = $div->getAttribute('sku');
        if($div->hasAttribute('model')) {
        $id = $div->getAttribute('model');
      	$productname = $div->getAttribute('productname');
      	$price = $div->getAttribute('price');
        $Product1 = $res->FetchSku($sku);
        $div->setAttribute('price', $Product1[0]['price']);
        $div->setAttribute('qty', $Product1[0]['order_quantity_minimum']);
        $div->setAttribute('productname', $Product1[0]['name']);
        }
      }
      $data = $dochtml->saveHTML();
      $res->updateBundal($data, $value);
    }
  }
  print_r("updated-sucesss");
  exit;
}
if (!empty($productid)) {
    $Product = $res->FetchBundle($productid);
}
$strhtml = $Product['bundle_product'];

$dochtml = new DOMDocument();
$dochtml->loadHTML($strhtml);
// gets all DIVs
$divs = $dochtml->getElementsByTagName('div');

// traverse the object with all DIVs
foreach($divs as $div) {
  // if the current $div has ID attribute, gets and outputs the ID and content
  $sku = $div->getAttribute('sku');
  if($div->hasAttribute('model')) {
  $id = $div->getAttribute('model');
	$productname = $div->getAttribute('productname');
	$price = $div->getAttribute('price');
  $Product1 = $res->FetchSku($sku);
  $div->setAttribute('price', $Product1[0]['price']);
  $div->setAttribute('qty', $Product1[0]['order_quantity_minimum']);
  $div->setAttribute('productname', $Product1[0]['name']);
  }
}
$data = $dochtml->saveHTML();
$res->updateBundal($data, $productid);
