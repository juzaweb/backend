<?php

namespace Tadcms\Backend\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Tadcms\System\Models\Config as ModelConfig;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (!Schema::hasTable('configs'))
        {
            return;
        }
        
        $mail = ModelConfig::getConfigEmail();
        
        if ($mail['email_setting']) {
            $config = [
                //'driver'     => $mail['email_driver'],
                'host'       => $mail['email_host'],
                'port'       => (int) $mail['email_port'],
                'from'       => [
                    'address'   => $mail['email_from_address'],
                    'name'      => $mail['email_from_name']
                ],
                'encryption' => $mail['email_encryption'],
                'username'   => $mail['email_username'],
                'password'   => $mail['email_password'],
            ];
            
            Config::set('mail', $config);
        }
    }
}