<?php

namespace api\Models;


class DeviceToken
{

    const DEVICE_TYPE_ANDROID = 'android';
    const DEVICE_TYPE_IOS = 'ios';

    public static function checkType($type)
    {
        return ($type == self::DEVICE_TYPE_ANDROID || $type == self::DEVICE_TYPE_IOS);
    }
}