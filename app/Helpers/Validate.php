<?php

namespace App\Helpers;

class Validate
{
    /**
     * Validate RSA ID.
     *
     * @param mixed $rsa_id
     * @return bool
     */
    public static function RSAID($rsa_id)
    {
        return (bool) preg_match('/([0-9][0-9])(([0][1-9])|([1][0-2]))(([0-2][0-9])|([3][0-1]))([0-9])([0-9]{3})([0-1])([0-9])([0-9])/', strval($rsa_id));
    }

    /**
     * Validate email address.
     *
     * @param string $email
     * @param bool $check_dns
     * @return bool
     */
    public static function email(string $email, bool $check_dns = false)
    {
        $valid = (bool) filter_var($email, FILTER_VALIDATE_EMAIL);

        if ($valid && $check_dns) {
            $hostname = explode('@', $email)[1];
            return checkdnsrr($hostname, 'MX');
        }

        return $valid;
    }
}
