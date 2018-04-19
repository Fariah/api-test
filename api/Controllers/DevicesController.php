<?php

namespace api\Controllers;


use api\BaseClass;
use api\ResponseHandler;
use api\Validators\DeviceRegisterValidation;

/**
 * Class DevicesController
 * @package api
 */
class DevicesController extends BaseClass
{
    /**
     * DevicesController constructor.
     */
    public function __construct()
    {
        $bearerToken = $this->getBearerToken();

        if(!$this->checkBearerToken($bearerToken)) {
            ResponseHandler::sendAuthErrorResponse();
        }

        parent::__construct();
    }

    /**
     * Register new device in DB
     */
    public function register()
    {
        $request = json_decode(file_get_contents('php://input'),false);

        $validator = new DeviceRegisterValidation();
        $messages = $validator->validate($request);

        if($messages) {
            ResponseHandler::sendValidationErrorResponse($messages);
        }

        $token = $request->deviceTokenViewModel->token;
        $deviceType = $request->deviceTokenViewModel->deviceType;

        $stmt = $this->db->prepare("INSERT INTO device_tokens (token, deviceType) VALUES (:token, :deviceType)");

        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':deviceType', $deviceType);

        $stmt->execute();

        $responseData = [
            'token' => $token,
            'deviceType' => $deviceType
        ];
        ResponseHandler::sendSuccessResponse($responseData);
    }
}