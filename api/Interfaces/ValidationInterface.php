<?php

namespace api\Interfaces;
/**
 * Interface ValidationInterface
 */
interface ValidationInterface
{
    /**
     * @param $model
     * @return mixed
     */
    public function validate($model);
}