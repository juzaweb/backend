<?php

namespace Tadcms\Backend\Controllers\Setting;

use Tadcms\Backend\Controllers\BackendController;
use Illuminate\Http\Request;

class EmailController extends BackendController
{
    public function index()
    {
        return view('tadcms::setting.email', [
            'title' => trans('tadcms::app.email-setting'),
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
            route('admin.setting.email')
        );
    }
    
    protected function getSettings()
    {
        return [
            'email_host',
            'email_port',
            'email_encryption',
            'email_username',
            'email_password',
            'email_from_address',
            'email_from_name',
        ];
    }
}