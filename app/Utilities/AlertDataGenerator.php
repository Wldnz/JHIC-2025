<?php
namespace App\Utilities;

use App\AlertType;

abstract class AlertDataGenerator {
    /**
     * Generates an alert data array from given type, title and message.
     *
     * @param  AlertType $type
     * @param  string $title
     * @param  string $message
     * @return array
     */
    public static function generateAsArray(AlertType $type, string $title, string $message) {
        return [
            'type' => $type->name,
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
    public static function generateToArray(AlertType $type, string $title, string $message, array $array = []) {
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
    public static function generateAsSplattarableArray(AlertType $type, string $title, string $message) {
        return [
            'alert' => [
                'type' => $type->name,
                'title' => $title,
                'message' => $message,
            ]
        ];;
    }
}

?>
