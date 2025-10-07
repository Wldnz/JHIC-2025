<?php
namespace App\Utilities;

use App\AlertType;
use Illuminate\Contracts\Session\Session;

abstract class AlertDataGenerator
{
    protected static $alertKey = 'alert';

    /**
     * Generates an alert data array from given type, title and message.
     *
     * @param  AlertType $type
     * @param  string $title
     * @param  string $message
     * @return array
     */
    public static function generateAsArray(AlertType $type, string $title, string $message)
    {
        return [
            'type' => $type->value,
            'title' => $title,
            'message' => $message,
        ];
    }

    /**
     * Generates an alert data array from given type, title and message, and merges it with given array.
     *
     * @param  AlertType $type
     * @param  string $title
     * @param  string $message
     * @param  array $array
     * @return array
     */
    public static function generateToArray(AlertType $type, string $title, string $message, array $array = [])
    {
        $array['alert'] = [
            'type' => $type,
            'title' => $title,
            'message' => $message,
        ];
        return $array;
    }

    /**
     * Generates an alert data array from given type, title and message, and returns it as an array that can be splattared.
     *
     * @param  AlertType $type
     * @param  string $title
     * @param  string $message
     * @return array
     */
    public static function generateAsSplattarableArray(AlertType $type, string $title, string $message)
    {
        return [
            'alert' => [
                'type' => $type->value,
                'title' => $title,
                'message' => $message,
            ]
        ];
        ;
    }

    /**
     * Generates an alert data array from given type, title and message, and stores it into the given session with the given key.
     *
     * @param  AlertType $type
     * @param  string $title
     * @param  string $message
     * @param  Session $session
     * @param  bool $overwrite
     * @return Session
     */
    public static function generateAsFlashToSession(AlertType $type, string $title, string $message, Session $session, bool $overwrite = true)
    {
        if (!$overwrite && $session->has(self::$alertKey)) return $session;

        $session->flash(self::$alertKey, [
            'type' => $type->value,
            'title' => $title,
            'message' => $message
        ]);
        return $session;
    }

    /**
     * Gets the key to be used when storing the alert data into the array/object/json data.
     *
     * @return string
     */
    public static function getAlertKey()
    {
        return self::$alertKey;
    }
}

?>
