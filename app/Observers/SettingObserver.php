<?php

namespace App\Observers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingObserver
{
    /**
     * Handle the setting "creating" event.
     *
     * @param \App\Models\Setting $setting
     * @return void
     */
    public function creating(Setting $setting)
    {
        //
    }

    /**
     * Handle the setting "created" event.
     *
     * @param \App\Models\Setting $setting
     * @return void
     */
    public function created(Setting $setting)
    {
        // Cache newly created Setting
        Setting::valueForKey($setting->key);
    }

    /**
     * Handle the setting "updating" event.
     *
     * @param \App\Models\Setting $setting
     * @return void
     */
    public function updating(Setting $setting)
    {
        //
    }

    /**
     * Handle the setting "updated" event.
     *
     * @param \App\Models\Setting $setting
     * @return void
     */
    public function updated(Setting $setting)
    {
        Cache::forget(sprintf('settings.key.%s', $setting->key));
    }

    /**
     * Handle the setting "deleting" event.
     *
     * @param \App\Models\Setting $setting
     * @return void|bool
     */
    public function deleting(Setting $setting)
    {
        Cache::forget(sprintf('settings.key.%s', $setting->key));
    }

    /**
     * Handle the setting "deleted" event.
     *
     * @param \App\Models\Setting $setting
     * @return void
     */
    public function deleted(Setting $setting)
    {
        if ($setting->key ?? null) {
            Cache::forget(sprintf('settings.key.%s', $setting->key));
        }
    }

    /**
     * Handle the setting "restored" event.
     *
     * @param \App\Models\Setting $setting
     * @return void
     */
    public function restored(Setting $setting)
    {
        Cache::forget(sprintf('settings.key.%s', $setting->key));
    }

    /**
     * Handle the setting "force deleted" event.
     *
     * @param \App\Models\Setting $setting
     * @return void
     */
    public function forceDeleted(Setting $setting)
    {
        if ($setting->key ?? null) {
            Cache::forget(sprintf('settings.key.%s', $setting->key));
        }
    }
}
