<?php

namespace Tir\Setting\Controllers;

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

        foreach($request->except('_method', '_token') as $key => $value){
                        
            $setting = Setting::where('key',$key)->first();
            
            if($setting != null)
            {
                $setting->update(['value' => $value ]);
            }else{
                Setting::create(['key'=>$key, 'value' => $value]);
            }

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
    public function editSetting($locale, $key)
    {
        $setting = Setting::where('key',$key)->first();

        return Response::Json($setting, 200);

    }


}

