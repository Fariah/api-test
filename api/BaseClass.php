<?php

namespace api;

/**
 * Class BaseClass
 * @package api
 */
class BaseClass
{

    public function __construct() {
        //connect to DB
    }

    /**
     * Return response
     *
     * @param $result
     */
    public function throwJson($result, $statusCode = 500) {
        http_response_code($statusCode);
        echo json_encode($result); die;
    }
}