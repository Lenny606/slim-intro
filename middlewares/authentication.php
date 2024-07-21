<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as Response;

$authentication = function (Request $request, RequestHandler $handler){

    //saved in dtb, key is hashed string value
    $user = $request->getHeaderLine('X-API-User');
    $apiKey = $request->getHeaderLine('X-API-Key');

    if(!$user || !$apiKey) {
        return sendErrorResponse([
            "message" => "provide username and api key for authentication"
        ]);
    };
};