<?php
namespace App\Services;
use Illuminate\Http\UploadedFile;

final class fileStore{
    public static function save(UploadedFile $file): string
{

/** @var string */

$path = $file->store('contract');

return $path;

}

}
