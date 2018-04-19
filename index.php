<?php

use api\ResponseHandler;
use api\RouteHandler;

require_once "SplClassLoader.php";

$app = new SplClassLoader('api');
$app->register();

$routHandler = new RouteHandler();

try {
    $routHandler->initRoutes();
} catch (PDOException $exception) {
    ResponseHandler::sendDBErrorResponse($exception);
} catch (Exception $exception) {
    ResponseHandler::sendErrorResponse($exception);
}