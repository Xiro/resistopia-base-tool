<?php


namespace app\helpers;


use yii\helpers\Json;

class JsonResponse
{

    /**
     * @param string $message
     * @param array $data
     * @return string
     */
    public static function success($message, array $data = array())
    {
        return self::message("success", $message, $data);
    }

    /**
     * @param string $message
     * @param array $data
     * @return string
     */
    public static function error($message, array $data = array())
    {
        return self::message("error", $message, $data);
    }

    /**
     * @param string $message
     * @param array $data
     * @return string
     */
    public static function skipped($message, array $data = array())
    {
        return self::message("skipped", $message, $data);
    }

    /**
     * @param array $errors
     * @return string
     */
    public static function validationError(array $errors = array())
    {
        return Json::encode([
            "status"  => "validation-error",
            "validationData" => $errors
        ]);
    }

    /**
     * @param string $status
     * @param string $message
     * @param array $data additional data that will be merged to response
     * @return string Json string response
     */
    public static function message($status, $message, array $data = array())
    {
        return Json::encode(array_merge([
            "status"  => $status,
            "message" => $message
        ], $data));
    }

}