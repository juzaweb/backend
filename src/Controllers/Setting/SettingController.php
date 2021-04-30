<?php

namespace Tadcms\Backend\Controllers\Setting;

use Illuminate\Http\Request;
use Tadcms\Backend\Controllers\BackendController;
use Tadcms\EmailTemplate\EmailService;
use Illuminate\Support\Facades\Auth;

class SettingController extends BackendController
{
    public function index($form = 'general')
    {
        $languages = trans('tadcms::languages');
        $forms = $this->getForms();
        return view('tadcms::setting.index', [
            'title' => trans('tadcms::app.general-setting'),
            'component' => $form,
            'forms' => $forms,
            'languages' => $languages,
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
        
        return $this->success(trans('tadcms::app.save-successfully'));
    }

    public function sendTestMail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->post('email');
        EmailService::make()
            ->setEmails($email)
            ->setSubject('Send email test for {name}')
            ->setBody('Hello {name}, This is the test email')
            ->setParams(['name' => Auth::user()->name])
            ->send();

        return $this->success(trans('tadcms::app.save-successfully'));
    }

    protected function getForms()
    {
        $items = [
            'general' => [
                'name' => trans('tadcms::app.general-setting'),
                'view' => 'tadcms::setting.components.general'
            ],
            'email' => [
                'name' => trans('tadcms::app.email-setting'),
                'view' => 'tadcms::setting.components.email'
            ]
        ];

        return apply_filters('admin.general_settings.forms', $items);
    }

    protected function getSettings()
    {
        $items = [
            'sitename',
            'sitedescription',
            'language',
            'users_can_register',
            'user_confirmation',
            'siteurl',
            'email_setting',
            'email_host',
            'email_port',
            'email_encryption',
            'email_username',
            'email_password',
            'email_from_address',
            'email_from_name',
        ];
        
        return apply_filters('admin.general_settings', $items);
    }
}
