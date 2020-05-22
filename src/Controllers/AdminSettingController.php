<?php

namespace Tir\Setting\Controllers;

use Illuminate\Http\Request;
use Tir\Setting\Entities\Setting;

use Tir\Crud\Controllers\CrudController;
use Tir\Setting\Entities\SettingTranslation;

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

        
        //update item

        // return $request->all();


        // $setting = Setting::where('key','store_name')->first();

        // $setting->translations->where('locale',config('app.locale'))->update(['value',$value]);


        // dd();

        // dd($request->except('method', '_token'));
        foreach($request->except('_method', '_token','save_close','translatable') as $setting => $value){
            
            $setting = Setting::where('key',$setting)->first();
            
            if($setting != null)
            {
                $setting->update(['plain_value' => $value ]);                
            }

        }

        foreach( $request->input('translatable') as  $setting => $value){
            $setting = Setting::where('key',$setting)->first();
            if($setting != null)
            {
                $settingTranslation = settingTranslation::where('setting_id', $setting->id)->where('locale',config('app.locale'))->first();                

                if($settingTranslation){
                    $settingTranslation->update(['value' => $value]);
                } else {
                    settingTranslation::create(['value' => $value , 'setting_id' => $setting->id, 'locale' => config('app.locale') ]);
                }

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
                //array_push($translatable, [$setting->key => $setting->value]);
             
            }else{
                $item->{$setting->key} = $setting->value;
            }
        }

        //$item = json_decode(json_encode($item));

        $item->{'translatable'}= $translatable;

     // return dd($item);

        return view("setting::admin.edit")->with(['crud'=>$this->crud, 'item'=>$item]);



    }

}


class settings {

   // public $translatable;

        
}
