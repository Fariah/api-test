<?php

use api\RoutHandler;

require_once "SplClassLoader.php";

$app = new SplClassLoader('api');
$app->register();

$routHandler = new RoutHandler();

try {
    $routHandler->initRoutes();
} catch (Exception $exception) {
    $result = [
        'message' => $exception->getMessage(),
        'isError' => true,
        'detail' => $exception->getTrace()
    ];
    echo json_encode($result); die;
}