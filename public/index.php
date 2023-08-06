<?php
// namespaces 
use Psr\Http\Message\ResponseInterface as Response; //access to request / response
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory; //base aplication stuff 

require __DIR__ . '/../vendor/autoload.php';  //fetches from vendor folder any dependecies that we need automatically

$app = AppFactory::create();  //new application

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->run();