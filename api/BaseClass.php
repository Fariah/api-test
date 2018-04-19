<?php

namespace api;
use PDO;

/**
 * Class BaseClass
 * @package api
 */
class BaseClass
{
    /**
     * @var PDO
     */
    public $db;

    /**
     * BaseClass constructor.
     * @throws \Exception
     */
    public function __construct() {
        $host = Config::getProperty('db_host');
        $username = Config::getProperty('db_user');
        $password = Config::getProperty('db_password');
        $dbName = Config::getProperty('db_name');

        $this->db = new PDO('mysql:host=' . $host . ';dbname=' . $dbName, $username, $password);
    }

    /**
     * Get header Authorization
     * */
    public function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    /**
     * Get access token from header
     *
     * @return mixed|null
     */
    public function getBearerToken() {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    /**
     * Check Bearer token
     *
     * @param $token
     * @return bool
     * @throws \Exception
     */
    public function checkBearerToken($token)
    {
        return Config::getProperty('bearer') == $token; // TODO very simple auth check
    }
}