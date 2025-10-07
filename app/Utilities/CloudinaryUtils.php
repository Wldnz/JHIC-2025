<?php
namespace App\Utilities;

class CloudinaryUtils {

    /**
     * Extract the public ID from a Cloudinary URL.
     *
     * @param string $url The Cloudinary URL.
     * @return string|null The public ID if found, null otherwise.
     */
    public static function getPublicIdByCloudinaryUrl($url) {
        $matches = [];
        $pattern = "/([^\/]+)(?=\.(?:jpe?g|png|webp|gif)$)/i";

        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Checks if a given URL is a Cloudinary URL.
     *
     * @param string $url The URL to check.
     * @return bool True if the URL is a Cloudinary URL, false otherwise.
     */
    public static function isCloudinaryUrl($url) {
        return strpos($url, "res.cloudinary.com") !== false;
    }
}

?>
