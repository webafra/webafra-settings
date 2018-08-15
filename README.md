#Laravel Setting

install via composer

`composer require webafra/larasetting`

Add Service Provider to `config/app.php` providers array:
```php
'providers' => [
    ....
    Webafra\LaraSetting\LaraSettingServiceProvider::class,
]
```

And add alias to aliases array:
```php
'aliases' => [
    ...
    'Setting' => Webafra\LaraSetting\Facade\Setting::class,
]
```

**Usage**
```php
<?php
namespace App\Http\Controllers;

use Webafra\LaraSetting\Facade\Setting;

class SettingController extends Controller {
    public function index(){
        #Set a Setting property:
        Setting::set('key', 'value');
        
        #Set a Setting property and Set is_primary:
        Setting::set('key', 'value', true);
        
        #Get a Stored Setting value or pass default value
        $setting['key'] = Setting::get('key', 'default value');
    }
    
    public function store(\Request $request){
        #get all settings from an key-value array and store them to database
        #example: <input type="text" name="setting['title']">
        Setting::store($request->input('setting'));
        
        
        #get all settings from an key-value and is primary data array and store them to database
        #example: <input type="text" name="setting['title']">
        Setting::storePrimary($request->input('setting'));
    }
}
```