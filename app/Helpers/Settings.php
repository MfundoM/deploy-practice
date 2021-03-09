<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Settings (INCOMPLETE)
 *
 * @package App\Helpers
 */
// TODO: Finish working on this class.
class Settings
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
     * Supported data types.
     *
     * @var array $types
     */
    protected static $types = [
        'array',
        'bool',
        'currency',
        'date',
        'float',
        'integer',
        'json',
        'object',
        'string',
    ];

    /**
     * Get a value from a Settings collection.
     *
     * @param \Illuminate\Database\Eloquent\Collection $settings
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public static function get(Collection $settings, string $key, $default = null)
    {
        $setting = $settings->where('key', $key)->first() ?? null;

        return $setting->value ?? $default ?? $setting->default ?? null;
    }

    /**
     * Get value for data type.
     *
     * @param mixed|null $value
     * @param string $type
     * @return mixed|null
     */
    public static function getValueForType($value = null, string $type = 'string')
    {
        if (empty($value)) {
            return null;
        }

        switch ($type) {
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
     * Set value for data type.
     *
     * @param $value
     * @param string $type
     * @return mixed
     */
    public static function setValueForType($value, string $type = 'string')
    {
        switch ($type) {
            case static::JSON:
            case static::OBJECT:
            case static::ARRAY:
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
