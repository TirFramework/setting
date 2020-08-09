<?php

namespace Tir\Setting\Controllers;

use Illuminate\Http\Request;
use Tir\Setting\Entities\Setting;

use Tir\Crud\Controllers\CrudController;
use Illuminate\Support\Facades\Redirect;

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

        foreach($request->except('_method', '_token','save_edit','translatable') as $key => $value){

            $setting = Setting::where('key',$key)->first();

            if($setting != null)
            {
                $setting->update(['plain_value' => $value ]);
            }else{
                Setting::create(['key'=>$key, 'plain_value' => $value ]);
            }

        }

        //save translatable setting
        foreach( $request->input('translatable') as  $key => $value){
            $setting = Setting::where('key',$key)->first();
            if($setting != null)
            {
                $setting->update(['value' => $value]);
            }else{
                Setting::create(['key'=>$key, 'value' => $value , 'is_translatable' => 1 ] );
            }
        }

        return Redirect::to(route("setting.update"))->with('tab', $request->input('tab'));
        // return redirect()->back();

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

