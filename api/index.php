<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim();

$app->get('/', function() {
	echo "Welcome to Guest API";	
});

$app->get('/guests', function() use ($app) {

	$db = getDB();
	$guests = array();
	foreach($db->guests() as $guest) {
		$guests[] = array(
			'id' => $guest['id'],
			'name' => $guest['name'],
			'email' => $guest['email']
		);
	}
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($guests);
	
});

$app->post('/guest', function() use ($app) {
	$db = getDB();
	$guestToAdd = json_decode($app->request->getBody(), true);
	$guest = $db->guests->insert($guestToAdd);
	
	$app->response->header('Content-Type', 'application/json');
	echo json_encode($guest);
});

$app->delete('/guest/:id', function($id) use ( $app ) { 
	$db = getDB();
	$response = "";
	
	$guest = $db->guests()->where('id', $id);
	
	if($guest->fetch()){
		$result = $guest->delete();
		$response = array(
			'status' => 'true',
			'message' => 'Guest deleted!'
		);
	}
	else{
		$response = array(
			'status' => 'false',
			'message' => 'Guest with $id does not exists.'
		);
		$app->response->setStatus(404);
	}
	$app ->response()->header('Content-Type', 'application/json');
	echo json_encode($response);
});

function getConnection() {
	$dbhost = getenv('IP');
	$dbuser = getenv('C9_USER');
	$dbpass = '';
	$dbname = 'c9';
	$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	return $pdo;
}

function getDB() {
	$pdo = getConnection();
	$db = new NotORM($pdo);
	return $db;
}
$app->run();
?>