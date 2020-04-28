<?php

namespace Tir\Setting\Entities;

use Tir\Crud\Support\Eloquent\TranslationModel;


class SettingTranslation extends TranslationModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['value'];
}
