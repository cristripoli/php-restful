<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim();

$app->get('/', function() {
	echo "Welcome to Guest API";	
});

$app->get('/guests', function() use ($app) {
	$guests = array(
			array('id' => 1, 'name' => 'Edy Segura', 'email' => 'edysegura@gmail.com'),
			array('id' => 2, 'name' => 'Crislaine Tripoli', 'email' => 'rll@gmail.com')
		);

	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($guests);
	
});

$app->post('/guest', function() use ($app) {

	$guest = json_decode($app->request->getBody(), true);
	$guest['id'] = 10;
	$app->response->header('Content-Type', 'application/json');
	echo json_encode($guest);
});
$app->run();
?>