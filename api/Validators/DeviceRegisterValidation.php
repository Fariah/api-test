<?php

namespace api\Validators;


use api\BaseClass;
use api\Interfaces\ValidationInterface;
use api\Models\DeviceToken;

/**
 * Class DeviceRegisterValidation
 */
class DeviceRegisterValidation extends BaseClass implements ValidationInterface
{
    /**
     * @var array
     */
    protected $messages = [];

    /**
     * Main method for validation
     *
     * @param $model
     * @return array|mixed
     */
    public function validate($model)
    {
        // TODO Validation needs to be described, it's all only for testing
        if(isset($model->deviceTokenViewModel->token) && isset($model->deviceTokenViewModel->deviceType)) {

            if(!$model->deviceTokenViewModel->token) {
                $this->addError('token', 'token is required');
            }

            if(!$model->deviceTokenViewModel->deviceType) {
                $this->addError('deviceType', 'deviceType is required');
            }

            if(!DeviceToken::checkType($model->deviceTokenViewModel->deviceType)) {
                $this->addError('deviceType', 'deviceType is wrong');
            }

            if($this->checkIsTokenPresent($model->deviceTokenViewModel->token)) {
                $this->addError('token', 'token is already present in DB');
            }
        }

        if(!isset($model->deviceTokenViewModel)) {
            $this->addError('deviceTokenViewModel', 'deviceTokenViewModel is required');
        }
        if(!isset($model->deviceTokenViewModel->token)) {
            $this->addError('token', 'token is required');
        }
        if(!isset($model->deviceTokenViewModel->deviceType)) {
            $this->addError('deviceType', 'deviceType is required');
        }

        return $this->messages;
    }

    /**
     * Check if the token is present in DB
     *
     * @param $token
     * @return mixed
     */
    protected function checkIsTokenPresent($token)
    {
        $selectQuery = $this->db->prepare("SELECT token FROM device_tokens WHERE token = :token");
        $selectQuery->bindParam(':token', $token);
        $selectQuery->execute();

        return $selectQuery->fetchObject();
    }

    /**
     * Add error to Array
     *
     * @param $field
     * @param $message
     */
    protected function addError($field, $message)
    {
        $this->messages[$field][] = $message;
    }
}