<?php
namespace App\Utilities;

use App\Helpers\SplittedFileUploadList;
use Illuminate\Http\Request;

class FileUploadUtils
{
    /**
     * Gets all the added file uploads from a request.
     *
     * @param Request $request The request object.
     * @param string $fieldName The field name to get the file uploads from. Defaults to 'images'.
     * @param string $prefix The prefix to check for to determine if the file is added. Defaults to 'added_'.
     *
     * @return array The array of added file uploads.
     */
    public static function getAddedFileUpload(Request $request, string $fieldName = 'images', string $prefix = 'added_')
    {
        $results = [];

        if ($request->has($fieldName)) {
            foreach ($request[$fieldName] as $fileKey => $file) {
                if (!str_starts_with($fileKey, $prefix)) {
                    continue;
                }
                $results[] = $file;
            }
        }

        return $results;
    }

    /**
     * Gets all the not added file uploads from a request.
     *
     * @param Request $request The request object.
     * @param string $fieldName The field name to get the file uploads from. Defaults to 'images'.
     * @param string $prefix The prefix to check for to determine if the file is not added. Defaults to 'added_'.
     *
     * @return array The array of not added file uploads.
     */
    public static function getNotAddedFileUpload(Request $request, string $fieldName = 'images', string $prefix = 'added_')
    {
        $results = [];

        if ($request->has($fieldName)) {
            foreach ($request[$fieldName] as $fileKey => $file) {
                if (str_starts_with($fileKey, $prefix)) {
                    continue;
                }
                $results[] = $file;
            }
        }

        return $results;
    }

    public static function splitFileUploads(Request $request, string $fieldName = 'images', string $addedPrefix = 'added_', string $fileFieldKey = 'file') {
        if (!$request->has($fieldName)) {
            return null;
        }

        $added = [];
        $notAdded = [];
        $updated = [];

        foreach ($request[$fieldName] as $fileDataKey => $fileData) {
            if (str_starts_with($fileDataKey, $addedPrefix)) {
                $added[$fileDataKey] = $fileData;
            } else {
                $notAdded[$fileDataKey] = $fileData;
                if ($fileData[$fileFieldKey] ?? false) {
                    $updated[$fileDataKey] = $fileData;
                }
            }
        }

        return new SplittedFileUploadList($added, $notAdded, $updated);
    }
}
