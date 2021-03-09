<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Gravatar
{
    /**
     * Gravatar domain name.
     * (Gravatar has a few different domains)
     *
     * @var string $domain
     */
    protected static $domain = 'secure.gravatar.com';

    /**
     * Local avatar placeholder.
     *
     * @var string $placeholder
     */
    protected static $placeholder = '/images/avatars/placeholder.png';

    /**
     * Get Gravatar avatar.
     *
     * @param string|null $email
     * @param int $size
     * @param bool $check
     * @return string
     */
    public static function get(?string $email, int $size = 256, bool $check = true) : string
    {
        if (!$email) {
            return static::$placeholder;
        }

        $hashed = strlen($email) === 32 && strpos($email, '@') === false;

        $md5 = $hashed ? $email : md5(strtolower($email));
        $url = sprintf('https://%s/avatar/%s?s=%d', static::$domain, $md5, $size);

        if (!$check) {
            return $url;
        }

        $key = sprintf('avatars.%s.%d', $md5, $size);

        return Cache::remember($key, now()->addWeeks(2), function () use ($email, $size, $md5, $url) {
            return static::exists($email) ? sprintf($url, $md5, $size) : static::$placeholder;
        });
    }

    /**
     * Check if user has a Gravatar.
     *
     * @param string $email
     * @return bool
     */
    public static function exists(string $email) : bool
    {
        $check_url = sprintf('https://%s/avatar/%s?d=404', static::$domain, md5($email));

        return !Http::head($check_url)->failed();
    }
}
