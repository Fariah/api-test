<?php

namespace api;


use stdClass;

/**
 * Class ResponseHandler
 * @package api
 */
class ResponseHandler
{
    /**
     * Success status
     *
     * @var string
     */
    private static $status_201 = '201';

    /**
     * Validation error status
     *
     * @var string
     */
    private static $status_400 = '400';

    /**
     * Auth error status
     *
     * @var string
     */
    private static $status_401 = '401';

    /**
     * Server error status
     *
     * @var string
     */
    private static $status_500 = '500';

    /**
     * Send server error response with PDO json format
     *
     * @param \PDOException $exception
     */
    public static function sendDBErrorResponse(\PDOException $exception)
    {
        $result = [
            'message' => 'DB Error',
            'isError' => true,
            'detail' => $exception->getMessage() //TODO do wee need detail info for DB errors, security issue?
        ];

        self::sendResponse($result, self::$status_500);
    }

    /**
     * Send server error response with default json format
     *
     * @param \Exception $exception
     */
    public static function sendErrorResponse(\Exception $exception)
    {
        $result = [
            'message' => 'Internal error',
            'isError' => true,
            'detail' => $exception->getMessage()
        ];

        self::sendResponse($result, self::$status_500);
    }

    /**
     * Send auth error response with default json format
     */
    public static function sendAuthErrorResponse()
    {
        self::sendResponse([], self::$status_401);
    }

    /**
     * Send validation error response with default json format
     *
     * @param array $validationData
     */
    public static function sendValidationErrorResponse(Array $validationData)
    {
        self::sendResponse($validationData, self::$status_400);
    }

    /**
     * Send success response with default json format
     *
     * @param stdClass $device
     */
    public static function sendSuccessResponse(StdClass $device)
    {
        $responseData = [
            'token' => $device->token,
            'deviceType' => $device->deviceType
        ];
        self::sendResponse($responseData, self::$status_201);
    }

    /**
     * Send response
     *
     * @param array $result
     * @param int $statusCode
     */
    private static function sendResponse(Array $result, $statusCode)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($result);
        die;
    }
}