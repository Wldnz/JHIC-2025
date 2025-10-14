<?php

namespace App\Helpers;

class SplittedFileUploadList
{
    public function __construct(
        public array $addedFilesData = [],
        public array $notAddedFilesData = [],
        public array $updatedFilesData = [],
    ) {}
}
