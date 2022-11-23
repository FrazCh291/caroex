<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

final class SaveAttachment
{
    public static function save(UploadedFile $file): string
    {
        $path = $file->store('docs');
        return $path;
    }
}
