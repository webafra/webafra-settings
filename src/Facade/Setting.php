<?php
namespace Webafra\LaravelSetting\Facade;

use Illuminate\Support\Facades\Facade;

class Setting extends Facade {

    /**
     * The name of the binding in the IoC container.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Webafra\LaravelSetting\Setting::class;
    }
}
