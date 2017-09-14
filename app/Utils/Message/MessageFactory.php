<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 8/8/16
 * Time: 12:34 AM
 */

namespace App\Utils\Message;


use Exception;

class MessageFactory
{
    private static $errors = [
        200 => 'green',
        400 => 'orange',
    ];

    /**
     * @param string[] $messages
     * @param int $code
     * @param array $data
     * @param bool $json
     * @return array|string
     */
    public static function create($messages, $code, $data = [], $json = false)
    {
        $color = '';
        try {
            $color = self::$errors[$code];
        } catch (Exception $e) {
            $color = 'red';
        }
        $resultMessages = [];
        foreach ($messages as $message => $parameters) {
            if (gettype($parameters) === "array")
                $resultMessages[] = trans($message, $parameters);
            else
                $resultMessages[] = trans($parameters);
        }
        $data['message'] = [
            'messages' => $resultMessages,
            'color' => $color,
            'code' => $code
        ];
        return $json ? json_encode($data) : $data;
    }

    public static function createWithValidationMessages($messages, $code, $data = [], $json = false)
    {
        $resultArray = [];
        foreach ($messages as $key => $value) {
            $resultArray[] = $value[0];
        }
        return self::create($resultArray, $code, $data, $json);
    }
}