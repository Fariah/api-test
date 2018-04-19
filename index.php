<?php

use api\ResponseHandler;
use api\RoutHandler;

require_once "SplClassLoader.php";

$app = new SplClassLoader('api');
$app->register();

$routHandler = new RoutHandler();

try {
    $routHandler->initRoutes();
} catch (PDOException $exception) {
    ResponseHandler::sendDBErrorResponse($exception);
} catch (Exception $exception) {
    ResponseHandler::sendErrorResponse($exception);
}