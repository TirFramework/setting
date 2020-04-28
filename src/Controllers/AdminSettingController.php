<?php

namespace Tir\Setting\Controllers;

use Tir\Setting\Entities\Setting;

use Tir\Crud\Controllers\CrudController;

class AdminSettingController extends CrudController
{
    protected $model = Setting::Class;

}
