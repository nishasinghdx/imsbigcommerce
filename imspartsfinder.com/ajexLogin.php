<?php
session_start();
include 'config.php';
use Bigcommerce\Api\Client as Bigcommerce;

class ajexlogin
{
    protected $PDO;

    public function __construct()
    {
        global $PDO;
        $this->PDO = $PDO;
    }



    /* Fetch all Products, Require permater limit of product fetch in one call*/
    public function login($username,$password)
    {
      $sql= "SELECT id FROM users WHERE username='$username' and password='$password'";
      $stmt = $this->PDO->query($sql);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return $row['id'];
    }
}

$obj = new ajexlogin;

if(isset($_POST['username']) && isset($_POST['password']))
{



  $username= trim($_POST['username']);
  $password= trim($_POST['password']);

$uId = $obj->login(  $username , $password);




if(!empty($uId)){
  $_SESSION['login_user'] = $uId;
  echo $uId;exit;
}else{

  echo "Invalid";exit;
}

}else{

  echo "Not Authenticate!";

}



?>
