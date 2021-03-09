<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class DOM
{
    /**
     * Clean HTML string.
     *
     * @param string $html
     * @return string|null
     */
    public static function cleanHTML(string $html)
    {
        return preg_replace("/(\<[a-z]{1,}\:[a-z]{1,}\>|\<\/[a-z]{1,}\:[a-z]{1,}\>)/", '', $html);
    }

    /**
     * Remove <figcaption/> captions.
     * (Used for Nova Trix fields)
     *
     * @param string $html
     * @return false|string
     */
    public static function removeCaptions(string $html)
    {
        libxml_use_internal_errors(true);

        $html = static::cleanHTML($html);

        $dom = new \DOMDocument();
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Captions
        $captions = $dom->getElementsByTagName('figcaption');

        while (count($captions)) {
            foreach ($captions as $key => $caption) {
                $caption->parentNode->removeChild($caption);
            }
            $captions = $dom->getElementsByTagName('figcaption');
        }

        // Images
        $images = $dom->getElementsByTagName('img');

        if (count($images)) {
            foreach ($images as $key => $img) {
                $img->removeAttribute('height');
                $img->removeAttribute('width');
                $img->removeAttribute('style');
                $img->setAttribute('style', 'max-width: 100%;');
            }
        }

        $new_html = $dom->saveHTML();

        return $new_html ? trim($new_html) : $html;
    }

    /**
     * Change link targets from _self to _blank.
     *
     * @param string $html
     * @return false|string
     */
    public static function linksToBlank(string $html)
    {
        libxml_use_internal_errors(true);

        $html = static::cleanHTML($html);

        $dom = new \DOMDocument();
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $links = $dom->getElementsByTagName('a');

        if (count($links)) {
            foreach ($links as $key => $link) {
                $link->removeAttribute('target');
                $link->setAttribute('target', '_blank');
            }
        }

        $new_html = $dom->saveHTML();

        return $new_html ? trim($new_html) : $html;
    }

    /**
     * Replace base64 images with storage links.
     * (For Summernote only!)
     *
     * @param string $html
     * @param string $disk
     * @param bool $save
     * @return false|string
     */
    public static function replaceImages(string $html, string $disk, bool $save = false)
    {
        libxml_use_internal_errors(true);

        $html = static::cleanHTML($html);

        $dom = new \DOMDocument();
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Images
        $images = $dom->getElementsByTagName('img');

        if (count($images)) {
            $storage_path = Storage::disk($disk)->path('');

            if (!Storage::exists($storage_path)) {
                Storage::makeDirectory($storage_path);
            }

            foreach ($images as $key => $img) {
                $src = $img->getAttribute('src');

                if (strpos($src, 'data:') !== 0) {
                    continue;
                }

                $mime = 'data:image/jpeg;base64,';
                $extension = 'jpg';
                $extensions = [
                    'data:image/bmp;base64,'     => 'bmp',
                    'data:image/gif;base64,'     => 'gif',
                    'data:image/jpeg;base64,'    => 'jpg',
                    'data:image/png;base64,'     => 'png',
                    'data:image/svg+xml;base64,' => 'svg',
                    'data:image/tiff;base64,'    => 'tiff',
                ];

                foreach ($extensions as $data => $ext) {
                    if (strpos($src, $data) === 0) {
                        $mime = $data;
                        $extension = $ext;
                        break;
                    }
                }

                $iteration = 1;
                $file_name = $img->getAttribute('data-filename') ?? time();
                $file_name_hash = sha1($file_name);
                $image_name = sprintf('%s_%d_%d.%s', $file_name_hash, $iteration, $key, $extension);

                while (Storage::disk($disk)->exists($image_name)) {
                    $image_name = sprintf('%s_%d_%d.%s', $file_name_hash, $iteration, $key, $extension);
                    $iteration++;
                }

                if ($save) {
                    $src = str_replace($mime, '', $src);
                    Storage::disk($disk)->put($image_name, base64_decode($src));
                }

                $img->removeAttribute('src');
                $img->removeAttribute('style');
                $img->removeAttribute('data-filename');
                $img->setAttribute('src', Storage::disk($disk)->url($image_name));
                $img->setAttribute('style', 'max-width: 100%;');
            }
        }

        $new_html = $dom->saveHTML();

        return $new_html ? trim($new_html) : $html;
    }
}
