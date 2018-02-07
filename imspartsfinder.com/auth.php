<?php
/**
 * User: Kamal Kunwar
 * Date: 12/8/16
 * Time: 9:29 PM
 */
$request = $_REQUEST;
require_once 'vendor/autoload.php';
use Bigcommerce\Api\Client as Bigcommerce;
use Bigcommerce\Api\Connection;
$tokenUrl = "https://login.bigcommerce.com/oauth2/token";
$connection = new Connection();
$connection->verifyPeer();
$response = $connection->post($tokenUrl, array(
    "client_id" => "6dd58cdn0i1655qlg7tblet7a9c3ll6", // App Client Id Ex. gtgt55fgtrgtrgtg7gtg56t655tg56t56t
    "client_secret" => "6pqgsi6oovo02v8vydb0wfxycs5u6iz", // App Client Secret Ex.qg5320wfs3wwisqsp0f0dtevolm3mh7
    "redirect_uri" => "http://localhost/bigcommerce/bigcpublicapp/auth.php", //This is the Auth Callback URL (Should Be Same as the App Auth Callback URL ) Ex.https://google.com/apps/auth.php
    "grant_type" => "authorization_code",
    "code" => $request["code"], //when I echo these variables out they work
    "scope" => $request["scope"],
    "context" => $request["context"],
));

//print_r($response);
	$access_token = $response->{'access_token'};
	$scope = $response->{'scope'};
	$id =  $response->{'user'}->{'id'};
	$email =  $response->{'user'}->{'email'};
	$context = $response->{'context'};
	$hasu_explode =( explode( '/', $context ) );
	$store_hash = $hasu_explode[1];
	$client_id='6dd58cdn0i1655qlg7tblet7a9c3ll6';
?>

<table class="table table-bordered table-hover table-striped" style="table-layout: fixed" border="1">
		 <thead>
			 <tr>
			    <th>Client Id</th>
				<th>Username</th>
				<th>Access Token</th>
				<th>Scope</th>
				<th>Context</th>
			 </tr>
		 </thead>
		 <tbody>
		 <tr>
		 <td id="datass"><?php echo $id ?></td>
		 <td><?php echo $email;  ?></td>
		 <td><?php echo $access_token;  ?></td>
		 <td><?php echo $scope;  ?></td>
		 <td><?php echo $context; ?></td>
	</tr>
	</tbody>
</table>
		 <?php
print_r($connection->getLastError());
?>
<p><a href="get_product.php?token=<?php echo $access_token ?>&store_hash=<?php echo $store_hash ?>&client_id=<?php echo $client_id ?>"><h4>View Products</h4></a></p>
