<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'type',
        'key',
        'value',
    ];

    /**
     * Types of storable values.
     *
     * @var array $types
     */
    public static $types = [
        'array'    => 'Array',
        'bool'     => 'Bool',
        'currency' => 'Currency',
        'date'     => 'Date',
        'float'    => 'Float',
        'integer'  => 'Integer',
        'json'     => 'JSON',
        'object'   => 'Object',
        'string'   => 'String',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array $casts
     */
    public $casts = [
        'value' => \App\Casts\SettingCast::class,
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * Get value for a key.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public static function valueForKey(string $key, $default = null)
    {
        $cache_key = sprintf('settings.key.%s', $key);

        return Cache::rememberForever($cache_key, function () use ($key) {
                return self::where('key', $key)->first()->value ?? null;
            }) ?? $default;
    }

    /**
     * Update value for key.
     *
     * @param string $key
     * @param mixed|null $value
     * @return bool
     */
    public static function updateKey(string $key, $value = null)
    {
        return self::where('key', $key)
            ->firstOrFail(['id', 'type', 'key'])
            ->update(['value' => $value]);
    }
}
