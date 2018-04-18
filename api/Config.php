<?php

namespace api;


use Exception;

/**
 * Class Config
 * @package api
 */
class Config
{
    public static $data = [
    ];

    public static function getProperty($name) {
        if(isset(self::$data[$name])) {
            return self::$data[$name];
        } else {
            throw new Exception('Error in Config file', 400);
        }
    }
}