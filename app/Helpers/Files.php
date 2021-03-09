<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class Files
{
    /**
     * Save file to storage.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $disk
     * @param bool $encrypt
     * @return string|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Illuminate\Contracts\Encryption\EncryptException
     */
    public static function save(UploadedFile $file, string $disk, bool $encrypt = false)
    {
        $storage_path = Storage::disk($disk)->path('');

        $filename = sprintf('%s.%s', randomString(40), $file->getClientOriginalExtension());

        if (!Storage::exists($storage_path)) {
            Storage::makeDirectory($storage_path);
        }

        if ($encrypt) {
            $saved = Storage::disk($disk)->putFileAs(null, Crypt::encrypt($file->get()), $filename);
        } else {
            $saved = Storage::disk($disk)->putFileAs(null, $file->get(), $filename);
        }

        return $saved ? $filename : null;
    }

    /**
     * Get file from storage.
     *
     * @param string $filename
     * @param string $disk
     * @param bool $decrypt
     * @return mixed|string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Illuminate\Contracts\Encryption\DecryptException
     */
    public static function get(string $filename, string $disk, bool $decrypt = false)
    {
        $file = Storage::disk($disk)->get($filename);

        if ($decrypt) {
            $file = Crypt::decrypt($file);
        }

        return $file;
    }
}
