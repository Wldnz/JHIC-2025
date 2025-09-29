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
}

?>
