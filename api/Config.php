<?php

namespace api;


use Exception;

/**
 * Class Config
 * @package api
 */
class Config
{
    //TODO it would be better to create env. file to store it, but it takes some time
    /**
     * Properties
     *
     * @var array
     */
    public static $data = [
        'db_host' => 'localhost',
        'db_name' => 'api-test',
        'db_user' => 'root',
        'db_password' => '123',
        'bearer' => 'Qwerty321' //TODO I need more information about application to make this correct
    ];

    /**
     * Get property from config
     *
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public static function getProperty($name) {
        if(!isset(self::$data[$name])) {
            throw new Exception('Error in Config file', 500);
        }
        return self::$data[$name];
    }
}