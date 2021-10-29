<?php

namespace Tir\Setting\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;

use Tir\Setting\Entities\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Tir\Crud\Controllers\CrudController;

class AdminSettingController extends CrudController
{

    protected function SetModel():string
    {
        return Setting::class;
    }

    /**
     * This function update crud and relations
     * @param Request $request
     * @param $item
     */
    public function saveSetting(Request $request)
    {
        foreach($request->except('_method', '_token', 'locale') as $key => $value){      
            $this->model->updateOrCreate(['key'=> $key],['value' => $value ]);
        }

        $message = trans('setting::panel.setting-saved'); //translate message

        return Response::Json(
            [
                'saved' => true,
                'message'    => $message,
            ]
            , 200);

    }

    /**
     * This function update crud and relations
     * @param Request $request
     * @param $item
     */
    public function editSetting($locale)
    {
        request()->merge(['locale' => $locale]);
        $keys = Arr::pluck($this->model->getEditFields(),'name');
        $setting = $this->model->whereIn('key',$keys)->pluck('value','key');
        $fields = $this->model->getEditFields();
        foreach($fields as $field){
            if(isset($setting[$field->name])){
                $field->value = $setting[$field->name];
            }
        }

        return Response::Json($fields, 200);

    }


}

