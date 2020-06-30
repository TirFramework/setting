<?php

namespace Tir\Setting\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\Cache;
use Tir\Crud\Support\Eloquent\CrudModel;
use Tir\Crud\Support\Facades\Crud;

class Setting extends CrudModel
{
    //Additional trait insert here

    use Translatable;

    /**
     * The attribute show route name
     * and we use in fieldTypes and controllers
     *
     * @var string
     */
    public static $routeName = 'setting';

    public  $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'is_translatable', 'plain_value'];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_translatable' => 'boolean',
        'plain_value' => 'array'

    ];


    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['value'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];


    /**
     * This function return array for validation
     *
     * @return array
     */
    public function getValidation()
    {
        return [
            'key' => 'required',
            'plain_value' => 'required'
        ];
    }


    /**
     * This function return an object of field
     * and we use this for generate admin panel page
     * @return Object
     */
    public function getFields()
    {



        $fields = [
        ];

        return $fields;
    }





    //functions /////////////////////////////////////////////////


    /**
     * Get all settings with cache support.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function allCached()
    {
        return Cache::tags(['settings'])->rememberForever('settings.all:' . Crud::locale(), function () {
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

    /**
     * Set the given settings.
     *
     * @param array $settings
     * @return void
     */
    public static function setMany($settings)
    {
        foreach ($settings as $key => $value) {
            self::set($key, $value);
        }
    }

    /**
     * Set the given setting.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        if ($key === 'translatable') {
            return static::setTranslatableSettings($value);
        }
        static::updateOrCreate(['key' => $key], ['plain_value' => $value]);
    }

    /**
     * Set a translatable settings.
     *
     * @param array $settings
     * @return void
     */
    public static function setTranslatableSettings($settings = [])
    {
        foreach ($settings as $key => $value) {
            static::updateOrCreate(['key' => $key], [
                'is_translatable' => true,
                'value' => $value,
            ]);
        }
    }

    //Mutators ////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get the value of the setting.
     *
     * @return mixed
     */
    public function getValueAttribute()
    {
        if ($this->is_translatable) {
            return $this->translateOrDefault(Crud::locale())->value ?? null;
        }

        return $this->plain_value;
    }


}
