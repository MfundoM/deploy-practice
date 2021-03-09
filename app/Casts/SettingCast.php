<?php

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class SettingCast implements CastsAttributes
{
    /** @var string */
    const ARRAY = 'array';

    /** @var string */
    const BOOL = 'bool';

    /** @var string */
    const CURRENCY = 'currency';

    /** @var string */
    const DATE = 'date';

    /** @var string */
    const FLOAT = 'float';

    /** @var string */
    const INTEGER = 'integer';

    /** @var string */
    const JSON = 'json';

    /** @var string */
    const OBJECT = 'object';

    /** @var string */
    const STRING = 'string';

    /**
     * Cast the given value.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return mixed
     */
    public function get($model, $key, $value, $attributes)
    {
        if (empty($value)) {
            return null;
        }

        switch ($attributes['type']) {
            case static::ARRAY:
            case static::JSON:
                return json_decode($value, true);

            case static::BOOL:
                return boolval($value);

            case static::CURRENCY:
                return number_format(floatval($value), 2);

            case static::DATE:
                return Carbon::parse($value);

            case static::FLOAT:
                return floatval($value);

            case static::INTEGER:
                return intval($value);

            case static::OBJECT:
                return json_decode($value, false);

            case static::STRING:
            default:
                return strval($value);
        }
    }

    /**
     * Prepare the given value for storage.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param array $value
     * @param array $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        if (!isset($attributes['type'])) {
            throw new \Exception('No "type" specified. Place the "type" attribute first in the array when creating.');
        }

        switch ($attributes['type']) {
            case static::ARRAY:
            case static::OBJECT:
            case static::JSON:
                return json_encode($value);

            case static::BOOL:
                return boolval($value) ? '1' : '0';

            case static::CURRENCY:
                return strval(floatval($value));

            case static::DATE:
                return is_string($value) ? Carbon::parse($value)->toDateTimeString() : $value->toDateTimeString();

            case static::FLOAT:
                return strval(floatval($value));

            case static::INTEGER:
                return strval(intval($value));
        }

        try {
            $value = strval($value);
        } catch (\Exception $exception) {
            $value = null;
        }

        return $value;
    }
}
