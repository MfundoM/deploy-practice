<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Images
{
    /**
     * Store a resized image to fit specified size.
     *
     * @param string|null $filename
     * @param string $disk
     * @param int $width
     * @param int $height
     * @return string|null
     */
    public static function fit(?string $filename, string $disk = 'public', int $width = 512, int $height = 512)
    {
        if (!strlen($filename)) {
            return null;
        }

        $image_path = Storage::disk($disk)->path($filename);

        Image::make($image_path)->fit($width, $height, function ($constraint) {
            $constraint->upsize();
        })->save($image_path);

        return $image_path;
    }

    /**
     * Store a thumbnail and return thumb path.
     *
     * @param string|null $filename
     * @param string $disk
     * @param int $width
     * @param int $height
     * @param string $prefix
     * @return string|null
     */
    public static function createThumbnail(?string $filename, string $disk = 'public', int $width = 512, int $height = 512, string $prefix = 'thumb_')
    {
        if (!strlen($filename)) {
            return null;
        }

        $folder = Storage::disk($disk)->path(null);
        $thumb = $prefix . $filename;

        Image::make($folder . $filename)->fit($width, $height, function ($constraint) {
            $constraint->upsize();
        })->save($folder . $thumb);

        return $thumb;
    }
}
