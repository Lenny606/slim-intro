<?php
// namespaces 
use Psr\Http\Message\ResponseInterface as Response; //access to request / response
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory; //base aplication stuff 

require __DIR__ . '/../vendor/autoload.php';  //fetches from vendor folder any dependecies that we need automatically
require __DIR__ . '/../config/db.php'; //dtb
require __DIR__ . '/../routes/routes.php'; //

$app = AppFactory::create();  //new application, static create function

//routes go here between
$app->get('/', function (Request $request, Response $response, array $args) {
   // $name = $args['name'];
    $response->getBody()->write("Hello");
    return $response;
});



$app->run();