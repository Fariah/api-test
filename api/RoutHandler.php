<?php

namespace api;

/**
 * Class RoutHandler
 * @package api
 */
/**
 * Class RoutHandler
 * @package api
 */
class RoutHandler
{
    /**
     * @var
     */
    protected $request;
    /**
     * @var
     */
    protected $requestUri;
    /**
     * @var
     */
    protected $requestMethod;

    /**
     * RoutHandler constructor.
     */
    function __construct() {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        if(stripos($_SERVER['REQUEST_URI'], '?')) {
            $this->requestUri = substr($_SERVER['REQUEST_URI'], 0, stripos($_SERVER['REQUEST_URI'], '?'));
        } else {
            $this->requestUri = $_SERVER['REQUEST_URI'];
        }
    }

    /**
     * Array of routes and minded methods
     *
     * @return array
     */
    protected function getRoutes() {
        return [
            '/api/devices' => ['method' => 'post', 'controller' => 'Controllers\DevicesController:register']
        ];
    }

    /**
     * Method to parse routes
     *
     * @param $method
     * @param $type
     * @return string
     * @throws \Exception
     */
    protected function parseClassMethod($method, $type) {
        if(empty($method))
            throw new \Exception("Error in URL");
        $data = explode(':', $method);

        if($type == 'class')
            return __NAMESPACE__ . "\\" . $data[0];
        else
            return $data[1];
    }

    /**
     * Run method for requested route
     *
     * @throws \Exception
     */
    public function initRoutes() {
        $routes = $this->getRoutes();

        foreach ($routes as $route => $routeData) {
            if($route == $this->requestUri && (strtolower($this->requestMethod) == strtolower($routeData['method']))) {
                $class = $this->parseClassMethod($routeData['controller'], 'class');
                $method = $this->parseClassMethod($routeData['controller'], 'method');
                $classObj = new $class();
                $classObj->$method();
                die;
            }
        }
        throw new \Exception('Parse url error, no valid urls found for: ' . $this->requestUri);
    }
}