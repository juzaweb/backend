<?php

namespace Tadcms\Backend\Controllers\Setting;

use Illuminate\Http\Request;
use Tadcms\Backend\Controllers\BackendController;

class SettingController extends BackendController
{
    public function index()
    {
        return view('tadcms::setting.index', [
            'title' => trans('tadcms::app.general-setting'),
        ]);
    }
    
    public function save(Request $request)
    {
        $settings = $this->getSettings();
        
        foreach ($settings as $setting) {
            if ($request->has($setting)) {
                set_config($setting, $request->post($setting));
            }
        }
        
        return $this->success(
            trans('tadcms::app.save-successfully'),
            route('admin.setting')
        );
    }
    
    protected function getSettings()
    {
        $items = [
            'sitename',
            'sitedescription',
            'language',
        ];
        
        return apply_filters('admin.general_settings', $items);
    }
}
