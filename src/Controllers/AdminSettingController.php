<?php

namespace Tir\Setting\Controllers;

use Illuminate\Http\Request;
use Tir\Setting\Entities\Setting;

use Tir\Crud\Controllers\CrudController;
use Tir\Setting\Entities\StoreSettingTranslation;

class AdminSettingController extends CrudController
{
    protected $model = Setting::Class;

    /**
     * This function update crud and relations
     * @param Request $request
     * @param $item
     */
    public function updateSetting(Request $request)
    {

        foreach($request->except('_method', '_token','save_close','translatable') as $setting => $value){

            $setting = Setting::where('key',$setting)->first();

            if($setting != null)
            {
                $setting->update(['plain_value' => $value ]);
            }

        }

        //save translatable setting
        foreach( $request->input('translatable') as  $setting => $value){
            $setting = Setting::where('key',$setting)->first();
            if($setting != null)
            {
                $setting->update(['value' => $value]);

            }
        }

        return redirect()->back();

    }

    /**
     * This function update crud and relations
     * @param Request $request
     * @param $item
     */
    public function editSetting()
    {


        $settings = Setting::all();

        $item = (object)[];
        $translatable = [];

        foreach($settings as $setting){
            if($setting->is_translatable){
                $translatable[$setting->key] = $setting->value;

            }else{
                $item->{$setting->key} = $setting->value;
            }
        }


        $item->{'translatable'}= $translatable;
        return view("setting::admin.edit")->with(['crud'=>$this->crud, 'item'=>$item]);



    }

}

