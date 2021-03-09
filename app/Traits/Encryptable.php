<?php

namespace App\Traits;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

trait Encryptable
{
    /**
     * Decrypt data.
     *
     * @param $key
     * @return mixed|string
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (!empty($value) && in_array($key, $this->encryptable)) {
            try {
                $value = Crypt::decryptString($value);

            } catch (DecryptException $exception) {
                Log::error(sprintf('DecryptException: %s', $exception->getMessage()));
                $value = null;
            }
        }

        return $value;
    }

    /**
     * Encrypt data.
     *
     * @param $key
     * @param null $value
     * @return mixed
     */
    public function setAttribute($key, $value = null)
    {
        if (!empty($value) && in_array($key, $this->encryptable)) {
            try {
                $value = Crypt::encryptString($value);

            } catch (EncryptException $exception) {
                Log::error(sprintf('EncryptException: %s', $exception->getMessage()));
                $value = null;
            }
        }

        return parent::setAttribute($key, $value);
    }
}
