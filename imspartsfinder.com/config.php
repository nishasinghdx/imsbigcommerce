<?php
error_reporting(1);
ini_set('display_errors', 'On');
require_once 'vendor/autoload.php';
use Bigcommerce\Api\Client as Bigcommerce;

$access_token= 'hgt7u0ufhddz4papnejywvgg92vyzd1';
$store_hash='todwswzuz5';
$client_id= 'it2iy2isulq396459we26gy24w8jda5';
$object = Bigcommerce::configure(array(
    'client_id' => $client_id,
    'auth_token' => $access_token,
    'store_hash' => $store_hash
));

// MySQLi PDO
$servername = "mysql.imspartsfinder.com";
$username = "fdx_dev_ims";
$password = "sg@#SDujV3^3c";
$DB = "ims_parts";
try {
      global $PDO;
      $PDO = new PDO("mysql:host=$servername;dbname=$DB", $username, $password , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));    // set the PDO error mode to exception
      $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}



// Create connection
$conn = new mysqli($servername, $username, $password,$DB);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
