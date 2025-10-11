<?php
namespace App\Utilities;

use Illuminate\Http\Request;

class FileUploadUtils
{
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
}
