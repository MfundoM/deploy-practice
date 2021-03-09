<?php

if (!function_exists('diskImage')) {
    /**
     * Get image from a disk listed in filesystem config.
     *
     * @param string|null $image
     * @param string $disk
     * @return string|null
     */
    function diskImage(?string $image, string $disk = 'public')
    {
        if ($image && (strpos($image, 'http') === 0 || strpos($image, '/') === 0)) {
            return $image;
        }

        $disk_array = config('filesystems.disks.' . $disk);

        if (is_array($disk_array)) {
            if ($image) {
                $storage = \Illuminate\Support\Facades\Storage::disk($disk);

                if ($storage->has($image)) {
                    return $storage->url($image);
                }
            }

            if ($placeholder = $disk_array['placeholder'] ?? null) {
                return $placeholder;
            }
        }

        return sprintf('https://via.placeholder.com/400x400.png?text=%s', urlencode(config('app.name')));
    }
}

if (!function_exists('fileSizeStr')) {
    /**
     * Convert to human-readable size.
     *
     * @param int $bytes
     * @return string
     */
    function fileSizeStr(int $bytes = 0)
    {
        if ($bytes >= 1000000000000) {
            return sprintf('%.2f TB', ($bytes / 1000000000000));

        } else if ($bytes >= 1000000000) {
            return sprintf('%.2f GB', ($bytes / 1000000000));

        } else if ($bytes >= 1000000) {
            return sprintf('%d MB', ceil($bytes / 1000000));

        } else if ($bytes >= 1000) {
            return sprintf('%d KB', ceil($bytes / 1000));

        } else {
            return sprintf('%d B', $bytes);
        }
    }
}

if (!function_exists('truncateNumber')) {
    /**
     * Truncate number and append string. Eg. 1.23M followers
     *
     * @param int $number
     * @param string|null $plural
     * @return string
     */
    function truncateNumber(int $number, string $plural = null)
    {
        if (!$plural) {
            if ($number >= 1000000) {
                return sprintf('%.1fM', $number / 1000000);

            } else if ($number >= 1000) {
                return sprintf('%.1fK', $number / 1000);
            }

            return $number;
        }

        $word = $number == 1 ? \Illuminate\Support\Str::singular($plural) : $plural;

        if ($number >= 1000000) {
            return sprintf('%.1fM %s', $number / 1000000, $word);

        } else if ($number >= 1000) {
            return sprintf('%.1fK %s', $number / 1000, $word);
        }

        return sprintf('%d %s', $number, $word);
    }
}

if (!function_exists('truncateWords')) {
    /**
     * Truncate words for excerpts/blurbs.
     *
     * @param string|null $words
     * @param int $count
     * @return string|null
     */
    function truncateWords(?string $words, $count = 10)
    {
        if (empty($words)) {
            return null;
        }

        $word_parts = explode(' ', $words);

        if (count($word_parts) < $count) {
            return $words;
        }

        return implode(' ', array_slice($word_parts, 0, $count)) . '...';
    }
}

if (!function_exists('truncateString')) {
    /**
     * @param string|null $string
     * @param int $length
     * @return string|null
     */
    function truncateString(?string $string, $length = 10)
    {
        if (empty($string)) {
            return null;
        }

        if (strlen($string) > $length) {
            return substr($string, 0, $length) . '...';
        }

        return $string;
    }
}

if (!function_exists('randomString')) {
    /**
     * Random string with numbers, upper and lower case letters.
     *
     * @param int $length
     * @param bool $capitals
     * @return string
     */
    function randomString(int $length = 64, bool $capitals = true)
    {
        $characters = $capitals
            ? '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
            : '0123456789abcdefghijklmnopqrstuvwxyz';

        $characters_length = strlen($characters);
        $random_string = '';

        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, $characters_length - 1)];
        }

        return $random_string;
    }
}

if (!function_exists('randomColor')) {
    /**
     * Random color hex code.
     *
     * @param bool $with_hash
     * @return string
     */
    function randomColor(bool $with_hash = false)
    {
        $hex = '';

        do {
            $hex .= str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
        } while (strlen($hex) < 6);

        return $with_hash ? sprintf('#%s', $hex) : $hex;
    }
}

if (!function_exists('urlStatusCode')) {
    /**
     * Status code for an HTTP call to a certain URL.
     *
     * @param string $url
     * @return int
     */
    function urlStatusCode(string $url)
    {
        $headers = get_headers($url);

        $code = substr($headers[0], 9, 3);

        return intval($code);
    }
}

if (!function_exists('iconForBool')) {
    /**
     * Red/green bullet icon. (FontAwesome & Bootstrap needed)
     *
     * @param bool $bool
     * @return string|null
     */
    function iconForBool(bool $bool)
    {
        return sprintf('<i class="fas fa-fw fa-circle text-%s"></i>', $bool ? 'success' : 'danger');
    }
}
