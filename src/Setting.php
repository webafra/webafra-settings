<?php

namespace Webafra\LaraSetting;

use Webafra\LaraSetting\Model\Setting as SettingModel;
use Illuminate\Support\Facades\Cache;

class Setting
{

    public function set($key, $value, $is_primary = false)
    {
        if (\Cache::has('setting_' . $key)) {
            Cache::forget('setting_' . $key);
        }

        $setting = SettingModel::updateOrCreate([
            'key' => $key
        ], [
            'value' => $value,
            'is_primary' => $is_primary,
        ]);

        Cache::forever('setting_' . $key, $value);

        return $value;
    }

    public function get($key, $default = null)
    {
        try {
            if (Cache::has('setting_' . $key)) {
                return Cache::get('setting_' . $key);
            }

            $setting = Cache::rememberForever('setting_' . $key, function () use ($key) {
                return SettingModel::where('key', $key)->firstOrFail()->value;
            });

            return $setting->value;

        } catch (\Exception $e) {
            return $default;
        }
    }

    public function getPrimary($default = null)
    {
        try {
            if (Cache::has('setting_primary')) {
                return Cache::get('setting_primary');
            }

            $settings = Cache::rememberForever('setting_primary', function () {
                return SettingModel::where('is_primary', true )->pluck('value', 'key')->toArray();
            });

            return $settings;

        } catch (\Exception $e) {
            return $default;
        }
    }

    public function store($setting)
    {
        $i = 0;
        foreach($setting as $key => $value) {
            $this->set($key, $value);
            $i++;
        }
        return $i;
    }

    public function storePrimary($setting)
    {
        $i = 0;
        foreach($setting as $key => $value) {
            $this->set($key, $value, true);
            $i++;
        }
        return $i;
    }


    public function clean($setting)
    {
        Cache::forget('setting_primary');
    }



}