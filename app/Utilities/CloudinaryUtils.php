<?php
namespace App\Utilities;

use Illuminate\Http\UploadedFile;

class CloudinaryUtils
{
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

    /**
     * Uploads a given image file to Cloudinary and returns the uploaded URL.
     *
     * @param UploadedFile $file The image file to upload.
     * @return string The uploaded URL.
     */
    public static function uploadImageFile(UploadedFile $file) {
        $uploadedUrl = cloudinary()->uploadApi()->upload($file->getRealPath())['secure_url'];
        return $uploadedUrl;
    }

    /**
     * Replaces an image file in Cloudinary.
     *
     * @param UploadedFile $file The new image file to upload.
     * @param string $publicId The public ID of the image to replace.
     * @return string|null The URL of the uploaded image file, or null if the replacement failed.
     */
    public static function replaceImageFile(UploadedFile $file, string $publicId) {
        $response = cloudinary()->uploadApi()->destroy($publicId);
        if ($response['result'] !== 'ok') {
            return null;
        }

        $uploadedUrl = cloudinary()->uploadApi()->upload($file->getRealPath())['secure_url'];
        return $uploadedUrl;
    }

    /**
     * Deletes an image file in Cloudinary.
     *
     * @param string $publicId The public ID of the image file to delete.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public static function deleteImageFile(string $publicId) {
        $response = cloudinary()->uploadApi()->destroy($publicId);
        return $response['result'] !== 'ok';
    }
}

?>
