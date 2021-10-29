<?php

namespace Tir\Setting\Entities;

use Tir\Crud\Support\Facades\Crud;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Tir\Crud\Support\Eloquent\BaseModel;
use Tir\Crud\Support\Eloquent\IsTranslatable;
use Tir\Crud\Support\Scaffold\Fields\Text;

class Setting extends BaseModel
{
    use IsTranslatable;

    
    protected $casts = [
        'value' => 'array',
    ];

    protected $table = 'settings';

    public function setFields():array
    {
        return [
                Text::make('setting1'),
                Text::make('setting2')
        ];
    }


    public function setModuleName():string
    {
        return 'setting';
    }
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'value'];


    /**
     * This function return array for validation
     *
     * @return array
     */
    public function getValidation()
    {
        return [
            'key' => 'required'
        ];
    }




    //functions /////////////////////////////////////////////////


    /**
     * Get all settings with cache support.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function allCached()
    {
        return Cache::tags(['settings'])->rememberForever('settings.all:' . App::currentLocale(), function () {
            return self::all()->mapWithKeys(function ($setting) {
                return [$setting->key => $setting->value];
            });
        });
    }



    /**
     * Get setting for the given key.
     *
     * @param string $key
     * @param mixed $default
     * @return string|array
     */
    public static function get($key, $default = null)
    {
        return static::where('key', $key)->first()->value() ?? $default;
    }








    // /**
    //  * Set the given settings.
    //  *
    //  * @param array $settings
    //  * @return void
    //  */
    // public static function setMany($settings)
    // {
    //     foreach ($settings as $key => $value) {
    //         self::set($key, $value);
    //     }
    // }

  
    // /**
    //  * Set a translatable settings.
    //  *
    //  * @param array $settings
    //  * @return void
    //  */
    // public static function setTranslatableSettings($settings = [])
    // {
    //     foreach ($settings as $key => $value) {
    //         static::updateOrCreate(['key' => $key], [
    //             'is_translatable' => true,
    //             'value' => $value,
    //         ]);
    //     }
    // }

    // //Mutators ////////////////////////////////////////////////////////////////////////////////////////////////////////

    // /**
    //  * Get the value of the setting.
    //  *
    //  * @return mixed
    //  */
    // public function getValueAttribute()
    // {
    //     if ($this->is_translatable) {
    //         return $this->translateOrDefault(Crud::locale())->value ?? null;
    //     }

    //     return $this->plain_value;
    // }


}
