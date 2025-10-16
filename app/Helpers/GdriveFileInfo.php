<?php

namespace App\Helpers;

class GdriveFileInfo
{
    public function __construct(
        public mixed $file,
        public string $ext,
        public string $filename,
    ) {}
}
